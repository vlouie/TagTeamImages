<?php
  if ($db_conn){
    if (array_key_exists('uploadButton', $_POST)){
      if ($_POST['imgUrl']){
        $tag_array = explode(',', $_POST['imgTags']);
        foreach ($tag_array as &$tag_val){
          $check_tuple = array (
            ":tagValue" => $tag_val
          );
          $allchecktuples = array (
            $check_tuple
          );
          $check_result = executeBoundSQL("select * from tag where tag_value=:tagValue", $allchecktuples);
          $check_row = OCI_Fetch_Array($check_result, OCI_BOTH);
          if (!$check_row){
            $tag_insert = executeBoundSQL("insert into tag values (tag_seq.nextval, :tagValue)", $allchecktuples);
            OCICommit($db_conn);
          }
          else{
          }
        }
        unset($tag_val);
        $tuple = array (
          ":url" => $_POST['imgUrl'],
          ":caption" => $_POST['imgCaption'],
          ":username" => $_SESSION['Username'],
        );
        $alltuples = array (
          $tuple
        );
        $result = executeBoundSQL("insert into tag_image values (img_seq.nextval, :username, :url, :caption, 0, 0, CURRENT_TIMESTAMP)", $alltuples);
        OCICommit($db_conn);

        $select_id = executeBoundSQL("select * from tag_image where image_link=:url and user_name=:username", $alltuples);
        $select_row = OCI_Fetch_Array($select_id, OCI_BOTH);
        if ($select_row){
          foreach ($tag_array as &$tag_val){
            $selecttagtuple = array (
              ":tagVal" => $tag_val
            );
            $alltagtuples = array (
              $selecttagtuple
            );
            $select_tag = executeBoundSQL("select * from tag where tag_value=:tagVal", $alltagtuples);
            $tag_row = OCI_Fetch_Array($select_tag, OCI_BOTH);
            $tag_image_tuple = array (
              ":img_id" => $select_row['IMAGE_ID'],
              ":tag_id" => $tag_row['TAG_ID']
            );
            $all_tagimage = array (
              $tag_image_tuple
            );
            $tag_image = executeBoundSQL("insert into tag_many_image values (:img_id, :tag_id)", $all_tagimage);
            OCICommit($db_conn);
          }
          unset($tag_val);
          header('Location: ' . $_SERVER['REQUEST_URI']);
        }
      }
      else{
        echo "<script>alert('Please enter an image URL');</script>";
      }
    }
  }
?>
