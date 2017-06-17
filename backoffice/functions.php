<?php
	function escape($string) {
		global $conn;
		return mysqli_real_escape_string($conn, trim($string));
	}

	function dd($var) {
		var_dump($var);
		die;
	}

	function salt() {
		return base64_encode(bin2hex(random_bytes(32)));
	}

	function mail_utf8($to, $from_user, $from_email, $subject, $message) {
		$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
		$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
		$headers = "From: $from_user <$from_email>" . "\r\n";
		$headers .= "Reply-To: ".($from_mail) . "\r\n";
		$headers .= "Return-Path: ".($from_mail) . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";

		return mail($to, $subject, $message, $headers);
	}

	function resetAbsence() {
		global $conn;
		$reset_date_start = strtotime("2016-08-01");
		$reset_date_end = strtotime("2016-08-08");
		$reset_date_start_format = date("d-F", $reset_date_start);
		$reset_date_end_format = date("d-F", $reset_date_end);

		$reset_date_start2 = strtotime("2016-01-01");
		$reset_date_end2 = strtotime("2016-01-08");
		$reset_date_start_format2 = date("d-F", $reset_date_start2);
		$reset_date_end_format2 = date("d-F", $reset_date_end2);


		$current_date = date("d-F");

		if(($current_date > $reset_date_start_format && $current_date < $reset_date_end_format) || ($current_date > $reset_date_start_format2 && $current_date < $reset_date_end_format2)) {
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

			$delete_absence_query = "TRUNCATE TABLE absence";
			$delete_absence = mysqli_query($conn, $delete_absence_query);
		}
	}

	function brugerAfbud($user_id, $event_id) {
		global $conn;

		$afbudSQL = "
		SELECT
			m_id,
			e_id,
			a_id
		FROM
			afbud
		WHERE
			m_id = {$user_id}
		AND
			e_id = {$event_id}
		";

		$afbudR = mysqli_query($conn, $afbudSQL);
		while($afbudA = mysqli_fetch_assoc($afbudR)) {
			$a_id = $afbudA['a_id'];
		}
		$afbud_count = mysqli_num_rows($afbudR);
		if($afbud_count > 0) {
			return array('true', $a_id);
		}
		return false;
	}


	function replaceChars123($string) {
		return str_replace(array("Ã¦","Ã¸","Ã¥","Ã†","Ã˜","Ã…"),array("æ","ø","å","Æ","Ø","Å"),$string);
	}

	function getDatetimeNow() {
		$tz_object = new DateTimeZone('Europe/Copenhagen');
		//date_default_timezone_set('Brazil/East');

		$datetime = new DateTime();
		$datetime->setTimezone($tz_object);
		return $datetime->format('Y\-m\-d\ h:i:s');
	}

	function alderNu($alder) {
		$tid = strtotime($alder);
		return $alder_nu = floor(((time()- $tid)  /(3600 * 24 * 365)));
	}

	function checkAuth($auth) {
		if (session_status() === PHP_SESSION_NONE){session_start();}
		if(!isset($_SESSION['bruger_status']) || $_SESSION['bruger_status'] == 'ikke godkendt' || $_SESSION['auth'] > $auth && $_SESSION['logged_in'] != 'true') {
			$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
			header("Location:".$root);
		}
	}

function protocol_detail($var1, $var2) {
	global $conn;
	if(isset($_GET['action']) && $_GET['action'] == 'protocol_detail') {
		$e_id = escape($_GET['e_id']);
	}
	?>
	<div id="<?php echo $var1; ?>" class="section scrollspy">
		<div class="row protocol-entry">
			<h5 class="center"><?php echo $var2;?></h5>
			<hr>
			<?php
			$query = "SELECT
				m.id,
				m.fornavn,
				m.efternavn,
				m.stemme,
				a.absence_id,
				a.absence_member_id,
				a.absence_event_id,
				a.absence_status
			FROM
				medlemmer AS m
			LEFT JOIN
				absence AS a
			ON
				a.absence_member_id = m.id
			WHERE
				a.absence_event_id = $e_id
			AND
				m.stemme = '{$var2}'
			AND
				bruger_status = 'aktiv'";

			$result = mysqli_query($conn, $query);
			while($arrayR = mysqli_fetch_assoc($result)) {
				$id = $arrayR['id'];
				$fornavn = $arrayR['fornavn'];
				$efternavn = $arrayR['efternavn'];
				$navn = $fornavn . " " . $efternavn;
				$absence_id = $arrayR['absence_id'];
				$absence_status = $arrayR['absence_status'];

				echo "<div class='col s6 m4 l3'>";
				if($absence_status == 0) {
					echo "<input type='checkbox' data-absence_id='" . $absence_id . "'  id='" . $id . "' checked/>";
				} else {
					echo "<input type='checkbox' data-absence_id='" . $absence_id . "'  id='" . $id . "'/>";
				}
				echo "<label for='" . $id . "' style='margin-top:15px;'>";
				echo "<div class='checkbox-info flow-text'>";
				echo $navn;
				echo "</div>";
				echo "</label>";
				echo "</div>";
			}
			?>
		</div>
	</div>

<?php }

?>
