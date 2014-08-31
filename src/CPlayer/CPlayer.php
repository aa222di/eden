<?php

class CPlayer {
	
// MEMBERS
	private $score; //int
	private $rounds; // int

	// METHODS


  /**
    * Add to GameSum
    *
    * @param $points is what should be added
    *
    */
    
    public function addToSum($points) {
    	$this->score += $points;
    }

   /**
    * Add to rounds
    *
    * @param $points is what should be added
    *
    */
    
    public function addToRounds($points) {
    	$this->rounds += $points;
    }
            	
   /**
    * Get sum
    *
    * @param $points is what should be added
    *
    */
    
    public function getSum() {
    	
    	return $this->score;
    }

   /**
    * get rounds
    *
    * @param $points is what should be added
    *
    */
    
    public function getRounds() {
    	
    	return $this->rounds;
    }
            	
           


}

