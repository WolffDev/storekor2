<?php
  $reset_date_start = strtotime("2016-02-02");
	$reset_date_end = strtotime("2016-02-17");
  $reset_date_start_format = date("d-F", $reset_date_start);
	$reset_date_end_format = date("d-F", $reset_date_end);
  $current_date = date("d-F");

	if(($current_date > $reset_date_start_format && $current_date < $reset_date_end_format)) {
		$update_old_events_query =
		"UPDATE
			events
		SET
			old_event = 1
		WHERE
			start_date < NOW()
		AND
			old_event = 0";
		$update_old_events = mysqli_query($conn, $update_old_events_query);

		$delete_absence_query = "DELETE FROM absence";
		$delete_absence = mysqli_query($conn, $delete_absence_query);
	}

?>
<div class="container content-container">
  <table class="centered highlight striped responsive-table">
    <div class="div center">
      <h5>Oversigt over fravær i koret.<br>Listen bliver nulstillet når sæsonen slutter.</h5>
    </div>
    <thead>
      <tr>
        <th data-field="name">Navn</th>
        <th data-field="name">Fraværd</th>
      </tr>
    </thead>
    <tbody>
    <?php
			$events_query =
			"SELECT
				COUNT(*)
			AS
				events_count
			FROM
				events
			WHERE
				old_event = 0";

			$events_result = mysqli_query($conn, $events_query);

			while($row = mysqli_fetch_assoc($events_result)) {
				$total_events = $row['events_count'];
			}

			$query = "SELECT COUNT(*)
			AS absence_member_percent,
				absence_member_id,
				m.fornavn,
				m.efternavn
			FROM
				absence
			LEFT JOIN medlemmer AS m
			ON
				m.id = absence_member_id
			WHERE
				absence_status = 1
			GROUP BY
				absence_member_id";

			$select = mysqli_query($conn, $query);
			$query_test = mysqli_num_rows($select);
			if($query_test > 1) {
				while($row = mysqli_fetch_assoc($select)) {
					$member_id = $row['absence_member_id'];
					$fornavn = $row['fornavn'];
					$efternavn = $row['efternavn'];
					$name = $fornavn . " " . $efternavn;
					$absence_member_percent = $row['absence_member_percent'];

					$total_events;
					$absence_member_percent;

					$absence_member_percent_total = round(($absence_member_percent / $total_events) * 100, 1);

					echo "<tr>";
					echo "<td><a href='medlemmer.php?action=view&id=" . $member_id . "'>" . $name . "</a></td>";
					echo "<td>" . $absence_member_percent_total . " %</td>";
					echo "</tr>";
				}
			} else {
				echo "<h5 class='center teal darken-3 white-text'>Der er ikke blevet registreret noget fraværd endnu</h5>";
			}
    ?>
    </tbody>
  </table>
</div>
