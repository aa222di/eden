<?php

class CDice {
	
	
	
	// Property declaration
	protected	$last;
	private		$RoundSum;
	
	// Constructor
	public function __construct() {
		
	}
		
	
	// Methods
	
  /**
    * Roll the dice
    *
    * @param $times sets how many times the dice should be thrown
    *
    */
	
	public function Roll($times) {
    $this->rolls = array();

    for($i = 0; $i < $times; $i++) {
      $this->last = 	rand(1, 6);
      $this->rolls[] = 	$this->last;
      $this->RoundSum +=$this->last;	
    }
    return $this->last;
  }
		
   
  /**
    * Get the last rolled value.
    *
    */
    public function GetLastRoll() {
    	return $this->last;
    }
	
	
  /**
    * Get the total sum of this round.
    *
    */	
		
	public function GetTotal() {
		return $this->RoundSum;
	}
		
  /**
    * Reset RoundSum
    *
    */	
	public function ResetRoundSum() {
		$this->RoundSum = 0;
	}
    
  /**
   * Get the rolls as a serie of images.
   *
   */
  public function GetDiceImage() {
    $html = "<ul class='dice'>";
   
      $html .= "<li class='dice-{$this->last}'></li>";
    
    $html .= "</ul>";
    return $html;
  }

	//Destructor
	public function __destruct() {
	}
}
