<?php
  if ($db_conn){
    if (array_key_exists('uploadButton', $_POST)){
      if ($_POST['imgUrl']){
        $tuple = array (
          ":url" => $_POST['imgUrl'],
          ":caption" => $_POST['imgCaption']
        );
        $alltuples = array (
          $tuple
        );
        $result = executeBoundSQL("", $alltuples);
      }
      else{
      }
  }
?>
