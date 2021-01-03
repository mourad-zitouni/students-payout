<?php
require "Student.php";
require "CsvReader.php";

use Payout\Student;
use Payout\CsvReader;


$csv = new CsvReader();
$students = $csv->getData('attendance.csv');
$workplaces = $csv->getData('workplaces.csv');

if (!$students || !$workplaces)  {
  echo 'Problem with loading data!';
  return;
}
echo sprintf('id, payout <br>');

foreach($students as $item) {
  
  $student = new Student($item[0]);

  // get distance
  $workplaceLocation = reset($workplaces[$item[0]['workplace_id']])['location'];
  
  $studentLocation = $student->getLocation();
  $params['distance'] = $student->getDistance($studentLocation, $workplaceLocation);

  $params['basicRate'] = $student->getBasicRate();
  $params['meal'] = $student->getMealPayout(1);
  $params['travel'] = $student->getTravelPayout(1, $params['distance']);

  $totalPayout = 0;
  foreach($item as $value) {
    $status = $value['status'];
    $totalPayout += $student->getDayPayout($status, $params);
  }
  // Total payout
  echo sprintf('%s, %s<br>', $student->getId(), $totalPayout);

}
