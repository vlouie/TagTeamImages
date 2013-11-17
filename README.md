General Notes:
- the files and subdirectories in this folder should all go into your public\_html
- when adding a new file, always remember to do 'chmod 755 <filename>' on it!
- when adding a new folder, always remember to do 'chmod 711 <foldername>' on it!
- the tmp folder is for the temporary session files (user login system)
- temp.php is just a junk file for testing things
- index.php is the main page, follow its layout for how to setup any subsequent pages
-- header.php contains the login bar, search bar, and database connection
-- footer.php contains the image upload sidebar and closing the database connection
-- the basic order of a web page is: include header.php, add content, include footer.php
