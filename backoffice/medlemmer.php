<?php include "./includes/admin_header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/admin_navbar.php"; ?>
<!-- ****** MAIN ******-->
<main class="admin-main">
  <?php
    if(isset($_GET['action'])) {
      $action = $_GET['action'];
    } else {
      $action = '';
    }

    switch($action) {
      case 'view_all':
        include "includes/view_all_members.php";
        break;
      case 'edit_user':
        include "includes/edit_user.php";
        break;
      default:
        include "includes/view_all_members.php";
    }
  ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
