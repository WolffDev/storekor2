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
      case 'add_member':
        include "includes/add_member.php";
        break;
      default:
        include "includes/view_all_members.php";
    }
  ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
