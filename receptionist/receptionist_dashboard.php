<?php
// receptionist_dashboard.php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

$sql_appointments = "SELECT * FROM appointments";
$result_appointments = $conn->query($sql_appointments);

$sql_doctors = "SELECT * FROM doctor";
$result_doctors = $conn->query($sql_doctors);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Receptionist Dashboard</title>
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
                    <div class="col-lg-10 col-xl-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h1 class="card-title fw-semibold">Receptionist Dashboard</h1>
                                    <a href="receptionist_logout.php" class="btn btn-danger">Logout</a>
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
                                        <?php while($row = $result_appointments->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                                            <td>
                                                <a href="edit_appointment.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="delete_appointment.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <h2 class="mt-5 mb-4">Doctors</h2>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $result_doctors->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                            <td>
                                                <a href="edit_doctor.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="delete_doctor.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
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
