<!-- Use index.php as a template for any subsequent pages -->
<?php include 'header.php'; ?>
<!-- START OF CONTENT FOR HOMEPAGE --> 
<h3>Most Recent Uploads</h3>
<div class="imageContainer">
<?php
if ($db_conn){
  $result = executePlainSQL("select image_id, image_link from tag_image");
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
  //link to view image by linking to view.php and including the id as a url param -->
    echo "<p class = 'cropContainer'>";
    echo "<a href='view.php?id=" . $row["IMAGE_ID"] . "'>";
    echo "<img src='" . $row['IMAGE_LINK'] . "' class='cropped' />";
    echo "</a>";
    echo "</p>";
  }
}
?>
</div>
<h3>Most Popular Images</h3>
<h3>Highest Rated Images</h3>
<!-- END OF CONTENT FOR HOMEPAGE --> 
<?php include 'footer.php'; ?>  
