This is an autonomous codeigniter app that is meant to sit along side Ushahidi and connect to the same database. 

Edit your database settings in /codeigniter/app/config/database.php   

Copy the database.php.sample and rename it database.php and edit your own database settings. 

Do not check in database.php into git  

This was built to work with Ushahidi 2.0.1 and Open311 GeoReport v2  Not all of the functionality of GeoReport v2 has
been developed here on this initial commit.

A demo of this running can be seen here (pointing directly to the output of the services resource)
http://ushahidi.georeport.org/georeport/v2/services.xml

This is originally an export from the subversion repository at
http://svn.ashlock.us/public/georeport_ushahidi/