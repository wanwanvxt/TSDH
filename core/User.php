<?php
class User
{
  public $id;
  public $email;
  public $password;
  public $admin = false;

  public function __construct($id, $email, $password, $admin)
  {
    $this->id = $id;
    $this->email = $email;
    $this->password = $password;
    $this->admin = $admin;
  }
}