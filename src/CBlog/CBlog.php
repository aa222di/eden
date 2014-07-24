<?php

class CBlog extends CContent {

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


public function getPosts($slug) {
	if($slug){
	$res = $this->getContent(true, array('type' => 'post', 'slug' => $slug,));
	}
	else {
	$res = $this->getContent(true, array('type' => 'post',));
	}

	$html = null;
	if(isset($res[1])) {
  		foreach($res as $c) {
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
		 
		    $html .= <<<EOD
		<section>
		  <article>
		  <header class="blogheader">
		  <h2><a href='edenpress_blog.php?slug={$c->slug}'>{$title}</a></h2>
		  </header>
		  {$data}
		  </article>
		</section>
		<hr>
EOD;
  		}
	}
	else if(!isset($res[1])) {
  		foreach($res as $c) {
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
		 
		    $html .= <<<EOD
		    <p><a href="?" title="se alla blogposter">Se alla bloggposter</a></p>
		<section>
		  <article>
		  <header class="blogheader">
		  <h2>{$title}</h2>
		  </header>
		  {$data}
		  </article>
		</section>
	
EOD;
  		}
	}
	else if($slug) {
	  $html = "Det fanns inte en sådan bloggpost.";
	}
	else {
	  $html = "Det fanns inga bloggposter.";
	}

	return $html;
}	

}