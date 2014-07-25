<?php
/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CUser {
	
	
	// MEMBERS	
 
  /**
   * Members
   */
  private $db; // Contection to the database
  private $table; // Table with user data
  private $user; // boolean to check if user is registered
  private $userId;
  private $userName;
  private $userAcronym;
 
  
  
  
	// CONSTRUCTOR
  
  
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options, $table) {
    $this->db = new CDatabase($options);
    $this->table = $table;

    if (isset($_SESSION['user'])) {
      $this->user = true;
      $this->userId = $_SESSION['user']->id; 
      $this->userName = $_SESSION['user']->name;
      $this->userAcronym = $_SESSION['user']->acronym;

    } else {
      $this->user = false;
    }
    
 
  }
  
  
  
  	// METHODS  
  

  /**
   * Chekc if user i registered, if so log in user
   * 
   * @param array with userdata
   * @return array with resultset.
   */
  public function logIn($params){
  
    // Check if user was found
    $res = $this->isAuthenticated($params);

    if(isset($res[0])) {
      $_SESSION['user'] = $res[0];
      $this->userId = $_SESSION['user']->id; 
      $this->userName = $_SESSION['user']->name;
      $this->userAcronym = $_SESSION['user']->acronym;
      $this->user = true;
    }
    else {
        $this->user = false;
    }
     header('Location: login.php');
  
  }
  
  public function logOut() {
      unset($_SESSION['user']);
      $this->user = false;
      header('Location: login.php');
  }

  /**
   * Build form for login and logout
   * @return string login/logout form
   */

public function loginForm() {

if($this->user) {
    $logText = array(
    'text'    => "Logga ut",
    'input'   => "<input type='submit' value='logout' name='logout'>",
    'output'  => "Du är inloggad som " . $_SESSION['user']->name,
    );
}
else {
  $logText = array(
  'text'   => "Logga in",
  'input'  => '<label for="user">Användarnamn</label>
  <input id="user" type="text" name="user" value="">
  <label for="pswd">Lösenord</label>
  <input id="pswd" type=password name="pswd" value="">
  <input type="submit" value="login" name="login">',
  'output' => "Du är inte inloggad",
  );
  }
  $form = <<<EOD
  <h2>{$logText['text']}</h2>
  <p>{$logText['output']}</p>
  <form method="post">
    <fieldset>
      <legend>{$logText['text']}</legend>
      {$logText['input']}
    </fieldset>
  </form>
EOD;
   
return $form;
}

  /**
   * Check if user is authenicated
   * @return array
   */

private function isAuthenticated($params) {
  // Query the table with the incomming data
    $sql = "SELECT acronym, name, id FROM {$this->table} WHERE acronym = ? AND password = md5(concat(?, salt))";
    $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params);
  return $res;
}

public function User2Content($id) {
    $sql = "
      INSERT INTO User2Content
      (idUser, idContent) 
      VALUES (?, ?);";
    $params = array($this->userId, $id);
    $this->db->ExecuteQuery($sql, $params);  

}


}
  









