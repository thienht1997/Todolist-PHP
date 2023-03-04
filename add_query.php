<?php
	require_once 'conn.php';
	if(ISSET($_POST['add'])){
		if($_POST['task'] != ""){
			$task = $_POST['task'];
			
			$query = $conn->query("INSERT INTO `task` (`task`, `status`, `start_date`, `end_date`) VALUES ('$task', '', '$start_date', '$end_date')");
			header('location:index.php');
		}
	}
?>