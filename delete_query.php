<?php
	session_start(); 
	
    require_once 'conn.php';

    if(isset($_GET['task_id'])){
        $task_id = $_GET['task_id'];

        if ($conn->query("DELETE FROM `task` WHERE `id` = $task_id")) {
			$_SESSION['success'] = 'Task remove successfully.';
            header("location: index.php");
        } else {
            echo "Error deleting task: " . mysqli_error($conn);
        }
    }   
?>
