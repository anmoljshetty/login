<?php
session_start();
require 'connect.php';

// Authentication check
// if (!isset($_SESSION['userType']) !== 'seller') {
//     header("Location: login.php");
//     exit();
// }

// Fetch seller's submissions
$submissions = [];
try {
    $stmt = $conn->prepare("SELECT * FROM ewaste_submissions 
                          WHERE seller_id = ? 
                          ORDER BY submission_date DESC");
    $stmt->bind_param("i", $_SESSION['Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $submissions = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $error = "Failed to load submissions: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Submissions</title>
    <link rel="stylesheet" href="sell.css">
</head>
<body>
    <div class="seller-container">
        <h1>My E-Waste Submissions</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $sub): ?>
                <tr>
                    <td><?= htmlspecialchars($sub['id']) ?></td>
                    <td><?= htmlspecialchars($sub['ewaste_type']) ?></td>
                    <td><?= htmlspecialchars($sub['quantity']) ?> <?= htmlspecialchars($sub['unit']) ?></td>
                    <td class="status-<?= htmlspecialchars($sub['status']) ?>">
                        <?= ucfirst(htmlspecialchars($sub['status'])) ?>
                        <?php if ($sub['status'] === 'claimed'): ?>
                            <br><small>by Refurbisher #<?= $sub['claimed_by'] ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= date('M d, Y', strtotime($sub['submission_date'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="actions">
            <a href="seller.php" class="btn">New Submission</a>
            <a href="logout.php" class="btn logout">Logout</a>
        </div>
    </div>
</body>
</html>