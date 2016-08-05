<?php
  function escape($string) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($string));
  }

  function replaceChars123($string) {
    return str_replace(array("Ã¦","Ã¸","Ã¥","Ã†","Ã˜","Ã…"),array("æ","ø","å","Æ","Ø","Å"),$string);
  }

  function userLoggedIn() {
    isset($_SESSION['brugernavn']) && $_SESSION['bruger_status'] != 'ikke_godkendt';
  }
?>
