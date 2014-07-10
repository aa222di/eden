<?php 

class CGame extends CDiceImage {
	
	// Property declaration
	private $GameSum;
	private $RoundCount;
	private $maxPoint;
	private $win;
	
	// Constructor
	public function __construct($maxPoint=100) {
		parent::__construct();
		$this->GameSum = 0;
		$this->RoundCount = 0;
		$this->maxPoint = $maxPoint;
		$this->win = false;
	}
	
	// Methods
	
	
  /**
    * End round - count rounds and add points to GameSum
    *
    * @param $points is what should be added
    *
    */
    
    public function EndRound($points) {
    	$this->AddToSum($points);	
    	$this->RoundCount++;
    	$this->ResetRoundSum();
    	if($this->win) {
    		return ("<p class='center'>Du har vunnit! Du nådde {$this->maxPoint} på {$this->RoundCount} rundor, bra jobbat! Börja om spelet för att spela igen.<p>");
    	}
    	else {
    		return null;
    	}
    }
    	
    
    
	
  /**
    * Add to GameSum
    *
    * @param $points is what should be added
    *
    */
    
    private function AddToSum($points) {
    	$this->GameSum += $points;
    	if ($this->GameSum >= $this->maxPoint) {
    		$this->win = true;
    	}
    	
    }
    
    	

    
  /**
    * Get the current points of the whole game
    *
    */	
		
	public function GetGameSum() {
		return $this->GameSum;
	}
	
  /**
    * Get RoundCount
    *
    */	
		
	public function GetRoundCount() {
		return $this->RoundCount;
	}
    
}
