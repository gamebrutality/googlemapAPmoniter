<?php
class Building extends CI_CONTROLLER
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("building_model");
  }
}
