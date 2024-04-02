<?php
class Major
{
  public $id;
  public $name;
  public $score = 0;

  public function __construct($id, $name, $score)
  {
    $this->id = $id;
    $this->name = $name;
    $this->score = $score;
  }
}