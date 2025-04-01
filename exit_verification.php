<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $_POST['vehicle_number'];

    // Step 1: Check if the vehicle has an active entry
    $stmt = $conn->prepare("SELECT slot_id FROM entry_logs WHERE vehicle_number = ? AND exit_time IS NULL");
    $stmt->bind_param("s", $vehicle_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $slot_id = $row['slot_id'];

        // Close previous statement and result set
        $stmt->close();
        $result->close();

        // Step 2: Mark exit time in entry_logs
        $stmt = $conn->prepare("UPDATE entry_logs SET exit_time = NOW() WHERE vehicle_number = ? AND exit_time IS NULL");
        $stmt->bind_param("s", $vehicle_number);
        $stmt->execute();
        $stmt->close();

        // Step 3: Mark the parking slot as available
        $stmt = $conn->prepare("UPDATE parking_slots SET is_booked = 0, booked_by = NULL WHERE slot_id = ?");
        $stmt->bind_param("i", $slot_id);
        $stmt->execute();
        $stmt->close();

        $message = "✅ Exit successful! Slot $slot_id is now available.";
        $messageClass = "success";
    } else {
        $message = "❌ No active entry found for vehicle $vehicle_number.";
        $messageClass = "error";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exit Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e3a8a; /* Dark Blue */
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 40%;
            background: #f8f9fa; /* Light Background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin: auto;
        }
        h2 {
            color: #1e3a8a; /* Dark Blue */
        }
        .form-group {
            margin: 20px 0;
        }
        input[type="text"] {
            width: 90%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #1e3a8a;
            border-radius: 5px;
        }
        button {
            background-color: #facc15; /* Yellow */
            color: #1e3a8a;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        button:hover {
            background-color: #eab308; /* Darker Yellow */
        }
        .message {
            font-size: 18px;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            color: green;
            background-color: #d4edda;
        }
        .error {
            color: red;
            background-color: #f8d7da;
        }
        .icon {
            width: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="images/gate_icon.webp" alt="Exit Gate" class="icon">
    <h2>Exit Verification</h2>
    
    <?php if (isset($message)): ?>
        <div class="message <?= $messageClass; ?>">
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <form action="exit_verification.php" method="POST">
        <div class="form-group">
            <input type="text" name="vehicle_number" placeholder="Enter Vehicle Number" required>
        </div>
        <button type="submit">Exit</button>
    </form>
</div>

</body>
</html>
