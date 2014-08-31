<?php
/**
 * CRUD to manage CRUD for given database and table sorting
 *
 */

class CCRUD {

	public $lastQuery;
	public $db;
	public $lastParameterSet;
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {

  	$this->db = new CDatabase($options);
  	
	}

	/**
	 * Select builds query for reading out content from database
	 * @param params multidimensional array sets conditions for select
	 * @param table string, table to be queried
	 * @return array with objects from query
	 *
	 */
public function SELECT($params = array(), $table) {
	// Start to build query
	
	$sqlOrig = "SELECT";
	if(isset($params['distinct'])) {
		$sqlOrig .= " DISTINCT " . $params['distinct'];
	}
	else {
		$sqlOrig .= " *";
	}

	$onlyPublished = isset($params['published']) ? ", (published <= NOW()) AS available" : null;

	// Set standard values
	$limit = null;
	$condition = null;
	$parameters = array();
	$params['orderby'] = isset($params['orderby']) ? $params['orderby'] : null;
	$params['order'] = isset($params['order']) ? $params['order'] : 'ASC';

	if(isset($params['orderby'])) {
		$sort = " ORDER BY {$params['orderby']} {$params['order']}";
	}
	else {
		$sort = null;
	}

	// Select to equal
		if (isset($params['equals'])) {
			foreach ($params['equals'] as $key => $value) {
				if(!empty($value)){

					if($key == 'password') {
					$condition .= " AND " . $key . " = md5(concat(?, salt))";
					$parameters[] = $value;
					}

					elseif(!is_array($value)) {
					$condition .= " AND " . $key . " = ?";
					$parameters[] = $value;
					}

					elseif (is_array($value)) {
						foreach ($value as $v) {
							$condition .= " AND " . $key . " = ?";
							$parameters[] = $v;
						}
					}
				}
			}
		}

	// Select 'IN'
		if (isset($params['in'])) {
			foreach ($params['in'] as $key => $value) {
				if(!empty($value)){

					$condition .= " AND " . $key . " IN " . $value;
							
				}
			}
		}

	// Select like
		if (isset($params['like'])) {
			foreach ($params['like'] as $key => $value) {

				if(!is_array($value)) {
				$condition .= " AND " . $key . " LIKE ?";
				$parameters[] = $value;
				}

				elseif (is_array($value)) {
					foreach ($value as $v) {
						$condition .= " AND " . $key . " LIKE ?";
						$parameters[] = $v;
					}
				}	

			}
		}

	// Select to no euqal
		if (isset($params['not'])) {
			foreach ($params['not'] as $key => $value) {

				if(!is_array($value)) {
				$condition .= " AND " . $key . " != ?";
				$parameters[] = $value;
				}

				elseif (is_array($value)) {
					foreach ($value as $v) {
						$condition .= " AND " . $key . " != ?";
						$parameters[] = $v;
					}
				}

			}
		}
	// Select greater or equal to
		if (isset($params['greater-or-equal'])) {
			foreach ($params['greater-or-equal'] as $key => $value) {
				$condition .= " AND " . $key . " >= ?";
				$parameters[] = $value;
			}
		}

	// Select less or equal to
		if (isset($params['less-or-equal'])) {
			foreach ($params['less-or-equal'] as $key => $value) {
				$condition .= " AND " . $key . " <= ?";
				$parameters[] = $value;
			}
		}

	// Select greater than
		if (isset($params['greater'])) {
			foreach ($params['greater'] as $key => $value) {
				$condition .= " AND " . $key . " > ?";
				$parameters[] = $value;
			}
		}

	// Select less than
		if (isset($params['less'])) {
			foreach ($params['less'] as $key => $value) {
				$condition .= " AND " . $key . " < ?";
				$parameters[] = $value;
			}
		}

		// Pagination
	if(isset($params['hits']) && isset($params['page'])) {
	  $limit = " LIMIT {$params['hits']} OFFSET " . (($params['page'] - 1) * $params['hits']);
	}

	$where = " WHERE 1" . $condition ;
	$sql = $sqlOrig . $onlyPublished . " FROM " . $table . $where . $sort . $limit . ";";
	$this->lastQuery = $sqlOrig . $onlyPublished . ' FROM ' . $table . $where ;
	$this->lastParameterSet = $parameters;

	// Do SELECT from a table
	$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $parameters);
	
	return $res;
	}

	/**
	 * Update builds query for updating
	 * @param params multidimensional array arranged like so params[0]=>array(field, value)
	 * @param table string, table to be queried
	 * @param where array like so array(field => field, value => value)
	 * @return boolean
	 *
	 */
public function UPDATE($params, $table, $where) {

		$newValues = null;

		// Build query
		 $sqlOrig = 'UPDATE ' . $table . ' SET';

		 foreach ($params as $key => $val) {
		 	if($key == 'password') { 
		 		$newValues[] = " " . $key . "= md5(concat(?, salt))";
		 	}
		 	else {
			 	$newValues[] = ' ' . $key . '=?';
			}
			 	$parameters[] = $val;
			
		 }
	   $newValues =  implode(',', $newValues);
	   $WHERE = ' WHERE ' . $where['field'] . '=?';
	   $parameters[] = $where['value'];

	   $sql = $sqlOrig . $newValues . $WHERE;
	  
	   $res = $this->db->ExecuteQuery($sql, $parameters);

	   return $res;

}
	/**
	 * Build up query for insertion of data in table
	 * @param params multidimensional array arranged like so params = array(field => value,)
	 * @param table string, table to be used
	 * @return last inserted id on success false on fail
	 *
	 */
