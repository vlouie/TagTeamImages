<?php
 if ($db_conn){
  if (array_key_exists('registerButton', $_POST)){
    if ($_POST['username'] && $_POST['password']){
      if (gettype($_POST['username']) == 'string' && gettype($_POST['password']) == 'string'){
        if (!preg_match('/[^a-zA-Z_\-0-9]/', $_POST['password']) && !preg_match('/[^a-zA-Z_\-0-9]/', $_POST['username'])){
          $tuple = array (
            ":name" => $_POST['username'],
            ":password" => $_POST['password'],
            ":type" => 'user'
          );
          $alltuples = array (
            $tuple
          );
          $checkresult = executeBoundSQL("select user_name from tag_user where user_name=:name", $alltuples);
          $checkrow = OCI_Fetch_Array($checkresult, OCI_BOTH);
          if (!$checkrow){
            $result = executeBoundSQL("insert into tag_user values (:name, :type, :password)", $alltuples);
            $_SESSION['Username'] = $_POST['username'];
            $_SESSION['LoggedIn'] = 1;
            $_SESSION['UserType'] = 'user';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            
            OCICommit($db_conn);
          }
          else{
            echo "<script>alert('Username is already taken');</script>";
          }
        }
        else{
          echo "<script>alert('Usernames and passwords cannot contain symbols');</script>";
        }
      }
      else{
        echo "<script>alert('Please enter valid username and password values');</script>";
      }
    }
    else{
      echo "<script>alert('Please enter a username and password');</script>";
    }
  }
  elseif (array_key_exists('loginButton', $_POST)){
    if ($_POST['username'] && $_POST['password']){
      if (gettype($_POST['username']) == 'string' && gettype($_POST['password']) == 'string'){
        if (!preg_match('/[^a-zA-Z_\-0-9]/', $_POST['password']) && !preg_match('/[^a-zA-Z_\-0-9]/', $_POST['username'])){
          $tuple = array (
            ":name" => $_POST['username'],
            ":password" => $_POST['password']
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
            header('Location: ' . $_SERVER['REQUEST_URI']);
          }
          else{
            echo "<script>alert('This username/password combination does not exist');</script>";
          }
        }
        else{
          echo "<script>alert('Passwords cannot contain symbols');</script>";
        }
      }
      else{
        echo "<script>alert('Please enter valid username and password input');</script>";
      }
    } 
    else{
      echo "<script>alert('Please enter a username and password');</script>";
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
    header('Location: ' . $_SERVER['REQUEST_URI']);
  }
 }
?>
