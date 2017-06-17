<?php include "includes/header.php"; ?>

<?php

if(isset($_POST['reset_password'])) {
	$reset_password_email = escape($_POST['reset_password_email']);
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