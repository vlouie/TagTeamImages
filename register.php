<?php
  if ($db_conn){
    if (array_key_exists('registerButton', $_POST)){
      $tuple = array (
        ":name" => $_POST['username'],
        ":password" => $_POST['password'],
        ":type" => 'USER'
      );
      $alltuples = array (
        $tuple
      );
      executeBoundSQL("insert into tag_user values (:name, :type, :password)", $alltuples);
      OCICommit($db_conn);
    }
  }
?>
