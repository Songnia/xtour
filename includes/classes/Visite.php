<!--Mecie..-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Localisation</title>
</head>
<body>
  <h1 id="test">Localisation</h1>
</body>
<script>
  const test =document.getElementById("test");
  
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            test.textContent = test.textContent+" : Latitude: " + lat + ", Longitude: " + lon;
        }, function(error) {
            test.textContent = test.textContent+": Erreur de géolocalisation : " + error.message;
        });
    } else {
        test.textContent = test.textContent+" : La géolocalisation n'est pas supportée par ce navigateur.";
    }
</script>
</html>