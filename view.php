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

  $tag_array = array();
  $tag_many_result = executeBoundSQL("select * from tag_many_image where image_id=:id", $alltuples);
	while ($tag_many_row = OCI_Fetch_Array($tag_many_result, OCI_BOTH)) {
    $tag_tuple = array (
      ":id" => $tag_many_row['TAG_ID']
    );
    $alltagtuples = array (
      $tag_tuple
    );
    $tagresult = executeBoundSQL("select * from tag where tag_id=:id", $alltagtuples);
    $tagrow = OCI_Fetch_Array($tagresult, OCI_BOTH);
    array_push($tag_array, $tagrow['TAG_VALUE']);
  }
  $conv_date = strtotime($row['UPLOAD_DATE']);
  echo "<img src='" . $row['IMAGE_LINK'] . "' class='centered maxSize' />";
  echo "<div class='innerdiv centered'>";
  echo "<b>Uploaded by " . $row['USER_NAME'] . " at " . gmdate("H:i \o\\n M d, Y", $conv_date) . "</b><br />";
  echo "<b>Views:</b> " . $row['VIEW_NO'] . "<br />";
  echo "<b>Rating:</b> " . $row['RATING'] . "<br />";
  echo "<b>Tags:</b> " . implode(", ", $tag_array) . " <br />";
  if ($row['CAPTION']){
    echo "\"" . $row['CAPTION'] . "\" <br />";
  }
  echo "<input type='submit' value='+1' name='voteUpButton' />";
  echo "<input type='submit' value='-1' name='voteDownButton' />";
  echo "</div>";

  echo "<div class='innerdiv centered' id='commentSection'>";
  echo "<h4>Comments</h4>";
  echo "<form method='POST' action'?'>";
  echo "<div id='comment'>";
  echo "<textarea name='commentBox' cols='50' rows = '3'></textarea><br />";
  echo "<input type='submit' value='post' name='postCommentButton' />";
  echo "</div>";
  echo "</form>";
  $tuple2 = array (
    ":id" => $img_id
  );
  $alltuples2 = array (
    $tuple2
  );
  $result2 = executeBoundSQL("select * from tag_comment where image_id=:id", $alltuples2);
	while ($row2 = OCI_Fetch_Array($result2, OCI_BOTH)) {
    $convcomment_date = strtotime($row2['COMMENT_DATE']);
    echo "<div id='comment'>" . $row2["USER_COMMENT"] . "<br /><sup>- " . $row2["USER_NAME"] . " at " . gmdate("H:i \o\\n M d, Y", $convcomment_date) . "</sup></div>";
  }
  echo "</div>";
  include 'comment.php';
}
?>
<?php include 'footer.php'; ?>  
