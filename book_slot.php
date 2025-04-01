<?php
include 'db.php';

$message = "";
$slot_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $_POST['vehicle_number'];
    $payment_method = $_POST['payment_method'];

    // Check if vehicle is already parked
    $check_stmt = $conn->prepare("SELECT * FROM entry_logs WHERE vehicle_number = ? AND exit_time IS NULL");
    $check_stmt->bind_param("s", $vehicle_number);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "❌ Vehicle is already in the parking.";
    } else {
        // Find an available slot
        $slot_stmt = $conn->prepare("SELECT slot_id FROM parking_slots WHERE is_booked = 0 LIMIT 1");
        $slot_stmt->execute();
        $slot_result = $slot_stmt->get_result();

        if ($slot_row = $slot_result->fetch_assoc()) {
            $slot_id = $slot_row['slot_id'];
            
            // Assign the slot
            $update_stmt = $conn->prepare("UPDATE parking_slots SET is_booked = 1 WHERE slot_id = ?");
            $update_stmt->bind_param("i", $slot_id);
            $update_stmt->execute();

            // Log the entry
            $payment_method = $_POST['payment_method']; // Get selected payment method

            $entry_stmt = $conn->prepare("INSERT INTO entry_logs (vehicle_number, slot_id, entry_time, payment_method) VALUES (?, ?, NOW(), ?)");
            $entry_stmt->bind_param("sis", $vehicle_number, $slot_id, $payment_method);
            
            $entry_stmt->execute();

            $message = "✅ Slot booked successfully! Your slot number: $slot_id";
        } else {
            $message = "❌ No available slots!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Slot - Smart Parking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: #E0E0E0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        h2 {
            color: #BB86FC;
            font-size: 24px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-size: 16px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #333;
            background: #1E1E1E;
            color: white;
            font-size: 16px;
            outline: none;
        }

        input::placeholder {
            color: #aaa;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #1E88E5;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1565C0;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
        }

        .success {
            background: #2E7D32;
            color: white;
        }

        .error {
            background: #D32F2F;
            color: white;
        }

        /* Payment Options */
        .payment-options {
            margin-top: 10px;
            text-align: left;
        }

        .payment-options label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
            cursor: pointer;
        }

        .payment-options input {
            width: auto;
        }

        .payment-options img {
            width: 24px;
            height: 24px;
            object-fit: contain;
            vertical-align: middle;
        }

        .footer-text {
            margin-top: 15px;
            font-size: 14px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🚗 Book a Parking Slot</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form action="book_slot.php" method="POST">
        <label>Vehicle Number:</label>
        <input type="text" name="vehicle_number" placeholder="Enter your vehicle number" required>

        <label>Choose Payment Method:</label>
        <div class="payment-options">
            <label>
                <input type="radio" name="payment_method" value="UPI" required>
                <img src="images/upi.png" alt="UPI"> UPI
            </label>
            <label>
                <input type="radio" name="payment_method" value="Credit Card">
                <img src="images/visa.webp" alt="Visa"> Credit/Debit Card
            </label>
            <label>
                <input type="radio" name="payment_method" value="Net Banking">
                <img src="images/net_banking.webp" alt="Net Banking"> Net Banking
            </label>
        </div>

        <button type="submit">Pay & Book Slot</button>
    </form>

    <div class="footer-text">Fake payment system for demo purposes.</div>
</div>

</body>
</html>
