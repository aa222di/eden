<?php

/**
 * CSearch, included in header, redirects to moviecatalogue when search is set
 *
 *
 */

class CSearch extends CCRUD {

// MEMBERS
	private $CForm;
	private $parameters;
	

 /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  	$this->CForm = new CForm();
	}

	// PUBLIC METHODS

	public function form() {
		$inputfield[]['search'] = array('name' => 'search', 'value' => 'search and click enter',); 
		//$inputfield[]['submit'] = array('name' => 'doSearch',); 
		$form = $this->CForm->getForm($inputfield, 'GET', 'search-field');
		return $form;
	}

	public function Search(){
		if(isset($_GET['search'])){
			header('Location: moviecatalogue.php?title=' . $_GET['search'] );
		}
	}
}