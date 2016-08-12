<?php include "./includes/admin_header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/admin_navbar.php"; ?>
<!-- ****** MAIN ******-->
<main class="admin-main">
  <?php
    if(isset($_GET['message'])) {
      if ($_GET['message'] === 'success_edit_profile_password') {
        $edit_name = escape($_GET['edit_name']); ?>
        <div class="container">
          <div class="row teal">
            <div class="col s12 center white-text bold">
              <p>
                <?php echo ucfirst($edit_name); ?>, din profil og adgangskode er nu blevet ændret.
              </p>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($_GET['message'] === 'success_edit_profile') {
        $edit_name = escape($_GET['edit_name']); ?>
        <div class="container">
          <div class="row teal">
            <div class="col s12 center white-text bold">
              <p>
                <?php echo ucfirst($edit_name); ?>, din profil er nu blevet ændret.
              </p>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
