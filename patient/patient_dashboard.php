<?php
// patient/patient_dashboard.php
include('../db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Patient Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="../images/logos/favicon.png" />
  <link rel="stylesheet" href="../css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-8 col-xl-6">
            <div class="card mb-4">
              
              <div class="card-body p-4">
                <h1 class="card-title fw-semibold mb-4">Patient Dashboard</h1>
                <div class="butts">
                  <div>
                  <a href="appointments.php" class="btn btn-primary mb-4">Make Appointments</a>
                  </div>
                  <div>
                  <button type="button" class="btn btn-primary mr-0 mb-4" onclick="history.back();">Back</button>

                  </div>
                </div>
                

                <h2 class="fw-semibold mb-4">Doctors</h2>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Name</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Specialization</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM doctor";
                      $result = $conn->query($sql);
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border-bottom-0'><h6 class='fw-semibold mb-0'>" . $row['name'] . "</h6></td>";
                        echo "<td class='border-bottom-0'><span class='fw-normal'>" . $row['specialization'] . "</span></td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
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
