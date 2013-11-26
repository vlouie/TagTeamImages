<!-- This is the HTML for the header content that will be on every page -->
<html>
<head>
<title>TagTeam Images</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/image_crop.js"></script>
</head>
<body>
<div id="login">
  <form method="POST" action="">
<?php
  $db_conn=OCILogon("ora_g1f7", "a70279096", "ug");
  $success = True; 
  session_save_path('tmp');
  ini_set('session.gc_probability', 1);
  session_start(); 
  date_default_timezone_set('America/Los_Angeles');
  $order = " order by rating desc";
  $input = null;
  $searchType = null;
  $order_type=null;

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
  <form method="POST" action="search.php">
    <select name='searchType'>
      <option>Text</option>
      <option>User</option>
      <option>Tag</option>
      <option>Surprise Me!</option>
    </select>
  <input type="text" name="searchBox" size="25" />
  <input type="submit" value="search" name="searchButton"/>
  </form>
</div>

<div id="container">
  <div id="content" class="divstyle shadow">