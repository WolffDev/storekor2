<?php
  function escape($string) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($string));
  }

  function brugerAfbud($user_id, $event_id) {
    global $conn;

    $afbudSQL = "
    SELECT
      m_id,
      e_id,
      a_id
    FROM
      afbud
    WHERE
      m_id = {$user_id}
    AND
      e_id = {$event_id}
    ";

    $afbudR = mysqli_query($conn, $afbudSQL);
    while($afbudA = mysqli_fetch_assoc($afbudR)) {
      $a_id = $afbudA['a_id'];
    }
    $afbud_count = mysqli_num_rows($afbudR);
    if($afbud_count > 0) {
      return array('true', $a_id);
    }
    return false;
  }


  function replaceChars123($string) {
    return str_replace(array("Ã¦","Ã¸","Ã¥","Ã†","Ã˜","Ã…"),array("æ","ø","å","Æ","Ø","Å"),$string);
  }

  function getDatetimeNow() {
    $tz_object = new DateTimeZone('Europe/Copenhagen');
    //date_default_timezone_set('Brazil/East');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
  }

  function alderNu($alder) {
    $tid = strtotime($alder);
    return $alder_nu = floor(((time()- $tid)  /(3600 * 24 * 365)));
  }

  function checkAuth($auth) {
    if (session_status() === PHP_SESSION_NONE){session_start();}
    if(!isset($_SESSION['bruger_status']) || $_SESSION['bruger_status'] == 'ikke godkendt' || $_SESSION['auth'] > $auth && $_SESSION['logged_in'] != 'true') {
      $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
      header("Location:".$root);
    }
  }

?>
