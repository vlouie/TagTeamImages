<?php
include 'header.php';
  $order = "order by rating desc";
  $input = null;
  $searchType = null;

?>
<h3>Search results for:

 <?php 
  	include 'searchHelper.php';
 
  	if ($db_conn){
  		if (array_key_exists('searchButton', $_POST)){ 
  			query();
        include 'sortby.php';
 		}
    elseif(array_key_exists('tester', $_POST)){
      echo "</h3>This is not currently working.";
      global $input;
      var_dump($input);
    }
  }

 		else{
			echo "<script>alert('You currently do not have a connection to the database.')</script>";
		}


function query(){
        global $input, $searchType;
        $input = $_POST['searchBox'];
        $searchType = $_POST['searchType'];
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