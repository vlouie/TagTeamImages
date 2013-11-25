<?php
include 'header.php';

?>
<h3>Search results for:

 <?php 
  	include 'searchHelper.php';
 
  	if ($db_conn){
  		if (array_key_exists('searchButton', $_POST)){ 
        global $input, $searchType;
        $input = $_POST['searchBox'];
        $searchType = $_POST['searchType'];
  			query();
        include 'sortby.php';
 		}
    // This is used to handle the case there a user selects a tag from view.php
        else{
        $url = $_SERVER['REQUEST_URI'];
        preg_match("/^(.+?)\=(.+?)$/", $url, $match);
        $searchType = "Tag";
        $url_input = trim($match[2]); 
        $input = urldecode($url_input);
        query();
    }
      if(array_key_exists('tester', $_POST)){
        echo "</h3>This is not currently working.";
    }
  }

 		else{
			echo "<script>alert('You currently do not have a connection to the database.')</script>";
		}


function query(){
        global $input, $searchType;
  			$tuple = array (
  				":input" => $_POST['searchBox']
  				);
  			$alltuples = array (
  				$tuple
  				);


 			// All searches have been limited to 10 results currently, as to not overload the results presented
 			// CASE if user does not enter anything before clicking button
  			if(empty($input) && ($searchType != 'Surprise Me!')){
  				echo "<script>alert('Please enter text for the search')</script>";
  			}

  			else{
		query_helper($alltuples);

	}
}
include 'footer.php';
?>