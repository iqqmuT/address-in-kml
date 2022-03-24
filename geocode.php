<?php

// Converts given address to coordinates.
// Returns array(
//   array ( [lat] => value [lng] => value ),
//   formatted_address
// )
function geocode($api_key, $address) {
  $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . $api_key . '&address=' . urlencode($address);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);

  $status = 'ERROR';
  $data = json_decode($response, true);
  if (array_key_exists('status', $data)) {
    $status = $data['status'];
  }

  if (array_key_exists('results', $data) && count($data['results']) > 0) {
    $result = $data['results'][0];
    return array(
      $status,
      $result['geometry']['location'],
      $result['formatted_address'],
    );
  }

  error_log(
    sprintf("%s Response from geocode API: '%s': %s", date("Y-m-d H:i:s"), $address, $response),
    3,
    "/tmp/geocoding-errors.log",
  );
  return array($status, null, null);
}
