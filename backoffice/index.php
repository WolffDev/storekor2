<?php include "./includes/admin_header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/admin_navbar.php"; ?>
<!-- ****** MAIN ******-->
<main class="admin-main">
  <?php
    if(isset($_GET['message'])) {
      if ($_GET['message'] === 'success_add_member_test') { ?>
        <div id="modal1" class="modal">
          <div class="modal-content black-text">
            <h4>Optagelse afsendt</h4>
            <p>Vi har nu modtaget din ansøgning.<br>Du vil modtage et svar fra Korbestryrelsen inden for 7 dage.<br>Er det uden for sæsson, skal du påregne op til 4 uger svar tid.</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
          </div>
        </div>
        <script type="text/javascript">
          $('#modal1').openModal();
        </script>
        <?php }} ?>

</main>
<!-- ****** FOOTER ******-->
<?php include "./includes/admin_footer.php"; ?>
