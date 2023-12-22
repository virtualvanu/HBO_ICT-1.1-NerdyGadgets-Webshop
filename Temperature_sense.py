# !!!place this file on your raspberri pi with sensehat!!!

from sense_hat import SenseHat      # Importeer sensehat voor temeratuursensor
import mysql.connector              # mysql.connector voor database
import time                         # Time voor de 3 seconden loop.

def temperature_to_db(): # Maak verbinding met sql database
    try:
        cnx = mysql.connector.connect(
            user='temperaturesensor',
            password='1234',
            host='10.80.17.11',
            database='nerdygadgets',
            port=3306
        )
        cursor = cnx.cursor()

        sense = SenseHat()
        temperature = sense.get_temperature() #krijgt temperatuur van sensehat

        add_temperature = ( # stopt temperatuur in database tabel Coldroomtemperatures
            "INSERT INTO coldroomtemperatures "
            "(ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo) "
            "VALUES (%s, NOW(), %s, NOW(), NOW() + INTERVAL 1 DAY)"
        )

        data_temperature = (5, temperature)

        cursor.execute(add_temperature, data_temperature)
        cnx.commit() # changes worden gepushed naar database
        print("Data inserted successfully!")

        # vind de nieuwste entry van ColdRoomSensorNumber 5
        cursor.execute("SELECT MAX(RecordedWhen) FROM ColdRoomTemperatures WHERE ColdRoomSensorNumber = 5")
        newest_record = cursor.fetchone()[0]

        # Archiveer alle oude data uit coldroomtemperatures
        archive_query = (
            "INSERT INTO ColdRoomTemperatures_archive "
            "SELECT * FROM ColdRoomTemperatures "
            "WHERE ColdRoomSensorNumber = 5 AND RecordedWhen < %s"
        )
        cursor.execute(archive_query, (newest_record,))

        # Delete oude records
        delete_query = (
            "DELETE FROM ColdRoomTemperatures "
            "WHERE ColdRoomSensorNumber = 5 AND RecordedWhen < %s"
        )
        cursor.execute(delete_query, (newest_record,))
        cnx.commit()  # changes worden gepushed naar database
        print("Archiving and deletion executed!")

    except mysql.connector.Error as err:
        print("Something went wrong: {}".format(err)) # afvang voor als er iets fout gaat

    finally:
        if 'cnx' in locals() and cnx.is_connected():
            cursor.close()
            cnx.close()

# De loop die bovenstaande code elke 3 seconden herhaald.
while True:
    temperature_to_db()
    time.sleep(3)
