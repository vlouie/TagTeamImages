<?php
 if ($db_conn){
  if (array_key_exists('loginButton', $_POST)){
      $tuple = array (
        ":name" => $_POST['username'],
        ":password" => $_POST['password'] //md5($_POST[...]) will return md5 hash, use to encrypt password?
      );
      $alltuples = array (
        $tuple
      );
      $result = executeBoundSQL("select * from tag_user where user_name=:name and password=:password", $alltuples);
      $row = OCI_Fetch_Array($result, OCI_BOTH);
      if ($row){
        var_dump($row);
        $_SESSION['Username'] = $_POST['username'];
        $_SESSION['LoggedIn'] = 1;
        //echo "<meta http-equiv='refresh' content='5;index.php'>";
        header('Location: temp.php');
      }
  }
 }
?>
