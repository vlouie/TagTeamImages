<?php
  if ($db_conn){
    if (array_key_exists('delCommentSubmit', $_POST)){
      if ($_SESSION['UserType'] == 'admin'){
        $comment_tuple = array(
          ":commentid" => $_POST['deleteComment']
        );
        $allcommenttuples = array (
          $comment_tuple
        );
        $delcomment_result = executeBoundSQL("delete from tag_comment where comment_id=:commentid", $allcommenttuples);
        OCICommit($db_conn);
        header('Location: ' . $_SERVER['REQUEST_URI']);
      }
      else{
        echo "<script>alert('You do not have the proper privileges to delete this comment');</script>";
      }
    }
    elseif (array_key_exists('delImageSubmit', $_POST)){
      if ($_SESSION['UserType'] == 'admin'){
        $image_tuple = array(
          ":imgid" => $_POST['deleteImage']
        );
        $allimagetuples = array (
          $image_tuple
        );
        $delimage_result = executeBoundSQL("delete from tag_image where image_id=:imgid", $allimagetuples);
        OCICommit($db_conn);
        header('Location: index.php');
      }
      else{
        echo "<script>alert('You do not have the proper privileges to delete this image');</script>";
      }
    }
  }
?>
