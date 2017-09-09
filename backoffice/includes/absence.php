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
				absence_member_id
			ORDER BY
				m.fornavn ASC";

			$select = mysqli_query($conn, $query);
			$query_test = mysqli_num_rows($select);
			if($query_test >= 1) {
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
