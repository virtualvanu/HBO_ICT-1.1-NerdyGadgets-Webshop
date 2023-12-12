function updateTemperature() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        console.log(this.responseText)
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("temperature").innerText = this.responseText;
        }
    };
    xhttp.open("GET", "temperature.php", true); // Make sure this path is correct
    xhttp.send();
}
// Update temperature every 3 seconds
setInterval(function () {
    updateTemperature();
}, 3000); // 3 seconds in mili seconds
updateTemperature();
