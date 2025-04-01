<?php
include('db.php');

$sql = "SELECT slot_id, is_booked, booked_by FROM parking_slots";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo '<tr class="' . ($row['is_booked'] ? 'booked' : 'available') . '">';
    echo '<td>' . $row['slot_id'] . '</td>';
    echo '<td>' . ($row['is_booked'] ? 'Booked' : 'Available') . '</td>';
    echo '<td>' . ($row['booked_by'] ? $row['booked_by'] : 'N/A') . '</td>';
    echo '</tr>';
}
?>