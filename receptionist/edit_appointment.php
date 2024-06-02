<?php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $appointment = get_appointment_by_id($conn, $id);

    if (!$appointment) {
        echo "Appointment not found!";
        exit;
    }
} else {
    header("Location: receptionist_dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_appointment'])) {
    $id = $_POST['id'];
    $patient_name = $_POST['patient_name'];
    $email = $_POST['email'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    update_appointment($conn, $id, $patient_name, $email, $doctor_id, $appointment_date, $phone, $message);

    header("Location: receptionist_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Appointment</title>
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
                    <div class="col-lg-6 col-xl-4">
                        <div class="card">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-semibold mb-4">Edit Appointment</h2>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                    <div class="mb-3">
                                        <label for="patient_name" class="form-label">Patient Name</label>
                                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($appointment['email']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="doctor_id" class="form-label">Doctor</label>
                                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                                            <?php
                                            $doctors = get_doctor_details_for_edit($conn);
                                            foreach ($doctors as $doctor) {
                                                $selected = $doctor['id'] == $appointment['doctor_id'] ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($doctor['id']) . "' {$selected}>" . htmlspecialchars($doctor['name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="appointment_date" class="form-label">Appointment Date</label>
                                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($appointment['phone']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" required><?php echo htmlspecialchars($appointment['message']); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="update_appointment">Update</button>
                                    <button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
