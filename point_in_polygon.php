<?php

// Returns true if given point is inside of polygon.
// https://stackoverflow.com/a/5065219/3325516
function is_in_polygon($polygon, $point) {
  $polygon_points = count($polygon) - 1;
  $vertices_x = array_map(function($val) { return $val['lng']; }, $polygon);
  $vertices_y = array_map(function($val) { return $val['lat']; }, $polygon);
  $i = $j = $c = 0;
  for ($i = 0, $j = $polygon_points; $i < $polygon_points; $j = $i++) {
    if ((($vertices_y[$i] > $point['lat'] != ($vertices_y[$j] > $point['lat'])) &&
      ($point['lng'] < ($vertices_x[$j] - $vertices_x[$i]) * ($point['lat'] - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]))) {
      $c = !$c;
    }
  }
  return $c;
}
