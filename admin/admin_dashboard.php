<?php
// admin/admin_dashboard.php
include '../functions.php';
redirect_if_not_logged_in();

// Include database connection or any necessary files
include '../db.php';

// Function to delete patient details
function delete_patient($patient_id, $conn)
{
    $sql = "DELETE FROM patients WHERE id = $patient_id";
    mysqli_query($conn, $sql);
}

// Function to retrieve doctor details
function get_doctor_details($conn)
{
    $doctors = array();
    $sql = "SELECT * FROM doctor";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    return $doctors;
}

// Function to delete doctor details
function delete_doctor($doctor_id, $conn)
{
    $sql = "DELETE FROM doctor WHERE id = $doctor_id";
    mysqli_query($conn, $sql);
}

// Function to retrieve patient details
function get_patient_details($conn)
{
    $patients = array();
    $sql = "SELECT * FROM patients";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    return $patients;
}

// Function to retrieve appointment details
function get_appointment_details($conn)
{
    $appointments = array();
    $sql = "SELECT appointments.*, doctor.name as doctor_name 
            FROM appointments
            JOIN doctor ON appointments.doctor_id = doctor.id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    return $appointments;
}

// Check if any action is requested (e.g., delete)
if (isset($_GET['action']) && isset($_GET['type']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $type = $_GET['type'];
    $id = $_GET['id'];

    if ($action == 'delete') {
        if ($type == 'patient') {
            delete_patient($id, $conn);
        } elseif ($type == 'doctor') {
            delete_doctor($id, $conn);
        } elseif ($type == 'appointment') {
            delete_appointment($id, $conn);
        }
    }
}

redirect_if_not_logged_in();

$patients = get_patient_details($conn);

redirect_if_not_logged_in();

$doctors = get_doctor_details($conn);

redirect_if_not_logged_in();

$appointments = get_appointment_details($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../css/styles.min.css" />
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-10 col-xl-8">
            <div class="card mb-5">
              <div class="card-body p-4">
                <h1 class="card-title fw-semibold mb-4"><strong>Admin Dashboard</strong></h1>
                <a href="admin_logout.php" class="btn btn-danger mb-4">Logout</a>

                <div class="mb-4">
                  <h2>Patient Details</h2>
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">ID</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Name</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Email</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Date of Birth</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Gender</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Contact Number</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Address</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Emergency Contact Name</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Emergency Contact Number</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Date of Registration</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Actions</h6></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($patients as $patient): ?>
                        <tr>
                          <td class="border-bottom-0"><?php echo $patient['id']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['name']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['email']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['date_of_birth']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['gender']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['contact_number']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['address']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['emergency_contact_name']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['emergency_contact_number']; ?></td>
                          <td class="border-bottom-0"><?php echo $patient['date_of_registration']; ?></td>
                          <td class="border-bottom-0">
                            <a href="?action=delete&type=patient&id=<?php echo $patient['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
<br>
<hr>
<br>
                <div class="mb-4">
                  <h2>Doctor Details</h2>
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">ID</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Name</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Email</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Specialization</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Actions</h6></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($doctors as $doctor): ?>
                        <tr>
                          <td class="border-bottom-0"><?php echo $doctor['id']; ?></td>
                          <td class="border-bottom-0"><?php echo $doctor['name']; ?></td>
                          <td class="border-bottom-0"><?php echo $doctor['email']; ?></td>
                          <td class="border-bottom-0"><?php echo $doctor['specialization']; ?></td>
                          <td class="border-bottom-0">
                            <a href="?action=delete&type=doctor&id=<?php echo $doctor['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
<hr>
<br>
                <div class="mb-4">
                  <h2>Appointment Details</h2>
                  <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">ID</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Patient Name</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Email</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Doctor</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Appointment Date</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Phone</h6></th>
                          <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Actions</h6></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                        <tr>
                          <td class="border-bottom-0"><?php echo $appointment['id']; ?></td>
                          <td class="border-bottom-0"><?php echo $appointment['patient_name']; ?></td>
                          <td class="border-bottom-0"><?php echo $appointment['email']; ?></td>
                          <td class="border-bottom-0"><?php echo $appointment['doctor_name']; ?></td>
                          <td class="border-bottom-0"><?php echo $appointment['appointment_date']; ?></td>
                          <td class="border-bottom-0"><?php echo $appointment['phone']; ?></td>
                          <td class="border-bottom-0">
                            <a href="edit_appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?action=delete&type=appointment&id=<?php echo $appointment['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../libs/jquery/dist/jquery.min.js"></script>
  <script src="../libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
