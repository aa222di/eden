<?php

class CDiceImage extends CDice {


	
  // Constructor
  public function __construct() {
    parent::__construct();
  }
  
  // Methods
  
  /**
   * Get the rolls as a serie of images.
   *
   */
  public function GetDiceImage() {
    $html = "<ul class='dice'>";
    foreach($this->rolls as $val) {
      $html .= "<li class='dice-{$val}'></li>";
    }
    $html .= "</ul>";
    return $html;
  }



}
