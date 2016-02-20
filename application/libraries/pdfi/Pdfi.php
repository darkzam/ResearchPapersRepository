<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('fpdi.php');

class Pdfi extends FPDI
{
  // Extend FPDF using this class
  // More at fpdf.org -> Tutorials
   function __construct()
  {
    parent::__construct();
  }
}
