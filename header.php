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
  session_save_path('tmp');
  ini_set('session.gc_probability', 1);
  session_start(); 
  if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){
  echo "Welcome, " . $_SESSION['Username'] . "! ";
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
?>
  </form>
</div>
<div id="top" class="divstyle shadow">
  <h2>TagTeam</h2>
  <input type="text" name="searchBox" size="25" />
  <input type="submit" value="search" name="searchButton" />
</div>
<div id="container">
  <div id="content" class="divstyle shadow">