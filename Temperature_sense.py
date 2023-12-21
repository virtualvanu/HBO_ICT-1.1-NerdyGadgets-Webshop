# !!!place this file on your raspberri pi with sensehat!!!

from sense_hat import SenseHat
import mysql.connector
import time

def temperature_to_db():
    # Connect to the MySQL database
    try:
        cnx = mysql.connector.connect(
            user='temperaturesensor',
            password='1234',
            host='10.80.17.11',
            database='nerdygadgets',
            port=3306
        )
        cursor = cnx.cursor()

        # Get the temperature data
        sense = SenseHat()
        temperature = sense.get_temperature()

        # Prepare the SQL query to insert data into the table
        add_temperature = (
            "INSERT INTO coldroomtemperatures "
            "(ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo) "
            "VALUES (%s, NOW(), %s, NOW(), NOW() + INTERVAL 1 DAY)"
        )

        data_temperature = (5, temperature)

        # Execute the SQL query to insert temperature data
        cursor.execute(add_temperature, data_temperature)
        cnx.commit()  # Commit changes to the database
        print("Data inserted successfully!")

        # Find the newest entry for ColdRoomSensorNumber 5
        cursor.execute("SELECT MAX(RecordedWhen) FROM ColdRoomTemperatures WHERE ColdRoomSensorNumber = 5")
        newest_record = cursor.fetchone()[0]

        # Archive older records
        archive_query = (
            "INSERT INTO ColdRoomTemperatures_archive "
            "SELECT * FROM ColdRoomTemperatures "
            "WHERE ColdRoomSensorNumber = 5 AND RecordedWhen < %s"
        )
        cursor.execute(archive_query, (newest_record,))

        # Delete older records
        delete_query = (
            "DELETE FROM ColdRoomTemperatures "
            "WHERE ColdRoomSensorNumber = 5 AND RecordedWhen < %s"
        )
        cursor.execute(delete_query, (newest_record,))
        cnx.commit()  # Commit changes to the database
        print("Archiving and deletion executed!")

    except mysql.connector.Error as err:
        print("Something went wrong: {}".format(err))

    finally:
        if 'cnx' in locals() and cnx.is_connected():
            cursor.close()
            cnx.close()

# Main loop to continuously record temperature and perform archiving/deletion
while True:
    temperature_to_db()  # Record temperature data and execute archiving/deletion
    time.sleep(3)
