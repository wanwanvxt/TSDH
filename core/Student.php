<?php
class Student
{
  public $id;
  public $name;
  public $gender;
  public $birthdate;
  public $address;
  public $school;
  public $citizenId;
  public $transcript;
  public $userId;

  public function __construct($id, $name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId)
  {
    $this->id = $id;
    $this->name = $name;
    $this->gender = $gender;
    $this->birthdate = $birthdate;
    $this->address = $address;
    $this->school = $school;
    $this->citizenId = $citizenId;
    $this->transcript = $transcript;
    $this->userId = $userId;
  }
}