<?php
// doctor_dashboard.php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

$sql = "SELECT * FROM appointments WHERE doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user']['id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../css/styles.min.css">
    <script src="../libs/jquery/dist/jquery.min.js"></script>
    <script src="../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-8 col-xl-6">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h1 class="card-title fw-semibold">Doctor Dashboard</h1>
                                    <a href="doctor_logout.php" class="btn btn-danger">Logout</a>
                                </div>
                                <h2 class="mb-4">Appointments</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            <th>Message</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                                            <td>
                                                <a href="delete_appointment.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
