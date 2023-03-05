<?php
session_start();
if (isset($_POST['unset']) && $_POST['unset'] == true) {
    unset($_SESSION['task']);
    unset($_SESSION['start_date']);
    unset($_SESSION['end_date']);
    unset($_SESSION['status']);
    echo "Session variables unset.";
}
?>
