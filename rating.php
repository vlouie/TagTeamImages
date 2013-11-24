<?php
  if ($db_conn){
    if (array_key_exists('voteUpButton', $_POST)){
      if (isset($_SESSION['Username'])){
        $pageurl = $_SERVER['REQUEST_URI'];
        preg_match("/^.+?\=(.+?)$/", $pageurl, $id_match);
        $imgid = trim($id_match[1]);
        $rateup_tuple = array (
          ":username" => $_SESSION['Username'],
          ":img_id" => $imgid 
        );
        $allrateuptuples = array (
          $rateup_tuple
        );
        $check_rate = executeBoundSQL("select vote_id from tag_vote where image_id=:img_id and user_name=:username", $allrateuptuples);
        $check_row = OCI_Fetch_Array($check_rate, OCI_BOTH);
        if (!$check_row){
          $rateup_result = executeBoundSQL("insert into tag_vote values (vote_seq.nextval, 1, :username, :img_id)", $allrateuptuples);
          OCICommit($db_conn);
          $update_result = executeBoundSQL("update tag_image set rating=rating+1 where image_id=:img_id", $allrateuptuples);
          OCICommit($db_conn);
          header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        else{
          echo "<script>alert('You have already rated this image');</script>";
        }
      }
      else{
        echo "<script>alert('Please log in to rate this image');</script>";
      }
    }
    elseif (array_key_exists('voteDownButton', $_POST)){
      if (isset($_SESSION['Username'])){
        $pageurl = $_SERVER['REQUEST_URI'];
        preg_match("/^.+?\=(.+?)$/", $pageurl, $id_match);
        $imgid = trim($id_match[1]);
        $ratedown_tuple = array (
          ":username" => $_SESSION['Username'],
          ":img_id" => $imgid 
        );
        $allratedowntuples = array (
          $ratedown_tuple
        );
        $check_rate = executeBoundSQL("select vote_id from tag_vote where image_id=:img_id and user_name=:username", $allratedowntuples);
        $check_row = OCI_Fetch_Array($check_rate, OCI_BOTH);
        if (!$check_row){
          $ratedown_result = executeBoundSQL("insert into tag_vote values (vote_seq.nextval, -1, :username, :img_id)", $allratedowntuples);
          OCICommit($db_conn);
          $update_result = executeBoundSQL("update tag_image set rating=rating-1 where image_id=:img_id", $allratedowntuples);
          OCICommit($db_conn);
          header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        else{
          echo "<script>alert('You have already rated this image');</script>";
        }
      }
      else{
        echo "<script>alert('Please log in to rate this image');</script>";
      }
    }
  }
?>
