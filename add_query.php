<?php
	session_start();

	require_once 'conn.php';

	if (isset($_POST['add'])) {
		$task = $_POST['task'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$errors = array();

		if (empty($task)) {
			$errors['task'] = "Task name is required.";
		}

		if (empty($start_date)) {
			$errors['start_date'] = "Start date is required.";
		}

        if (empty($end_date)) {
            $errors['end_date'] = 'End date is required';
        } else if ($end_date < $start_date) {
            $errors['end_date'] = 'End date must be greater than start date';
        }

		if (count($errors) == 0) {
			$query = $conn->query("INSERT INTO `task` (`task`, `status`, `start_date`, `end_date`) VALUES ('$task', 'Planning', '$start_date', '$end_date')");
			header('location:index.php');
			$_SESSION['success'] = 'Task added successfully.';
			exit();
		} else {
			$_SESSION['errors'] = $errors;
			$_SESSION['task'] = $task;
			$_SESSION['start_date'] = $start_date;
			$_SESSION['end_date'] = $end_date;
			
			header('location:index.php');
			exit();
		}
	}
?>