public function INSERT($params, $table) {

		$newValues = null;

		// Build query
		 $sqlOrig = 'INSERT INTO ' . $table;

		 foreach ($params as $key => $val) {
		 	$fields[] = $key;

		 	$values[] = ($val == 'NOW()' || $val == 'unix_timestamp()') ? $val : '?';

		 	if ($val != 'NOW()' && $val != 'unix_timestamp()') {
		 		$parameters[] = $val;
		 	}	
		 }
	   $fields = ' (' . implode(',', $fields) . ') ';
	   $values = ' (' . implode(',', $values) . ') ';
	  
	   

	   $sql = $sqlOrig . $fields . ' VALUES ' . $values . ';';
	   

	   $res = $this->db->ExecuteQuery($sql, $parameters);
	   if($res) {
	   	return $this->db->LastInsertId();
	   } 
	   else {
	   	return false;
	   }
}
	/**
	 * Build up query for deletion from database table
	 * @param params multidimensional array arranged like so params = array(field => value,)
	 * @param table string, table to be used
	 * @param noLimit boolean, if set to true "limit 1" will be stripped from query
	 * @return number of rows affected on success false on fail
	 *
	 */

public function DELETE($params, $table, $noLimit = false){
		$condition = null;
		$limit = ($noLimit) ? ';' : ' LIMIT 1;';
		foreach ($params as $key => $value) {
			$condition .= 'AND ' . $key . '=? ';
			$parameters[] = $value;
		}
	  $sql = 'DELETE FROM ' . $table . ' WHERE 1 ' . $condition . $limit;
	  $res = $this->db->ExecuteQuery($sql, array($value));
	  $this->db->SaveDebug( $this->db->RowCount() . " row was deleted");
	    if($res) {
	   	return $this->db->RowCount();
	   } 
	   else {
	   	return false;
	   }
}

// Table sort functions - protected

	/**
 * Create navigation among pages.
 *
 * @param integer $hits per page.
 * @param integer $page current page.
 * @param integer $max number of pages. 
 * @param integer $min is the first page number, usually 0 or 1. 
 * @return string as a link to this page.
 */
protected function getPageNavigation($hits, $page, $max, $min=1, $id=null) {
	$nav  = "<nav class='pagenav clear'>";
	$nav .= "<a href='" . $this->getQueryString(array('page' => $min)) . $id . "'> &lt;&lt; </a> ";
	$nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . $id . "'>&lt;</a> ";
 
  for($i=$min; $i<=$max; $i++) {
  	if($page == $i) {
      $nav .= "<span class='currentChoice'> " . $i . " </span>";
    }
    else {
    $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . $id . "'>$i</a> ";
	}
  }
 
  $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . $id . "'> &gt; </a> ";
  $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . $id . "'> &gt;&gt; </a> ";
  $nav .= "</nav>";
  return $nav;
}



/**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
protected function getQueryString($options, $prepend='?') {
  // parse query string into array
  $query = array();
  parse_str($_SERVER['QUERY_STRING'], $query);
 
  // Modify the existing query string with new options
  $query = array_merge($query, $options);
 
  // Return the modified querystring
  return $prepend .htmlentities(http_build_query($query));
}



/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
 protected function orderby($column, $id=null) {
  return "<a href='". $this->getQueryString(array('orderby' => $column, 'order' => 'asc')) . $id . "'> <img src='img/reduptriangle.png' alt='&darr;'> </a><a href='". $this->getQueryString(array('orderby' => $column, 'order' => 'desc')) . $id . "'> <img src='img/reddowntriangle.png' alt='&uarr;'> </a>";
}




/**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @param array $current value.
 * @param string $id, html id, optional
 * @return string as a link to this page.
 */
protected function getHitsPerPage($hits, $current=null, $id=null) {
	
	$nav = null;
	foreach($hits AS $val) {
    if($current == $val) {
      $nav .= "<span class='currentChoice'> " . $val . " </span>";
    }
    else {
      $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . $id . "'>$val</a> ";
    }
  }  
  return $nav;
}


/**
 * Build pagenavigation
 * @param $params the parameters from the $_GET-array
 * @param string $id, html id, optional
 * @return array hits per page and pagenavigation 
 */

protected function pageNavigation($params, $id=null) {
	
	// Get hits per page and current page from params
	$hits = isset($params['hits']) && is_numeric($params['hits']) ? $params['hits'] : 12;
	$page = isset($params['page']) && is_numeric($params['page']) ? $params['page'] : 1;

	// Count result set and last page ($max)
	$sql  = "SELECT COUNT(id) AS rows FROM ({$this->lastQuery}) AS lastQuery;";
	$res  = $this->db->ExecuteSelectQueryAndFetchAll($sql, $this->lastParameterSet);
	$rows = $res[0]->rows;
	$max = ceil($rows / $hits);

	// Get navs
	$pageNav = $this->getPageNavigation($hits, $page, $max, 1, $id);
	$hitsPerPage = $this->getHitsPerPage(array(3, 6, 12), $hits, $id);

	return array(
		'hitsPerPage' => $hitsPerPage,
		'pageNav'	  => $pageNav,
					);
}

}
