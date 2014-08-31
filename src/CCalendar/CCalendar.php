<?php

class CCalendar {

	// MEMBERS
	public $currentMonth; // int
	public $currentDate; // int
	public $currentYear; // int

	public $newMonth; // int
	public $newYear; // int

	public $prevLink; // string
	public $nextLink; // string

	// CONSTRUCTOR
	// Gets current dates
	public function __construct() {
		$today = getdate();
		$this->currentMonth = $today['mon'];
		$this->currentDate 	= $today['mday'];
		$this->currentYear 	= $today['year'];
	}

	// PUBLIC METHODS

	/**
	 * Get calendar gets the new date with setDate and displays a table calendar for requestes date
	 * @return string
	 */
	public function getCalendar() {
		$this->setDate();
		$this->getLinks();

		// Get new date array
		$newDate = getdate(mktime(0,0,0,$this->newMonth, 1, $this->newYear));
		// Calculate rest days in previous and next month
		$firstDay = $newDate['wday'];
		$firstDay = ($firstDay == 0) ? 7: $firstDay;
		$daysInMonth = cal_days_in_month ( CAL_GREGORIAN , $this->newMonth , $this->newYear );
		if($this->newMonth != 1){
			$daysInPrevMonth = cal_days_in_month ( CAL_GREGORIAN , $this->newMonth-1 , $this->newYear );
		}
		else if($this->newMonth == 1) {
			$daysInPrevMonth = cal_days_in_month ( CAL_GREGORIAN , 12 , $this->newYear-1 );
		}

		$lastDates = $daysInPrevMonth - $firstDay +1;

		// Start building table
		$table ="<section class='calendar'><header>" . $this->prevLink . "<h3>" . $newDate['month'] . " - " . $newDate['year'] . "</h3>" . $this->nextLink;
		$table .= "</header><table><thead>\n";
		$table .= "<th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th>\n";
		$table .= "</thead>\n";
		$table .= "<tr>";
		
		for ($a=1; $a < $firstDay ; $a++) { 
			$lastDates++;
			$table .= "<td class='lighter'>" . $lastDates . "</td>";
		}

		$d = 0;
		for ($b=0; $b < $daysInMonth ; $b++) { 
			
			$d++;
			$DATE = date('N',mktime(0,0,0, $this->newMonth, $d, $this->newYear));
			
			if ($DATE == 1) {
				$table .= "</tr>\n<tr>";
			}

			if (($this->newMonth == $this->currentMonth && $d == $this->currentDate && $this->newYear == $this->currentYear)) {
				$table .= "<td><strong>" . $d . "</strong></td>";
			}
			else if ($DATE == 7) {
				$table .= "<td class='red'>" . $d . "</td>";
			}
			else {
				$table .= "<td>" . $d . "</td>";
			}
		}
			if ($DATE != 7) {
				$nextMonthDays = 7 - $DATE;
				for ($c=1; $c <= $nextMonthDays ; $c++) { 
					$table .= "<td class='lighter'>" . $c . "</td>";
			}
	}
		$table .= "</tr></table></section>";

		return $table;
	}



	//PRIVATE METHODS

	/**
	 * Set date, handles get parameters and sets newYear and newMonth
	 *
	 */
	private function setDate(){
	// Validate incoming parameters
	if (isset($_GET['month'])) {
		is_numeric($_GET['month']) or die('month has to be numeric');
	}
	if (isset($_GET['year'])) {
		is_numeric($_GET['year']) or die('year has to be numeric');
	}

	// Set new date
	$this->newMonth = isset($_GET['month']) ? ($_GET['month']) : $this->currentMonth;
	$this->newYear = isset($_GET['year']) ? ($_GET['year']) : $this->currentYear;

	if ($this->newMonth > 12) {
		$this->newYear = $this->newYear +1;
		$this->newMonth = 1;
		$_GET['month'] = 1;

	}
	else if ($this->newMonth < 1) {
		$this->newYear = $this->newYear -1;
		$this->newMonth = 12;
		$_GET['month'] = 12;
	}
	
	}

    /**
     * get links, handles previous- and next links
     *
     */
	private function getLinks() {
		// Get new values
	$prevMonth = isset($_GET['month']) ? ($_GET['month'] -1) : $this->currentMonth -1;
	$nextMonth = isset($_GET['month']) ? ($_GET['month'] +1) : $this->currentMonth +1;

		//Write out links
	$this->prevLink = ' <a href="?month=' . $prevMonth . '&amp;year=' . $this->newYear . '"> &laquo; </a> ';
	$this->nextLink = ' <a href="?month=' . $nextMonth . '&amp;year=' . $this->newYear . '"> &raquo; </a> ';


	}


}
