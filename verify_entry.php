<?php
include 'db.php';

$message = "";
$status_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $_POST['vehicle_number'];

    // Check if there's an active entry for this vehicle (not yet exited)
    $checkEntry = $conn->prepare("SELECT * FROM entry_logs WHERE vehicle_number = ? AND exit_time IS NULL");
    $checkEntry->bind_param("s", $vehicle_number);
    $checkEntry->execute();
    $result = $checkEntry->get_result();

    if ($result->num_rows > 0) {
        $message = "✅ Entry verified! Gate opening...";
        $status_class = "success";
    } else {
        $message = "❌ No valid booking found!";
        $status_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #4A90E2, #50C9C3);
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .gate-icon {
            width: 80px;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/gate_icon.webp" alt="Gate Icon" class="gate-icon">
        <h2>Verify Vehicle Entry</h2>
        <form action="verify_entry.php" method="POST">
            <input type="text" name="vehicle_number" placeholder="Enter Vehicle Number" required>
            <button type="submit">Verify</button>
        </form>
        <?php if ($message): ?>
            <div class="message <?= $status_class; ?>"><?= $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
