<?php
session_start();
require 'connect.php'; // Your database connection file

// Validate seller session
// if (!isset($_SESSION['userType']) !== 'seller') {
//     header("Location: login.php");
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $seller_id = $_SESSION['Id'];
    $ewaste_type = htmlspecialchars($_POST['ewasteType']);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_FLOAT, [
        'options' => ['min_range' => 0.1]
    ]);
    $unit = in_array($_POST['unit'], ['pieces', 'kg']) ? $_POST['unit'] : 'pieces';
    $contact = preg_replace('/[^0-9]/', '', $_POST['contact']);
    $address = htmlspecialchars($_POST['address']);
    $notes = !empty($_POST['notes']) ? htmlspecialchars($_POST['notes']) : null;

    // Validate required fields
    // if (!$quantity || strlen($contact) < 10 || empty($address)) {
    //     $_SESSION['error'] = "Invalid form data. Please check your inputs.";
    //     header("Location: seller.php");
    //     exit();
    // }

    // Insert into database using prepared statement
    try {
        $stmt = $conn->prepare("INSERT INTO ewaste_submissions 
            (seller_id, ewaste_type, quantity, unit, contact, address, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("isdssss", 
            $seller_id,
            $ewaste_type,
            $quantity,
            $unit,
            $contact,
            $address,
            $notes
        );

        if ($stmt->execute()) {
            $_SESSION['success'] = "Submission successful! Your reference ID: " . $stmt->insert_id;
            header("Location: s_progress.php");
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Submission failed: " . $e->getMessage();
        header("Location: seller.php");
    } finally {
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
} else {
    header("Location: seller.php");
}
?>