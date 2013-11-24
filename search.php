<?php
include 'header.php';
?>
<h3>Search results for:

 <?php 
  	$result = null;
  	$query = null;
  	$order = "order by rating desc";
  	$alltuples = null;
  	
  	if ($db_conn){
  		if (array_key_exists('searchButton', $_POST)){
  			$tuple = array (
  				":input" => $_POST['searchBox']
  				);
  			$alltuples = array (
  				$tuple
  				);

  			$input = $_POST['searchBox'];
  			$searchType = $_POST['searchType'];

  			echo " <b><i>$input</i></b></h3>";


 			// All searches have been limited to 10 results currently, as to not overload the results presented
 			// CASE if user does not enter anything before clicking button
  			if(empty($input)){
  				echo "<script>alert('Please enter text for the search')</script>";
  			}

  			else{
?>
<!-- Adding the other dropdown here for sorting results -->
<!-- make sure that this does not appear when there are 0 results (if possible) -->

  	<form method="POST" action="sortby.php">
	<select name='orderType' style="float: right;">
		<option value="pop">Popularity (Default)</option>
		<option value="dNew">Date Uploaded (Newest-Oldest)</option>
		<option value="dOld">Date Uploaded (Oldest-Newest)</option>
	</select>
	<!-- <INPUT type="submit" value="Go" name="tester" style="float: right;"> -->
</form>
<?php
		query_helper($searchType,$order,$alltuples);
	}
}
else echo "I don't know what this is doing right now.";
}
	else{
		echo "<script>alert('You currently do not have a connection to the database.')</script>";
	}

function query_helper($searchType,$order,$alltuples){
  				switch($searchType){
  					case "Surprise Me!":
  						echo "This is option will contain our division query.";			
  						break;

  					case "User":
  						$query = "	join tag_user on tag_user.user_name = tag_image.user_name
  									where lower(tag_user.user_name) = lower(:input)";
  						break;

  					case "Tag":
  						$query = "	join tag_many_image on tag_many_image.image_id = tag_image.image_id
  									join tag on tag_many_image.tag_id = tag.tag_id
  									where lower(tag_value) = lower(:input)";
  						break;

  					default:
						$query = "	join tag_many_image on tag_many_image.image_id = tag_image.image_id
				  					join tag on tag.tag_id = tag_many_image.tag_id
				  					where (	lower(caption) = lower(:input) 
				  					or lower(tag_value) = lower(:input))";
  						break;

					}
				
			$result = executeBoundSQL("	select distinct tag_image.image_id,image_link, rating
										from tag_image " . 
										$query . 
										"and rowNum <= 10 " . 
										$order, 
										$alltuples);
			//Ask TA about how to count the number of rows returned...
			// This returns the images (If there are any)
			while($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo $row['RATING'];
				echo "<a href='view.php?id=" . $row["IMAGE_ID"] . "'>";
				echo "<img src='" . $row['IMAGE_LINK'] . "' width='100px' height='100px' />";
				echo "</br></a>";
			}
		}
include 'footer.php';
?>