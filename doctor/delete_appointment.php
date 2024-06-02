<?php
// delete_appointment.php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect to the doctor dashboard after deletion
        header("Location: doctor_dashboard.php");
        exit;
    } else {
        // Handle errors
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Redirect if no ID is provided
    header("Location: doctor_dashboard.php");
    exit;
}
?>
