<?php
$query = "SELECT id, fornavn, efternavn, email, telefon, stemme, erfaring FROM medlemmer WHERE app_status = 'ny' || app_status = 'oprettet af bestyrelsen'";
$get_new_apps = mysqli_query($conn, $query); ?>

<div class="container">
	<table class="centered highlight striped responsive-table">
		<div class="div center">
		<h5>Nye ansøgninger til koret er listet herunder</h5>
		</div>
		<thead>
		<tr>
			<th data-field="name">Navn</th>
			<th data-field="voice">Ønsket stemme</th>
			<th data-field="pre_voice">Tidligere stemme</th>
			<th data-field="mail">Mail</th>
			<th data-field="tlf">Telefon</th>
			<th data-field="link">Link</th>
		</tr>
		</thead>
		<tbody>

<?php
while($row = mysqli_fetch_assoc($get_new_apps)) {
	$app_id = $row['id'];
	$name = $row['fornavn'] . " " . $row['efternavn'];
	$voice = $row['stemme'];
	$pre_voice = $row['erfaring'];
	$mail = $row['email'];
	$phone = $row['telefon'];

	echo "<tr>";
	echo "<td>$name</td>";
	echo "<td>$voice</td>";
	echo "<td>$pre_voice</td>";
	echo "<td>$mail</td>";
	echo "<td>$phone</td>";
	echo "<td><a href='index.php?action=view_new_app&app_id=$app_id'><button class='btn waves-effect blue darken-2 waves-light'>Link til $name</button></a></td>";
	echo "</tr>";
}
?>



		</tbody>
	</table>
</div>