<?php

namespace Payout;

use DateTime;

require "Utils.php";

/**
 *
 */
class Student {
  use Utils;

  private $id;
  private $birthDate;
  private $name;
  private $location;
  private $payout;
  private $age;
  
  public function __construct($line) {
    $this->id = $line['id'];
    $this->name = $line['name'];
    $this->location = $line['location'];
    $this->birthDate = $line['dob'];

    $this->payout = 0;
  }

  public function getId() {
    return $this->id;
  }

  public function getLocation() {
    return $this->location;
  }

  public function setAge() {
    $now = new DateTime();
    $currentYear = $now->format("Y");
    list($year) = explode("-", $this->birthDate);

    $this->age = (int) $currentYear - $year;
  }

  public function getBasicRate() {
    $this->setAge();
    if ($this->age < 18) {
      return 72.5;
    }
    elseif ($this->age <= 24 && $this->age >= 18) {
      return 81;
    }
    elseif ($this->age == 25) {
      return 85.9;
    }
    elseif ($this->age >= 26) {
      return 90.5;
    }

  }

  public function getMealPayout($days) {
    return $days * 5.5;
  }

  public function getTravelPayout($days, $kms) {
    return $days + ($kms * 1.09);
  }

  public function getDistance($first, $second) {
    return $this->computeDistance($first, $second);
  }
}
