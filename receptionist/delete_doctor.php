<?php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: receptionist_dashboard.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: receptionist_dashboard.php");
    exit;
}
?>
