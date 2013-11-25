<?php
  if ($db_conn){
    if (array_key_exists('postCommentButton', $_POST)){
      if ($_POST['commentBox'] && isset($_SESSION['Username'])){
        if (gettype($_POST['commentBox'] == 'string')){
          $pageurl = $_SERVER['REQUEST_URI'];
          preg_match("/^.+?\=(.+?)$/", $pageurl, $id_match);
          $imgid = trim($id_match[1]);
          $comment_tuple = array (
            ":commentVal" => htmlspecialchars($_POST['commentBox']),
            ":username" => $_SESSION['Username'],
            ":img_id" => $imgid 
          );
          $allcommenttuples = array (
            $comment_tuple
          );
          $comment_result = executeBoundSQL("insert into tag_comment values (comment_seq.nextval, :username, :img_id, :commentVal, CURRENT_TIMESTAMP)", $allcommenttuples);
          OCICommit($db_conn);
          header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        else{
          echo "<script>alert('Please enter a valid comment');</script>";
        }
      }
      else{
        echo "<script>alert('You must be logged in to comment on images');</script>";
      }
    }
  }
?>
