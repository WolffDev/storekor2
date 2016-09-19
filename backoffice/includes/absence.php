id, navn, mail, telefon
<?php
$total_events_count = "SELECT
	COUNT(event_id) AS total_events_count
FROM
	events";
$total_result = mysqli_query($conn, $total_events_count);
while($total_countA = mysqli_fetch_assoc($total_result)) {
  $total_events_count = $total_countA['total_events_count'];
}


?>
