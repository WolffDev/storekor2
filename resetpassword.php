<?php include "includes/header.php"; ?>

<?php
// send link to member
if(isset($_POST['reset_password']) && !empty($_POST['reset_password_email'])) {

	$reset_password_email = escape($_POST['reset_password_email']);
	$reset_password_email = (string)$reset_password_email;

	$email_query = "SELECT email FROM medlemmer WHERE email = '$reset_password_email'";
	$check_email = mysqli_query($conn, $email_query);

	// check if email exists in database
	if(mysqli_num_rows($check_email)) {
		// check if the user has already asked for a reset, within the last 10 minutes
		$reset_check_query = "SELECT member_email, reset_date FROM reset_password WHERE member_email = '$reset_password_email' AND reset_date > NOW() - INTERVAL 10 MINUTE";
		$reset_password_exist = mysqli_query($conn, $reset_check_query);
		
		if(mysqli_num_rows($reset_password_exist)) {
			header("Location: ./?message=resetrecent");
			mysqli_close($conn);
		} else {

			// inserts a record in reset_password, with the email, token and date created
			$now = date("Y-m-d H:i:s");
			$salt = salt();

			$reset_password_query = "INSERT INTO reset_password(member_email, reset_token, reset_date, active)
			VALUES('{$reset_password_email}', '{$salt}', '{$now}', 1)";

			$create_reset = mysqli_query($conn, $reset_password_query);

			if($create_reset) {

				// send the actual mail to the email specified in the input field, with a link to reset the password
				$msg = "Kære medlem,<br>";
				$msg .= "Du eller en anden har bedt om at nulstille din adgangskode til www.storekor.dk.<br><br>";
				$msg .= "Hvis du ikke har bedt om at få nulstillet din adgangskode, så skal du se bort fra denne mail og ikke trykke på nedestående link.<br><br>";
				$msg .= "<hr>";
				$msg .= "Tryk på dette link få at nulstille din password og lave en ny.<br><br>";
				$msg .= "Dette link virker kun en gang, så sørg for at du har 2 minutter til at lave en ny adgangskode.<br><br>";
				$msg .= "<a href='http://www.davidwolff.dk/projekter/storekor/resetpassword?reset_password=true&email=" . $reset_password_email . "&token=" . $salt . "'>
					http://www.storekor.dk/resetpassword?reset_password=true&email=" . $reset_password_email . "&token=" . $salt . "
				</a>";

				$subject = "Storekor.dk - nulstil adgangskode";

				mail_utf8('davidbkwolff@gmail.com', 'Korbestyrelsen', 'info@davidwolff.dk', $subject, $msg);


				$resetmail = urlencode($reset_password_email);
				header("Location: ./?message=resetpassword&resetmail=".$resetmail);
				mysqli_close($conn);
			} else {
				die("Query Failed: " . mysqli_error($conn));
			}
		}

	} else {
		// mail doesn't exist in the database = not a registered member
		$resetmail = urlencode($reset_password_email);
		header("Location: ./?message=resetpassword&resetmail=".$resetmail);
		mysqli_close($conn);
	}

}


// handle set new password, after token and email is verified
if(isset($_POST['reset_password_link'])) {
	$password = escape($_POST['password']);
	$password_validate = escape($_POST['password_validate']);

	$password = (string)$password;
	$password_validate = (string)$password_validate;

	if( $password !== $password_validate || empty($_POST['password']) || empty($_POST['password_validate'])) {
		// if passwords are not equal or empty
		?>
		<div id="modal1" class="modal">
			<div class="modal-content black-text">
				<h4>Fejl ved indtasning</h4>
				<p>
					Du har ikke indtastet den samme adgangskode i begge felter, prøv venligst igen.
				</p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
			</div>
		</div>
		<script type="text/javascript">
			$('#modal1').openModal();
		</script>

		<?php
	} else if($password === $password_validate){
		// passwords should be the same and correct now
		
		$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
		$email = $_SESSION['resetEmail'];
		
		$member_query = "UPDATE medlemmer SET password = '$password' WHERE email = '$email'";
		$update_query_db = mysqli_query($conn, $member_query);

		if($update_query_db) {
			// reset sessions
			$_SESSION['brugernavn'] = null;
			$_SESSION['fornavn'] = null;
			$_SESSION['efternavn'] = null;
			$_SESSION['bruger_status'] = null;
			$_SESSION['bruger_rolle'] = null;
			$_SESSION['logged_in'] = null;
			$_SESSION['resetEmail'] = null;
			$_SESSION['resetPassword'] = null;

			// redirect to index with message saying succesfull new password
			header("Location: ./?message=resetpasswordtrue");
			mysqli_close($conn);

		} else {
			die("Query Failed: " . mysqli_error($conn));
		}


	}
}



