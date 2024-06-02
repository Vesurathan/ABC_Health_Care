<?php
include('../functions.php');
include('../db.php');
redirect_if_not_logged_in();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $doctor = get_doctor_by_id($conn, $id);

    if (!$doctor) {
        echo "Doctor not found!";
        exit;
    }
} else {
    header("Location: receptionist_dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_doctor'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; // Add phone
    $specialization = $_POST['specialization'];

    $sql = "UPDATE doctor SET name = ?, email = ?, phone = ?, specialization = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $specialization, $id);
    $stmt->execute();

    header("Location: receptionist_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Doctor</title>
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
                                <h2 class="card-title fw-semibold mb-4">Edit Doctor</h2>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($doctor['id']); ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="specialization" class="form-label">Specialization</label>
                                        <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($doctor['specialization']); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="update_doctor">Update</button>
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
