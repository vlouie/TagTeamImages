<?php
  if ($db_conn){
    if (array_key_exists('postCommentButton', $_POST)){
      if ($_POST['commentBox'] && isset($_SESSION['Username'])){
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
        $comment_result = executeBoundSQL("insert into tag_comment values (comment_seq.nextval, :username, :img_id, :commentVal, CURRENT_TIMESTAMP, 0)", $allcommenttuples);
        OCICommit($db_conn);
        header('Location: ' . $_SERVER['REQUEST_URI']);
      }
    }
  }
?>
