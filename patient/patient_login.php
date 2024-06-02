<?php
// patient/patient_dashboard.php
include('../db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <h1>Patient Dashboard</h1>
    <a href="appointments.php">View Appointments</a><br>
    <h2>Doctors</h2>
    <?php
    $sql = "SELECT * FROM doctor";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "Name: " . $row['name'] . "<br>";
        echo "Specialty: " . $row['specialty'] . "<br><br>";
    }
    ?>
</body>
</html>
