<!-- This is the HTML for the header content that will be on every page -->
<html>
<head>
<title>TagTeam Images</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div id="login">
  <form method="POST" action="?">
<?php
  $db_conn=OCILogon("ora_g1f7", "a70279096", "ug");
  $success = True; 
  session_save_path('tmp');
  ini_set('session.gc_probability', 1);
  session_start(); 

  include 'main.php';

  if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){
  echo "Welcome, <a href='account.php'><b>" . $_SESSION['Username'] . "</b></a>! ";
?>
    <input type="submit" value="log out" name="logoutButton" />
<?php
  }
  else{
?>
    username: <input type="text" name="username" size="15" maxlength="30" />
    password: <input type="password" name="password" size="15" maxlength="30" />
    <input type="submit" value="log in" name="loginButton" />
    <input type="submit" value="register" name="registerButton" />
<?php
  }
  include 'login.php';
?>
  </form>
</div>
<div id="top" class="divstyle shadow">
  <a href="index.php"><h2>TagTeam</h2></a>
  <input type="text" name="searchBox" size="25" />
  <input type="submit" value="search" name="searchButton" />
</div>
<div id="container">
  <div id="content" class="divstyle shadow">
