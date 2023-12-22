//Javascript file om de temperatuur op de website elke 3 seconden te updaten.

function updateTemperature() { 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        console.log(this.responseText)
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("temperature").innerText = this.responseText;
        }
    };
    xhttp.open("GET", "temperature.php", true); // script dat elke 3 seconden moet worden uitgevoerd
    xhttp.send();
}
// voert dit script elke 3 seconden uit
setInterval(function () {
    updateTemperature();
}, 3000); // 3 seconden in mili seconden
updateTemperature();
