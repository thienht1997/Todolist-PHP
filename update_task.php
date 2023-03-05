<?php
    session_start(); 
    require_once 'conn.php';

    if (isset($_POST['update'])) {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $status = $_POST['status'];

        // Validate form inputs
        $errors = array();
        if (empty($task_name)) {
            $errors['task_name'] = 'Task name is required';
        }

        if (empty($start_date)) {
            $errors['start_date'] = 'Start date is required';
        }

        if (empty($end_date)) {
            $errors['end_date'] = 'End date is required';
        } else if ($end_date < $start_date) {
            $errors['end_date'] = 'End date must be greater than start date';
        }

        if (!empty($errors)) {
            $errors['task_id'] = $task_id;
            $_SESSION['errors'] = $errors;
            $_SESSION['task'] = $task_name;
            $_SESSION['start_date'] = $start_date;
            $_SESSION['end_date'] = $end_date;
            $_SESSION['status'] = $status;
            header("location: index.php");
            exit;
        }

        $stmt = $conn->prepare("UPDATE `task` SET `task` = ?, `start_date` = ?, `end_date` = ?, `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ssssi", $task_name, $start_date, $end_date, $status, $task_id);
        $stmt->execute();
        $_SESSION['success'] = 'Task updated successfully.';
        header("location: index.php");
    }
?>
