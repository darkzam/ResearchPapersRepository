<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('tcpdf.php');

class Tcpdf2 extends TCPDF
{
  // Extend FPDF using this class
  // More at fpdf.org -> Tutorials
  function __construct()
  {
    parent::__construct();
  }
}
