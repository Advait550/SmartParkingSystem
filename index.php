<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3"> <!-- Auto-refresh every 3 seconds -->
    <title>Smart Parking</title>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            background: #121212;
            color: #E0E0E0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #BB86FC;
        }

        h2 {
            color: #BDBDBD;
        }

        /* Slots Grid */
        .slots-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            justify-items: center;
            padding: 20px;
        }

        .slot {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            color: #FFFFFF;
            transition: all 0.3s ease-in-out;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Available Slot */
        .available {
            background: #1E88E5;
        }
        .available:hover {
            background: #1565C0;
            box-shadow: 0 6px 12px rgba(30, 136, 229, 0.5);
        }

        /* Booked Slot */
        .booked {
            background: #616161;
            cursor: not-allowed;
        }
        .booked:hover {
            background: #424242;
        }

        /* Status Icons */
        .slot span {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
        }

        /* Legend Section */
        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }

        .blue {
            background: #1E88E5;
        }

        .gray {
            background: #616161;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚗 Smart Parking System 🚙</h1>
        <h2>Available Parking Slots</h2>
        <div class="slots-container">
            <?php
            $sql = "SELECT * FROM parking_slots";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $statusClass = $row['is_booked'] ? 'booked' : 'available';
                $disabled = $row['is_booked'] ? 'onclick="return false;"' : '';
                $icon = $row['is_booked'] ? '🚫' : '✅';
                echo "<a href='book_slot.php?slot_id=" . $row['slot_id'] . "' class='slot $statusClass' $disabled>
                        Slot " . $row['slot_id'] . " <span>$icon</span>
                      </a>";
            }
            ?>
        </div>
        
        <div class="legend">
            <div class="legend-item"><div class="legend-box blue"></div> Available</div>
            <div class="legend-item"><div class="legend-box gray"></div> Booked</div>
        </div>
    </div>
</body>
</html>
