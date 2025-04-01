<?php
include 'db.php';

// Fetch parking slot statuses
$sql = "SELECT slot_id, is_booked FROM parking_slots";
$result = $conn->query($sql);

$slots = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">
    <title>Live Parking Status</title>
    <style>
        .slot {
            display: inline-block;
            width: 100px;
            height: 100px;
            margin: 10px;
            text-align: center;
            line-height: 100px;
            font-weight: bold;
            border-radius: 10px;
        }
        .occupied {
            background-color: red;
            color: white;
        }
        .available {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Live Parking Slot Status</h2>
    <div>
        <?php foreach ($slots as $slot): ?>
            <div class="slot <?= $slot['is_booked'] ? 'occupied' : 'available' ?>">
                Slot <?= $slot['slot_id'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>