<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $eden variable with its defaults.

include(__DIR__.'/config.php'); 
$db = new CDatabase($eden['database']); 

$post = $_POST ;
$posthtml = "<pre>".var_dump($post)."</pre>";

// Check if user is authenticated.
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
 
if($acronym) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}



//Check if the password and username exist in the table

if(isset($_POST['login'])) {
$params = array($_POST['user'], $_POST['pswd']);
$sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
$res = $db->ExecuteSelectQueryAndFetchAll($sql,array($_POST['user'], $_POST['pswd']));

//Check if the query found a user
if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
}
 header('Location: login.php');
}

// Logout the user
if(isset($_POST['logout'])) {
  unset($_SESSION['user']);
  header('Location: login.php');
}




/**
 * Login/Logout FUNCTION
 * Function to alter the nav menu according to login status
 *
 * 
 * 
 */


// Switch login/logout function
function loginForm($user) {

if(isset($user)) {
		$loginVariables = array(
		'text' => "Logga ut",
		'input' => "<input type='submit' value='logout' name='logout'>",
		);
}
else {
	$loginVariables = array(
	'text' => "Logga in",
	'input' => '<label for="user">Användarnamn</label>
	<input id="user" type="text" name="user" value="">
	<label for="pswd">Lösenord</label>
	<input id="pswd" type=password name="pswd" value="">
	<input type="submit" value="login" name="login">'
	);
	
	
}
return $loginVariables;
}
$logText = isset($_SESSION['user']) ? loginForm($_SESSION['user']) : loginForm(null);


// Do it and store it all in variables in the Eden container.

$eden['title'] = $logText['text']; 
$eden['navbar']['items']['login']['text'] = $logText['text']; 
$eden['navbar']['items']['login']['title'] = $logText['text']; 

 
$eden['main'] = <<<EOD
<h2>{$logText['text']}</h2>
<form method="post">
	<fieldset>
	<legend>{$logText['text']}</legend>
	{$logText['input']}
	$output
	</fieldset>
	{}
</form>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
