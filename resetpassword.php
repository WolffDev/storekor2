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
		}

		// inserts a record in reset_password, with the email, token and date created
		$now = date("Y-m-d H:i:s");
		$salt = salt();

		$reset_password_query = "INSERT INTO reset_password(member_email, reset_token, reset_date)
		VALUES('{$reset_password_email}', '{$salt}', '{$now}')";

		$create_reset = mysqli_query($conn, $reset_password_query);

		if($create_reset) {

			// send the actual mail to the email specified in the input field, with a link to reset the password
			// $msg = "Kære medlem,<br>";
			// $msg .= "Du eller en anden har bedt om at nulstille din adgangskode til storekor.dk<br><br>";
			// $msg .= "Hvis du ikke har bedt om at få nulstillet din adgangskode, så skal du se bort fra denne mail og ikke trykke på nedestående link<br><br>";
			// $msg .= "<hr>";
			// $msg .= "Tryk på dette link få at nulstille din password og lave en ny.<br>";
			// $msg .= "Dette link virker kun en gang, så sørg for at du har 2 minutter til at lave en ny adgangskode.<br>";
			// $msg .= "<a href='http://www.storekor.dk/resetpassword?resetpassword=true&email=" . $reset_password_email . "&token=" . $salt . "'>
			// 	http://www.storekor.dk/resetpassword?resetpassword=true&email=" . $reset_password_email . "&token=" . $salt . "
			// </a>";

			// $subject = "Storekor.dk - nulstil adgangskode";

			// mail_utf8('davidbkwolff@gmail.com', 'Korbestyrelsen', 'info@davidwolff.dk', $subject, $msg);


			$resetmail = urlencode($reset_password_email);
			header("Location: ./?message=resetpassword&resetmail=".$resetmail);
			mysqli_close($conn);
		} else {
			die("Query Failed: " . mysqli_error($conn));
		}


	} else {
		// mail doesn't exist in the database = not a registered member
		$resetmail = urlencode($reset_password_email);
		header("Location: ./?message=resetpassword&resetmail=".$resetmail);
		mysqli_close($conn);
	}

}


// handle link from email




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
	// handle reset password link, when the member has gotten the email and is directed here from withon the email.
	if($_GET['reset_password'] == 'true' && !empty($_GET['token']) && !empty($_GET['email'])) {

		$token = escape($_GET['token']);
		$email = escape($_GET['email']);
		$token = (string)$token;
		$email = (string)$email;


		?>



		<h1>SAF</h1>

		<?php
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
				<form method="post">
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

<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>