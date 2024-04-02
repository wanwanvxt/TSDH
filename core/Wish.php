<?php
class Wish
{
  public $id;
  public $studentId;
  public $majorId;
  public $pass = null;

  public function __construct($id, $studentId, $majorId, $pass)
  {
    $this->id = $id;
    $this->studentId = $studentId;
    $this->majorId = $majorId;
    $this->pass = $pass;
  }
}