?>

<!-- ****** Navbar *****-->
<?php include "includes/navbar.php"; ?>
<!-- ****** INTRO ******-->
<div id="index-banner" class="parallax-container">
	<div class="section no-pad-bot">
		<div class="container">
			<br/><br/>
			<h1 class="header center white-text text-lighten-2">Storekor Odense</h1>
		</div>
	</div>
	<div class="parallax">
		<img src="img/koncert6.jpg" alt="Unsplashed background img 1"/>
	</div>
</div>
<div class="container">

	
	<?php
	// handle reset password link, when the member has gotten the email and is directed here from within the email.
	if($_GET['reset_password'] == 'true' && !empty($_GET['token']) && !empty($_GET['email']) || $_SESSION['resetPassword'] == true) {

		$token = escape($_GET['token']);
		$email = escape($_GET['email']);
		$token = (string)$token;
		$email = (string)$email;

		$email_token_query = "SELECT
				member_email
			FROM
				reset_password
			WHERE
				reset_token = '$token'
			AND
				member_email = '$email'
			AND
				reset_date > NOW() - INTERVAL 30 MINUTE
			AND
				active = 1";

		$email_token_db = mysqli_query($conn, $email_token_query);

		if(mysqli_num_rows($email_token_db) || $_SESSION['resetPassword'] == true) { 
			// The token and email is a match, and it's still active
			// or the session has been set true
			// set sessions to reset password = true, so if the user doesnt enter the password correct each time, the user will still be able to get to this site
			$_SESSION['resetPassword'] = true;
			$_SESSION['resetEmail'] = $email;

			// Set active to 0
			$active_query = "UPDATE reset_password SET active = 0 WHERE member_email = '$email'";
			$active_query_db = mysqli_query($conn, $active_query);
			
			?>

			<div class="row" id="new-password">
				<div class="col s12 m6 offset-m3">

					<p class="flow-text">
						Du har nu mulighed for at lave en ny adgangskode til din konto.
						<br>
						Du har 30 minutter, fra du modtog mailen, til at oprette en ny adgangskode.
						<br><br>
						Det link du modtog i mailen er ikke længere aktiv.
					</p>

					<form method="post" action="">
						
						<div class="row">
							<div class="input-field col s12">
								<input id="password" type="password" class="validate password" required minlength="8" name="password">
								<label for="password">Indtast ny adgangskode</label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<input id="password_validate" type="password" class="validate" required minlength="8" name="password_validate">
								<label for="password_validate">Gentag adgangskode</label>
							</div>
						</div>

						<ul class="helper-text">
							<li class="length">Mindst 8 bogstaver.</li>
							<li class="lowercase">Skal indeholde et lille bogstav.</li>
							<li class="uppercase">Skal indeholde et stort bogstav.</li>
							<li class="special">Skal indeholde et tal eller et tegn (!, #, ?, %).</li>
						</ul>

						<div class="row center">
							<button class="btn waves-effect waves-light" type="submit" name="reset_password_link">Opret ny adgangskode
								<i class="material-icons right">send</i>
							</button>
						</div>

					</form>
				</div>
			</div>


			<?php


		} else {
			// Either the link is not active anymore, or the token and email did not match. Ask the user to make another request new password
			header("Location: ./?message=resetpasswordold");
			mysqli_close($conn);
		}

	} else { ?>


		<div class="row" id="reset-password-page">
			<h2>Glemt adgangskode?</h2>
			<div class="col s12 m6">
				<p class="flow-text">
					Indtast din email i feltet for at få tilsendt et link, hvor du kan nulstille din adgangskode.
					<br>
					<br>
					Linket vil kun være aktivt i 30 minutter, gældende fra når du trykker på "send link".
				</p>
			</div>
			<div class="col s12 m6">
				<form method="post" action="">
					<div class="input-field">
						<i class="material-icons prefix">mail_outline</i>
						<input id="reset-password-email" type="email" class="validate" name="reset_password_email">
						<label for="reset-password-email">Indtast din email</label>
					</div>
					<div class="center">
						<br>
						<button class="btn waves-effect waves-light" type="submit" name="reset_password">Send link
							<i class="material-icons right">send</i>
						</button>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>


</div>

<script type="text/javascript" src="js/form_validate.js"></script>
<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>