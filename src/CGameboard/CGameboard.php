<?php

class CGameboard extends CDice {
	

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
	 private $CForm; // Obj
	 public  $turn;
	 
	 
	 /**
	  * Constructor
	  *
	  *@param int $playersNumber the number of participants, defaults to two participants.
	  *
	  */
	 
	  public function __construct($players) {

	  	  //Create an array of objects to connect to CGame
	  	  for($i=0; $i < $players; $i++) {
	  	  	  $this->players[] = new CPlayer();
	  	  }

	  	$this->turn = 0;
    	$this->score = array();
    	$this->CForm = new CForm();
      }
     
      // Methods
      	

      		public function getGameboard() {
      			$message = null;
      			$gameboard = "<a href='?start=true#dice' class='regretbutton'>Start game</a>";
      			// Build gameboard
      			
      			if (isset($_GET['start'])) {
      			
      			// Build the form
      			$inputfields[]['submit'] = array('name' => 'roll', 'value' => 'Roll',);
      			$inputfields[]['submit'] = array('name' => 'save', 'value' => 'Save points',);
      			$inputfields[]['submit'] = array('name' => 'reset', 'value' => 'Reset game',);

      			$form = $this->CForm->getForm($inputfields, 'POST', 'dicegame');


      			// Check if game has started

      			// Check if play is set
      			if (isset($_POST['roll'])) {
      				$message = $this->Play();
      			}

      			// Check if Save is set
      			if (isset($_POST['save'])) {
      				$points = $this->getTotal();
      				$this->ChangePlayer($points);
      			}

      			$image = $this->GetDiceImage();
      			$scoreTable = "<table><thead><th>Player</th><th>Rounds</th><th>Points</th></thead><tbody>";
      			$player = 1;
      			foreach ($this->players as $key) {
      				$scoreTable .= "<tr><td>" . $player . "</td><td>" . $key->getRounds() . "</td><td>" . $key->getSum() . "</td></tr>";

	      			if ($key->getSum() >= 60 && $key->getRounds() <= 5) {
	      				unset($_SESSION['CGame']);
						$gameboard = "<h4 class='center'> Congratulations! You won the movie of the month! </h4>";
						header( "refresh:4;url=competition.php" );   
						goto write;
					}    			
	      			if ($key->getRounds() == 6 ) {
	      				unset($_SESSION['CGame']);
	      				$gameboard = "<h4 class='center'> Game over </h4><p class='center'>Wait for page to reload in order to play again</p>";
	      				header( "refresh:3;url=competition.php" );  
	      				goto write;
	      			}
      				$player++;
      			}
      			$scoreTable .= "</tbody></table>";
      			$player = $this->turn+1;
      			$gameboard =  $form . $image . $message . $scoreTable;


      			}
      			write:

      			return $gameboard;

      		}

		   /**
			 * Play the game
			 *
			 */
			 public function Play() {
				 
					$this->Roll(1);
					
					if($this->last == 1) {
						$total = 0;
						$this->ChangePlayer(0);
						$message = "<p class='center'>Oh no! You got 1, which mean your round will be saved without any points!</p>";
					}
					else {
						$message = "<h4 class='center roundsum'>Total: "  . $this->getTotal() . "</h4>";
					}
					
					return $message;
			 }
         
			 
			 
		   /**
			 * Change player - save points and update $turn
			 *
			 */
			  private function ChangePlayer($points) {
			 
			 	$this->players[$this->turn]->addToSum($points);
			 	$this->players[$this->turn]->addToRounds(1);
			 	$this->ResetRoundSum();
			 	 
			 	if ($this->turn < (count($this->players)-1)) {
							$this->turn++;
				}
				
				else {
							
							$this->turn = 0;
				}
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