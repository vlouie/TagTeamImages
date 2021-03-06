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
  if ($match){
    $img_id = trim($match[1]);
    $tuple = array (
      ":id" => $img_id
    );
    $alltuples = array (
      $tuple
    );
    $result = executeBoundSQL("select upload_date, image_link, user_name, view_no, rating, caption from tag_image where image_id=:id", $alltuples);
    $row = OCI_Fetch_Array($result, OCI_BOTH);

    $updateresult = executeBoundSQL("update tag_image set view_no=view_no+1 where image_id=:id",$alltuples);
    OCICommit($db_conn);

    $tag_array = array();
    $tag_many_result = executeBoundSQL("select tag_id from tag_many_image where image_id=:id", $alltuples);
    while ($tag_many_row = OCI_Fetch_Array($tag_many_result, OCI_BOTH)) {
      $tag_tuple = array (
        ":id" => $tag_many_row['TAG_ID']
      );
      $alltagtuples = array (
        $tag_tuple
      );
      $tagresult = executeBoundSQL("select tag_value from tag where tag_id=:id", $alltagtuples);
      $tagrow = OCI_Fetch_Array($tagresult, OCI_BOTH);
      array_push($tag_array, $tagrow['TAG_VALUE']);
    }
    $conv_date = strtotime($row['UPLOAD_DATE']);
    echo "<img src='" . $row['IMAGE_LINK'] . "' class='centered maxSize' />";
    echo "<div class='innerdiv centered'>";
    echo "<form method='POST' action=''>";
    echo "<input type='submit' class='viewNav' value='<' name='navLeft' />";
    echo "<input type='submit' class='viewNav' value='>' name='navRight' />";
    echo "</form>";
    echo "</div>";
    if (array_key_exists('navLeft', $_POST)){
      $pageurl = $_SERVER['REQUEST_URI'];
      preg_match("/^.+?\=(.+?)$/", $pageurl, $id_match);
      $imgid = trim($id_match[1]);
      if (intval($imgid) == 1){
        header('Location: index.php');
      }
      else{
        header('Location: view.php?id=' . strval(intval($imgid)-1));
      }
    }
    elseif (array_key_exists('navRight', $_POST)){
      $pageurl = $_SERVER['REQUEST_URI'];
      preg_match("/^.+?\=(.+?)$/", $pageurl, $id_match);
      $imgid = trim($id_match[1]);
      $nav_result = executePlainSQL("select max(image_id) from tag_image");
      $row = OCI_Fetch_Array($nav_result, OCI_BOTH);
      if ($imgid == $row['MAX(IMAGE_ID)']){
        header('Location: index.php');
      }
      else{
        header('Location: view.php?id=' . strval(intval($imgid)+1));
      }
    }

    echo "<div class='innerdiv centered'>";
    if ($row['CAPTION']){
      echo "\"" . $row['CAPTION'] . "\" <br />";
    }
    echo "<b>Uploaded by " . $row['USER_NAME'] . " at " . date("H:i \P\S\T \o\\n M d, Y", $conv_date) . "</b><br />";
    echo "<b>Views:</b> " . $row['VIEW_NO'] . "<br />";
    echo "<b>Rating:</b> " . $row['RATING'] . "<br />";
    echo "<b>Tags:</b> ";

    // This will return all the tags, which are linked to the searches for the tags
      for ($i=0; $i < (count($tag_array)-1); $i++) { 
        echo "<u><a href='search.php?tag=" . $tag_array[$i]. "'>";
        echo $tag_array[$i]. "</a></u>, ";
      }
      // This is just used to handle the last tag entry in the array.
        echo "<u><a href='search.php?tag=" . end($tag_array) . "'>";
        echo end($tag_array). "</a></u><br />"; 

    echo "<form method='POST' action''>";
    echo "<input type='submit' value='+1' name='voteUpButton' />";
    echo "<input type='submit' value='-1' name='voteDownButton' />";
    echo "</form>";
    include 'rating.php';
    if ($_SESSION['UserType'] == 'admin'){
      echo "<form method='POST' action=''>";
      echo "<input type='hidden' name='deleteImage' value='" . $img_id . "' />";
      echo "<input type='submit' value='Delete Image' name='delImageSubmit' onclick='return confirm(\"Are you sure? Once deleted, this image cannot be recovered!\")' />";
      echo "</form>";
    }
    echo "</div>";


    echo "<div class='innerdiv centered' id='commentSection'>";
    echo "<h4>Comments</h4>";
    echo "<form method='POST' action'?'>";
    echo "<div id='comment'>";
    echo "<textarea name='commentBox' cols='50' rows = '3' maxlength='255'></textarea><br />";
    echo "<input type='submit' value='post' name='postCommentButton' />";
    echo "</div>";
    echo "</form>";
    $tuple2 = array (
      ":id" => $img_id
    );
    $alltuples2 = array (
      $tuple2
    );
    $result2 = executeBoundSQL("select comment_date, user_comment, user_name, comment_id from tag_comment where image_id=:id", $alltuples2);
    while ($row2 = OCI_Fetch_Array($result2, OCI_BOTH)) {
      $convcomment_date = strtotime($row2['COMMENT_DATE']);
      echo "<div id='comment'>";
      echo $row2["USER_COMMENT"] . "<br />";
      echo "<sup>- " . $row2["USER_NAME"] . " at " . date("H:i \P\S\T \o\\n M d, Y", $convcomment_date);
      if ($_SESSION['UserType'] == 'admin'){
        echo "<form class='commentDelete' method='POST' action=''>";
        echo "<input type='hidden' name='deleteComment' value='" . $row2["COMMENT_ID"] . "' />";
        echo "<input type='submit' value='x' name='delCommentSubmit' />";
        echo "</form>";
      }
      echo "</sup>";
      echo "</div>";
    }
    echo "</div>";
    include 'comment.php';
    include 'view_admin.php';
  }
  else{
    header('Location: index.php');
  }
}
?>
<?php include 'footer.php'; ?>  
