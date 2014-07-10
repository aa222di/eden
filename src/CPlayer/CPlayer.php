<?php

class CPlayer {
	
	
	 // Properties
	/**
	 * Properties
	 * $score stores the RoundSum and GameSum of each player
	 * $players is an array of objects and stores each unique game
	 * $turn is the control which decides who is playing
	 *
	 */
	 private $score = array();
	 private $players = array();
	 public  $turn;
	 
	 
	 /**
	  * Constructor
	  *
	  *@param int $playersNumber the number of participants, defaults to two participants.
	  *
	  */
	 
	  public function __construct($playersNumber = 1) {
	  	  //Create an array of objects to connect to CGame
	  	  for($i=0; $i < $playersNumber; $i++) {
	  	  	  $this->players[] = new CGame();
	  	  }
	  	$this->turn = 0;
    	$this->score = array();
      }
     
      // Methods
      
		   /**
			 * Play the game
			 *
			 */
			 public function Play() {
				 
					$this->players[$this->turn]->Roll(1);
					$roll = $this->players[$this->turn]->GetLastRoll();
					$image = $this->players[$this->turn]->GetDiceImage();
					$total = $this->players[$this->turn]->GetTotal();
					if($roll == 1) {
						$total = 0;
						$this->ChangePlayer(0);
						$message = "<p class='center'>Attans! Du slog en etta, rundan avslutas utan att ge dig några poäng.</p>";
					}
					else {
						$message = null;
					}
					
					return array('message'=> $message,'image'=> $image, 'total'=> $total);
			 }
         
			 
			 
		   /**
			 * Change player - save points and update $turn
			 *
			 */
			  private function ChangePlayer($points) {
			 
			 	$message = $this->players[$this->turn]->EndRound($points);
			 	 
			 	if ($this->turn < (count($this->players)-1)) {
							$this->turn++;
				}
				
				else {
							
							$this->turn = 0;
				}
				
				return $message;
			 }
			 
			 
			 
		   /**
			 * End round
			 *
			 */
			  public function EndRound() { 
			  	  $message = $this->ChangePlayer($this->players[$this->turn]->GetTotal());
			  	  return $message;
			  	  
			  }
			 
			 
			 
         
          /**
            * Update the score - that is the GameSum and RoundSum from each player
            *
            * 
            */
            
            private function UpdateScore() {
            	$counter = 0;
            	
            	foreach($this->players as $player) {
            		$this->score[$counter] = array('points'=>$player->GetGameSum(),'rounds'=> $player->GetRoundCount());	
            		$counter++;
            	}
            }
            
            
         
          /**
            * Get the score - that is the GameSum and RoundSum from each player
            *
            * 
            */
            
            public function GetScore() {
            	$this->UpdateScore();
            	return $this->score;
            }
           		
            
     
            	
            	
           


}

