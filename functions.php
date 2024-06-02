<?php
// functions.php
session_start();

function is_logged_in() {
    return isset($_SESSION['user']);
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header('Location: ../index.php');
        exit();
    }
}

function login($identifier, $password, $table, $conn) {
    // Determine the correct column to use for the identifier
    $identifier_column = ($table == 'doctor') ? 'email' : 'username';
    
    // Prepare the SQL statement with the correct column
    $sql = "SELECT * FROM $table WHERE $identifier_column = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ss", $identifier, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['user'] = $result->fetch_assoc();
        return true;
    }
    return false;
}


function login_doctor($email, $password, $userType, $conn) {
    $sql = "SELECT * FROM $userType WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            session_start();
            $_SESSION['user'] = $user;
            return true;
        } else {
            // Password is incorrect
            return false;
        }
    } else {
        // No user found with this email
        return false;
    }
}


function logout() {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
}

function get_appointment_by_id($conn, $id) {
    $sql = "SELECT a.id, a.patient_name, a.email, a.doctor_id, a.appointment_date, a.phone, a.message, d.name AS doctor_name
            FROM appointments a
            JOIN doctor d ON a.doctor_id = d.id
            WHERE a.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();
    $stmt->close();
    return $appointment;
}

function update_appointment($conn, $id, $patient_name, $email, $doctor_id, $appointment_date, $phone, $message) {
    $sql = "UPDATE appointments 
            SET patient_name = ?, email = ?, doctor_id = ?, appointment_date = ?, phone = ?, message = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $patient_name, $email, $doctor_id, $appointment_date, $phone, $message, $id);
    $stmt->execute();
    $stmt->close();
}

// Function to retrieve doctor details
function get_doctor_details_for_edit($conn)
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
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
    return $doctors;
}

function get_doctor_by_id($conn, $id) {
    $sql = "SELECT * FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();
    $stmt->close();
    return $doctor;
}
?>

