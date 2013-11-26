<?php
  if ($db_conn){
    if (array_key_exists('uploadButton', $_POST)){
      if ($_POST['imgUrl']){
        if (preg_match('/http\S+(jpg|gif|png)/', $_POST['imgUrl'])){
          $tag_flag = false;
          $tag_array = explode(',', $_POST['imgTags']);
          foreach ($tag_array as &$tag){
            $tag_val = trim($tag);
            if (strlen($tag_val) > 30){
              $tag_flag = true;
              echo "<script>alert('The maximum length of a tag is 30 characters. One of your tags is more than 30 characters.');</script>";
              break;
            }
            $check_tuple = array (
              ":tagValue" => $tag_val
            );
            $allchecktuples = array (
              $check_tuple
            );
            $check_result = executeBoundSQL("select tag_id from tag where tag_value=:tagValue", $allchecktuples);
            $check_row = OCI_Fetch_Array($check_result, OCI_BOTH);
            if (!$check_row){
              $tag_insert = executeBoundSQL("insert into tag values (tag_seq.nextval, :tagValue)", $allchecktuples);
              OCICommit($db_conn);
            }
          }
          //unset($tag_val);
          unset($tag);
          if ($tag_flag){
            echo "<script>alert('Could not upload image');</script>";
            break;
          }
          else{
            $user = $_SESSION['Username'];
            if (!isset($_SESSION['Username'])){
              $user = 'Anonymous';
            }
            $tuple = array (
              ":url" => $_POST['imgUrl'],
              ":caption" => htmlspecialchars($_POST['imgCaption']),
              ":username" => $user,
            );
            $alltuples = array (
              $tuple
            );
            $result = executeBoundSQL("insert into tag_image values (img_seq.nextval, :username, :url, :caption, 0, 0, CURRENT_TIMESTAMP)", $alltuples);
            OCICommit($db_conn);
              
            $select_id = executeBoundSQL("select image_id from tag_image where image_link=:url and user_name=:username", $alltuples);
            $select_row = OCI_Fetch_Array($select_id, OCI_BOTH);
            if ($select_row){
              foreach ($tag_array as &$tag){
                $tag_val = trim($tag);
                $selecttagtuple = array (
                  ":tagVal" => $tag_val
                );
                $alltagtuples = array (
                  $selecttagtuple
                );
                $select_tag = executeBoundSQL("select tag_id from tag where tag_value=:tagVal", $alltagtuples);
                $tag_row = OCI_Fetch_Array($select_tag, OCI_BOTH);
                $tag_image_tuple = array (
                  ":img_id" => $select_row['IMAGE_ID'],
                  ":tag_id" => $tag_row['TAG_ID']
                );
                $all_tagimage = array (
                  $tag_image_tuple
                );
                $tag_image = executeBoundSQL("insert into tag_many_image values (:img_id, :tag_id)", $all_tagimage);
              }
              //commit after the transaction whole
              OCICommit($db_conn);
              oci_close($db_conn);//will rollback if any uncommited transactions
              unset($tag);
              header('Location: ' . $_SERVER['REQUEST_URI']);
            }
          }
        }
        else{
          echo "<script>alert('Image URL is not formatted properly (i.e. http://example.jpg)');</script>";
        }
      }
      else{
        echo "<script>alert('Please enter an image URL');</script>";
      }
    }
  }
?>
