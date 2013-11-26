<?php
include 'header.php';

?>
<h3>Search results for:

 <?php 
  	include 'searchHelper.php';
  	if ($db_conn){
      global $input, $searchType;

  		if (array_key_exists('searchButton', $_POST)){ 
        $searchType = $_POST['searchType'];
        if($searchType == "Surprise Me!"){
          $input = rand(0,2);
        }
        else{
        $input = $_POST['searchBox'];          
        }
        $order = " order by rating desc";
        header("Location: search.php?".$searchType."=".$input);
 		   }

      if(array_key_exists('tester', $_POST)){
        global $order;
        url_helper();
        $orderType= $_POST['orderType'];

          switch ($orderType) {
            case "dNew":
            $order = " order by upload_date desc";
            break;

            case "dOld";
            $order = " order by upload_date asc";
            break;

            default:
            $order = " order by rating desc";
            break;
          }

        query();
      }
      
      else{
        url_helper();
        query();
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

function url_helper(){
    global $searchType, $input;
    $url = $_SERVER['REQUEST_URI'];
    preg_match("/.+\?(.+?)\=(.+?)?$/", $url, $match);
    $search_input = trim($match[1]);
    $searchType = urldecode($search_input);
    $url_input = trim($match[2]); 
    if($searchType=="Surprise Me!"){
      $random = $input;
    }
      else{
            $input = urldecode($url_input);
      }
}

include 'footer.php';
?>
