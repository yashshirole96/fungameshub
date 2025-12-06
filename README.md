read (final report.docx) for a full report on webpage and outputs 


use xampp server for running the website 


use xampp phpmyadmin for database 
create db named gamehub-> create table users 

table sql query:

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  total_score INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



REPLACE

$servername = "sql302.infinityfree.com";
$username = "if0_38381261"; // XAMPP default
$password = "h5On2c3OO5"; // No password for root in XAMPP
$dbname = "if0_38381261_gamehub";
 
WITH
 
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

IF YOU WANT TO RUN ON LOCALHOST
