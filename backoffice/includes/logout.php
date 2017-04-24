<?php session_start(); ?>
<?php
  $_SESSION['brugernavn'] = null;
  $_SESSION['fornavn'] = null;
  $_SESSION['efternavn'] = null;
  $_SESSION['bruger_status'] = null;
  $_SESSION['bruger_rolle'] = null;
  $_SESSION['logged_in'] = null;
  header("Location: ../../");
?>
