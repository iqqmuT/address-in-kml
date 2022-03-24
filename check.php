<?php

// Usage:
// GET check.php?territory=ABCDE&address=My+Address+123
//
// Outputs JSON:
// {
//   'result': true|false|null,
//   'address': formatted address,
// }

require('config.php');
require('geocode.php');
require('kml.php');
require('point_in_polygon.php');

function run() {
  header('Content-Type: application/json; charset=utf-8');
  $address = $_GET['address'];
  $cfg = get_config();
  list($status, $point, $official_address) = geocode($cfg['GOOGLE_API_KEY'], $address);
  if (!is_null($point)) {
    $territory = substr($_GET['territory'], 0, 5);
    $polygon = read_polygon_from_kml('kml/' . $territory . '.kml');
    $val = is_in_polygon($polygon, $point);
    $response = array(
      'status' => $status,
      'result' => $val === true,
      'address' => $official_address,
    );
    print(json_encode($response));
  } else {
    print(json_encode(array(
      'status' => $status,
      'result' => null,
    )));
  }
}

run();
