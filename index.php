<html>
<head>
<title>TagTeam Images</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<?php include 'main.php'; ?>
<body>
<div id="login">
  username: <input type="text" name="username" size="15" />
  password: <input type="password" name="password" size="15" />
  <input type="submit" value="login" name="loginButton" />
</div>
<div id="top" class="divstyle">
  <h2>TagTeam</h2>
  <input type="text" name="searchBox" size="25" />
  <input type="submit" value="search" name="searchButton" />
</div>
<div id="container">
  <div id="content" class="divstyle">
    <img src="http://www.grubgrade.com/wp-content/uploads/2009/08/Fluffernutter.jpg" />
  </div>
  <div id="sidebar" class="divstyle">
    <h3>Upload</h3>
    <b>URL</b>
    <input type="text" name="imgUrl" />
    <br />
    <b>Caption</b>
    <input type="text" name="imgCaption" />
    <br />
    <b>Tags</b>
    <input type="text" name="imgTags" />
    <input type="submit" value="Upload" name="uploadButton" />
  </div>
</div>
</body>
</html>
