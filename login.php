<?php
 if ($db_conn){
  if (array_key_exists('registerButton', $_POST)){
    if ($_POST['username'] && $_POST['password']){
      $tuple = array (
        ":name" => $_POST['username'],
        ":password" => $_POST['password'],
        ":type" => 'user'
      );
      $alltuples = array (
        $tuple
      );
      $result = executeBoundSQL("insert into tag_user values (:name, :type, :password)", $alltuples);
      $_SESSION['Username'] = $_POST['username'];
      $_SESSION['LoggedIn'] = 1;
      $_SESSION['UserType'] = 'user';
      //echo "<meta http-equiv='refresh' content='0;index.php'>";
      header('Location: ' . $_SERVER['REQUEST_URI']);
      
      OCICommit($db_conn);
    }
    else{
      echo "<script>alert('Please enter a username AND password');</script>";
    }
  }
  elseif (array_key_exists('loginButton', $_POST)){
    if ($_POST['username'] && $_POST['password']){
      $tuple = array (
        ":name" => $_POST['username'],
        ":password" => $_POST['password'] //md5($_POST[...]) will return md5 hash, use to encrypt password?
      );
      $alltuples = array (
        $tuple
      );
      $result = executeBoundSQL("select user_type from tag_user where user_name=:name and password=:password", $alltuples);
      $row = OCI_Fetch_Array($result, OCI_BOTH);
      if ($row){
        $_SESSION['Username'] = $_POST['username'];
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['UserType'] = $row['USER_TYPE'];
        //echo "<meta http-equiv='refresh' content='0;index.php'>";
        header('Location: ' . $_SERVER['REQUEST_URI']);
      }
      else{
        echo "<script>alert('This username/password combination does not exist');</script>";
      }
    } 
    else{
      echo "<script>alert('Please enter a username AND password');</script>";
    }
  }
  elseif (array_key_exists('logoutButton', $_POST)){
    $_SESSION = array();

    if (ini_get("session.use_cookies")){
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }
    session_destroy();
    //echo "<meta http-equiv='refresh' content='0;index.php'>";
    header('Location: ' . $_SERVER['REQUEST_URI']);
  }
 }
?>
