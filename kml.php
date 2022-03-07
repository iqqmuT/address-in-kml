<?php

// Reads polygon from given KML file.
// Returns array of polygon points as array ( [lat] => value [lng] => value )
function read_polygon_from_kml($filename) {
  $data = file_get_contents($filename);
  $xml = simplexml_load_string($data);
  $polygon = array();
  $coords_str = $xml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->coordinates;
  $coords = explode("\n", $coords_str);
  foreach ($coords as $coord) {
    $parts = explode(",", $coord);
    if (count($parts) > 1) {
      array_push($polygon, array(
        'lat' => floatval($parts[1]),
        'lng' => floatval($parts[0]),
      ));
    }
  }
  return $polygon;
}
