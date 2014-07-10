<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Create the game object and store it in SESSION

if(isset($_SESSION['game'])) {
	$game = $_SESSION['game'];
}

else if(isset($_POST['players'])) {
	$game = new CPlayer($_POST['players']);
	$_SESSION['game'] = $game;
	$_POST = array();
	$_GET = array();
}

else if( !isset($_POST['players']) && isset($_GET['roll']) ) {
	$game = new CPlayer();
	$_SESSION['game'] = $game;
	$_POST = array();
	$_GET = array();
}


// Check for querystring

$save = "?save";
$round = null;
$message = <<<EOD
<p class="center">Välj antal spelare för att starta nytt spel.</p>
<form method="POST">
<select name='players' class="dice" onchange='form.submit();'>
	<option value='-1'>Välj antal spelare</option>
	<option value='1'>1 Spelare</option>
	<option value='2'>2 Spelare</option>
</select>
</form>
EOD;
if(isset($game)) {
	$message = null;
}

$currentPlayer = (isset($game)) ? ("Spelare ".($game->turn + 1)) : (null);
$score = (isset($game)) ? ($game->GetScore()) : (null);


if(isset($_GET['roll'])) {
	$round = $game->Play();	
	$message = $round['message'];
}
 
else if(isset($_GET['save'])) {
	
	$message = $game->EndRound();
	$currentPlayer =($message == null) ? ("Spelare ".($game->turn + 1)) : ("Vinnare: ".$currentPlayer);
	$roll = ($message == null) ? ("?roll") : ("#");
	$save = ($message == null) ? ("?save") : ("#");
	$score = $game->GetScore();
	
	
}

else if(isset($_GET['destroy'])) {
	destroySession();	
	$currentPlayer = null;
	$message = <<<EOD
	<p class="center">Välj antal spelare för att starta nytt spel.</p>
<form method="POST">
<select name='players' class="dice" onchange='form.submit();'>
	<option value='-1'>Välj antal spelare</option>
	<option value='1'>1 Spelare</option>
	<option value='2'>2 Spelare</option>
</select>
</form>
EOD;
	
	$save = null;
	
}


if(isset($score)) {
		$counter = 1;
		$html = null;
		foreach($score as $key=>$val) {
			$html .= "<p class='underline'>Spelare ".$counter.":</p>";
			$html .="<p>Poäng: ".$val['points']."</p>";
			$html .="<p>Antal rundor: ".$val['rounds']."</p>";
			$counter++;
		}
}
else {
	$html = null;
}
			
		

// Do it and store it all in variables in the Eden container.
$eden['title'] = "Fantastic Dice";
 
$eden['main'] = <<<EOD
<h2>Fantastic Dice</h2>
<hr>
<div class="grid">
	<section class="grid-1-6">
		<p><a href="?roll" class="button">Kasta</a></p>
		<p><a href="$save" class="button">Spara poäng</a></p>
		<p><a href="?destroy" class="button">Börja om spelet</a></p>
	</section>
	<section class="grid-2-3 extrapadding">
		<p class="center">$currentPlayer</p>
		$message
		{$round['image']}
		<h1 class="center">{$round['total']}</h1>
			
		
	</section>
	<section class="grid-1-6">
		<h3 class="borderbottom">Resultat</h3>
		$html
	</section>
</div>
<hr>	
<div class="grid">
	
	<section class="grid-2-3">
		<h3>Spelregler</h3>
		<p>Här är spelet vi alla väntat på! Och reglerna är enkla att följa:</p>
		<ul>
			<li>Det gäller att nå 100 poäng med så få rundor som möjligt</li>
			<li>Kasta tärningen, under tärningen ser du den samlade poängen för varje runda</li>
			<li>Spara poängen när du känner att det är dax</li>
			<li>Slår du en etta så avslutas rundan utan poäng</li>
		</ul>
	</section>
	<aside class="grid-1-3">
	<img src="img/dices.jpg" alt="Image of two dices">
	</aside>
</div>

EOD;
 
$eden['stylesheets'][2] = "css/dice.css";

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
