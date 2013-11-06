<?php
/* 
   View.php
   This is the setup for each individual image view page.
   Included are queries to retrieve image info, and comments
*/
include 'header.php'; 
if ($db_conn){
  $url = $_SERVER['REQUEST_URI'];
  preg_match("/^.+?\=(.+?)$/", $url, $match);
  $img_id = trim($match[1]);
  $tuple = array (
    ":id" => $img_id
  );
  $alltuples = array (
    $tuple
  );
  $result = executeBoundSQL("select * from tag_image where image_id=:id", $alltuples);
  $row = OCI_Fetch_Array($result, OCI_BOTH);
  echo "<img src='" . $row['IMAGE_LINK'] . "' class='centered' />";
  echo "<div class='innerdiv centered'>";
  echo "<b>Uploaded by " . $row['USER_NAME'] . " at " . $row['UPLOAD_DATE'] . "</b><br />";
  echo "<b>Views:</b> " . $row['VIEW_NO'] . "<br />";
  echo "<b>Rating:</b> " . $row['RATING'] . "<br />";
  echo "\"" . $row['CAPTION'] . "\"";
  echo "</div>";

  echo "<div class='innerdiv centered' id='commentSection'>";
  echo "<h4>Comments</h4>";
  $tuple2 = array (
    ":id" => $img_id
  );
  $alltuples2 = array (
    $tuple2
  );
  $result2 = executeBoundSQL("select * from tag_comment where image_id=:id", $alltuples2);
	while ($row2 = OCI_Fetch_Array($result2, OCI_BOTH)) {
    echo "<div id='comment'>" . $row2["USER_COMMENT"] . "</div>";
  }
  echo "<div id='comment'><textarea cols='50' rows = '3'></textarea><br /><input type='submit' value='post' name='postCommentButton' /></div>";
  //$row2 = OCI_Fetch_Array($result2, OCI_BOTH);
  //var_dump($row2);
  echo "</div>";
}
?>
<?php include 'footer.php'; ?>  
