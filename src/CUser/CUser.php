<?php
/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CUser extends CCRUD {
	
	
	// MEMBERS	
 
  /**
   * Members
   */
  
  private $table; // Table with user data
  private $CForm; // Obj to create form
  private $formData; // input values from form
 
  
  
  
	// CONSTRUCTOR
  
  
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options, $table) {
    parent::__construct($options);

    $this->table = $table;
    $this->CForm = new CForm();
 
  }
  
  
  
  	// METHODS  
  

  /**
   * Check if user i registered, if so log in user
   * 
   * @param array with userdata
   * @return array with resultset.
   */
  public function logIn(){

    // Check for user
    unset($this->formData['submit']);
    $res = $this->SELECT(array('equals' => $this->formData,), $this->table);

    if(isset($res[0])) {
      $_SESSION['user'] = $res[0];
      header('Location: profile.php');
      
    }

    else {return "<output class='wrong'>Wrong password or username.</output>";}

  }
  
  public function logOut() {
      unset($_SESSION['user']);
      
      header('Location: login.php');
  }

  /**
   * Build form for login and logout
   * @return string login/logout form
   */

public function loginForm() {

  if(isset($_SESSION['user'])) {
    return 'You have been logged in as ' . $_SESSION['user']->name;
  }

  else {

  $inputfields[]['text'] = array('name' => 'acronym',   'label' => 'Username',);
  $inputfields[]['password'] = array('name' => 'password',  'label' => 'Password',);
  $inputfields[]['submit'] = array('name' => 'submit', 'value' => 'Login',);

  $form = $this->CForm->getForm($inputfields, 'POST', 'login-form', 'Login');
  $this->formData = $this->CForm->getData();
  return $form;

  }

}

/**
 * getProfile
 * @param id, string or int
 * @return string, profile for chosen user
 *
 */
public function getProfile($id = 'current') {
  $user = ($id == 'current') ? $_SESSION['user'] : $id;
  if (!is_object($user)) {
   $user = $this->SELECT(array('equals'=>array('id' => $id),),'userRM');
   $user = $user[0];
  }

  $profile = "<figure class='grid-1-4 poster'><img src='img.php?src=userimg/" . $user->img . "&amp;width=300&amp;height=300&amp;save-as=png' alt='User Profile Image'></figure>";
  $profile .= <<<EOD
  <article class='profile grid-2-3'>
        <header class="profile-header">
          <h1>{$user->name}</h1>
          <h2>{$user->authority}</h2>
        </header>
        {$user->info}
      </article>
EOD;
  return $profile;
}

/**
 * register form
 * @return form string
 *
 */
public function registerForm() {

  $inputfields[]['text'] =     array('name' => 'name',             'label' => 'Name',            'value' => 'keep',);
  $inputfields[]['text'] =     array('name' => 'acronym',          'label' => 'Username',        'value' => 'keep',);
  $inputfields[]['password'] = array('name' => 'password',         'label' => 'Password',);
  $inputfields[]['password'] = array('name' => 'repeat-password',  'label' => ' Repeat password',);
  $inputfields[]['submit'] =   array('name' => 'submit', 'value' => 'Register',);

  $form = $this->CForm->getForm($inputfields, 'POST', 'register-form');
  $this->formData = $this->CForm->getData();
   return $form;
}

/**
 * register, check for existent users with same acronym and validates form data from register form
 * @return string, redirects to login.php on success.
 *
 */
public function register(){
  unset($this->formData['submit']);
  // Clean out empty values
  foreach ($this->formData as $key => $value) {
    if($value == '' || empty($value))
     unset($this->formData[$key]);
  }

  if(isset($this->formData['acronym']) && isset($this->formData['name']) && isset($this->formData['password']) && isset($this->formData['repeat-password'])){
    // Check for password
    if($this->formData['repeat-password'] != $this->formData['password']){
      $output = "<output class='wrong'>You have typed two different passwords, try to register again.</output>";
      
    }

    else {
        unset($this->formData['repeat-password']);
        // Is there already a user ith the same acronym
        $res = $this->SELECT(array('equals'=>array('acronym' => $this->formData['acronym']),),'userRM');

        if(isset($res[0])){
          $output = "<output class='wrong'>The username is already taken, try another one</output>";
        }
        else{
          $password = $this->formData['password'];
          unset($this->formData['password']);
          $this->formData['authority'] = 'member';
          $this->formData['img'] = 'user1.png';
          $this->formData['salt'] = 'unix_timestamp()';
          $res = $this->INSERT($this->formData, 'userRM');
          $setPassword = $this->UPDATE(array('password' => $password,), 'userRM', array('field' => 'id', 'value' => $res,));
      
        if ($res && $setPassword) { 
          $output = "<output class='success-registration'>Yay! You are now registered as a Rental Movies member.</output>";
          header( "refresh:2;url=login.php" ); 
        }

        else { 
          $output = "<output class='wrong'>Something went wrong with your registration</output>";
        }
      }
    }
}
  else {
    $output = "<output class='wrong'>You have to fill out the whole form</output>";
  }
  return $output ;
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


}
  









