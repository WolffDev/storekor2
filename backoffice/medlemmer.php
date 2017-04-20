<?php include "./includes/admin_header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/admin_navbar.php"; ?>
<!-- ****** MAIN ******-->
<main class="admin-main">
  <?php
    if(isset($_GET['action'])) {
      $action = $_GET['action'];
    } else {
      header("Location: medlemmer.php?action=view_all");
    }

    switch($action) {
      case 'view_all':
        include "includes/view_all_members.php";
        break;
      case 'add_member':
        include "includes/add_member.php";
        break;
      case 'view':
        include "includes/view_member.php";
        break;
      case 'edit':
        include "includes/edit_member.php";
        break;
      case 'profile':
        include "includes/profile.php";
        break;
      case 'view_all_single':
        include "includes/view_all_members_single.php";
        break;
      default:
        include "includes/view_all_members.php";
    }
  ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
