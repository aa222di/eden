<?php

class CPage extends CContent {

// MEMBERS
	private $filter; // Obj to filter text

 /**
   * Constructor creating the filter object 
   *
   */
  public function __construct($options, $table) {
  	parent::__construct($options, $table);
  	$this->filter = new CTextFilter();
}

public function getPage($url) {

// Get content
$res = $this->getContent(true, array('type' => 'page', 'url' => $url,));

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll.');
}


// Sanitize content before using it.
$title  = htmlentities($c->title, null, 'UTF-8');
$data   = $this->filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
	
	return array('title' => $title, 'data' => $data,);

}

}