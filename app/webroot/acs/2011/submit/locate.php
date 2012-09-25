<?
$lat = $_GET['lat'];
$lng = $_GET['lng'];

$url = 'http://ws.geonames.org/findNearbyPlaceNameJSON?lat=%s&lng=%s';
$curl = sprintf($url, $lat, $lng);

$ch = curl_init($curl);

curl_exec($ch);

curl_close($ch);
?>