hex_connect
============

The Connection Game - Explore a range of connected subjects/nodes on a hexagonal grid.

Project created using PHP, jQuery, JavaScript, and AJAX on a MacBook Pro running Mavericks.

Before deploying on a live server, it is recommended that you experiment with the program on a 
locally hosted server like MAMP or WAMP.

DEPLOYMENT:
Update the connection.php file so that it shows the correct host, user, and password for your server.
Copy all files EXCEPT FOR SUBMIT.PHP and ADMIN.PHP into a folder of your choice.
The admin.php file should only be used locally to add items (nodes and connections) into the database.
All other changes to the database should be done directly through MySQL Workbench
or through your preferred database management system.
To upload the database, you will need to go into your hosting services control panel and use the appropriate tools there.
My hosting service has a phpMyAdmin section for this, but yours may differ.

ADMINISTRATION:
Please note that all of the features in the admin.php do not work at this time.
In order to set yourself "as an admin,"" register using the form on the submit.php page.
There is no programatic difference between users and the admin. Any user can make changes via the admin page,
which is why it should only be stored locally.

Originally, this program was set up so that users could submit their own subjects/nodes via an interface similar
to the one on the admin page, but this was impractical.  It made a lot more sense for them to simply send an email
rather than forcing them to go through all the effort of registering, learning the submission interface, 
and formatting their own entries that you would probably reformat anyway.

Making submissions to the database via the submit.php page assigns a pending status of "0" to the entries in the database.
This has been known to make the program hang and should be avoided.

Please contact me with any additional questions at basdude@aol.com.


