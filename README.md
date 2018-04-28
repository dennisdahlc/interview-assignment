# How to setup to run the assignment

The setup for this code is fairly simple.<br>
It is written in PHP using MySQL, so a PHP server with MySQL is needed. I have used XAMPP since it contains both.<br>
Ensure that the PHP is setup to allow for file access and that the version is at least 7.1.
In the top of the MySQLHelper.php variables for location of server, admin user, password and database can be configured.

# Assignment description

With the supplied interface it is possible to send any SELECT statement to the server.
The server will then confirm the correctness of the request and perform the SELECT operation.
Then the result will be written into a log file, and afterwards is it checked that the result is present in the file.
If and only then the result is removed from the database, and the result is sent back to the GUI;

# How to use the GUI

Before running any queries, please start by resetting the database by using the assigned button.
This will created the table if needed be, clear existing data and insert the supplied data, and finally delete any existing log file.

Then the GUI is ready to be used. Use the dropdown boxes to select a query and type in a value, and finally press the Submit button to send the query to the server.
When a result is received from the server, it will be displayed in the textbox below the controls.

# Final considerations

Currently the error message on the server is provided directly to the client, which of course is not safe. If error messages must be sent to the client, they need to be custom messages without no traces of the code and server structure.
The way it is checked if the result has been written to the file is not scalable as the file grows larger. A way to fix this would be to insert the newest result at the top of the file, which in turn requires more time spent writing to the file. I opted to not use this solution, since it would require some fairly ugly code and would not result in a better solution anyway.
This solution is not thead or transaction safe in any regard, so if the database changes during the execution of the code or if more threads are accessing the log file at the same time, concurrency issues will occur. It is out of scope for this assignment to prevent this, but the use of (distributed) locks would be one way to prevent this.