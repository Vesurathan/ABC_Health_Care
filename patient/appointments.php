<?php
// patient/appointments.php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = $_POST['patient_name'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $message = $_POST['message'];

    $sql = "INSERT INTO appointments (patient_name, doctor_id, appointment_date, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $patient_name, $doctor_id, $appointment_date, $message);

    if ($stmt->execute()) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Appointment</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-8 col-xl-6">
            <div class="card mb-4">
              <div class="card-body p-4">
                <h1 class="card-title fw-semibold mb-4">Book Appointment</h1>
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="patient_name" class="form-label">Patient Name</label>
                    <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                  </div>
                  <div class="mb-3">
                    <label for="doctor_id" class="form-label">Doctor</label>
                    <select class="form-control" id="doctor_id" name="doctor_id" required>
                      <?php
                      $sql = "SELECT * FROM doctor";
                      $result = $conn->query($sql);
                      while ($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row['id'] . "'>" . $row['name'] . " (" . $row['specialization'] . ")</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="appointment_date" class="form-label">Appointment Date</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                  </div>
                  <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-3">Book Appointment</button>
                  <button type="button" class="btn btn-primary mt-3 mb-4" onclick="history.back();">Back</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../libs/jquery/dist/jquery.min.js"></script>
  <script src="../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
