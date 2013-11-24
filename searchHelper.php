<?php
function query_helper($alltuples){
	global $input;
	global $searchType;
  				switch($searchType){
  					case "Surprise Me!":
  						$query = surprise_query($alltuples);
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
										" and rowNum <=10 " . 
										$order, 
										$alltuples);

			$numRows = executeBoundSQL("select count(*) as total from tag_image " . 
										$query . 
										" and rowNum <=10 " . 
										$order, 
										$alltuples);
			echo " <b><i>$input</i></b></h3>";
			$total = OCI_Fetch_Array($numRows, OCI_BOTH);
			if($total[0] == 0)
				echo "There were zero results found.";
			else{
?>
<!-- Adding the other dropdown here for sorting results -->
<!-- make sure that this does not appear when there are 0 results (if possible) -->

  	<form method="POST" action="search.php">
      <INPUT type="submit" value="Change" name="tester" style="float: right;">
	<select name='orderType' style="float: right;">
		<option value="pop">Popularity (Default)</option>
		<option value="dNew">Date Uploaded (Newest-Oldest)</option>
		<option value="dOld">Date Uploaded (Oldest-Newest)</option>
	</select>
</form>
<?php
			echo "</br></br>";
			while($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<a href='view.php?id=" . $row["IMAGE_ID"] . "'>";
				echo "<img src='" . $row['IMAGE_LINK'] . "' width='100px' height='100px' />";
				echo "</a>";
			}
		}
	}

function surprise_query($alltuples){
$random = rand(0,2);
$avgRate = executeBoundSQL("	select avg(rating) 
 								from tag_image
 								where image_id IN (
 									select image_id
 									from tag_vote
 									group by image_id
 									having count(*) > 0)", $alltuples);
$avg = oci_fetch_array($avgRate, OCI_BOTH);

 switch ($random) {
 	case '0':
 		echo "Images without negative comments and rating >= $avg[0].</h3></br>";
		return "	where image_id NOT IN
				(select distinct image_id from tag_vote where vote = '-1')
				and rating >= $avg[0]";
 		break;
  	case '1':
  	 	echo "Images by the one of the top uploaders.</h3></br>";
		return "	where user_name = 	(select min(user_name)
										from (select user_name, count(*) as numUpload from tag_image group by user_name)
										where numUpload >= ALL (select count(*) from tag_image group by user_name))";
 		break;
  	case '2':
  		echo "Create a third one.</h3>";
		return " where user_name = 'nicole'";
 		break;	
 	default:
 		echo "The random value return is not between 0 and 2.";
 		break;
 }
}
?>