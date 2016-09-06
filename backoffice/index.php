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

  <?php
    if(isset($_GET['action'])) {
      $action = $_GET['action'];
    } else {
      header("Location: index.php?action=dashboard");
    }

    switch($action) {
      case 'dashboard':
        include "includes/dashboard.php";
        break;
      case 'afbud':
        include "includes/afbud.php";
        break;
      case 'afbud_detail':
        include "includes/afbud_detail.php";
        break;
      case 'ovegange':
        include "includes/ovegange.php";
        break;
      case 'event':
        include "includes/event.php";
        break;
      case 'old_ovegange':
        include "includes/old_ovegange.php";
        break;
      case 'view_new_app':
        include "includes/view_new_app.php";
        break;
      default:
        include "includes/dashboard.php";
    }
  ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
