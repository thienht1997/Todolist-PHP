<?php
	$conn = new mysqli("localhost", "root", "root", "todolist");
	
	if(!$conn){
		die("Error: Cannot connect to the database");
	}
?>