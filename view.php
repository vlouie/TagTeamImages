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
  echo "COMMENTS!!!"; // comment logic here
  echo "</div>";
}
?>
<?php include 'footer.php'; ?>  
