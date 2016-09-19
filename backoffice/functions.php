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

function protocol_detail($var1, $var2) {
  global $conn;
  if(isset($_GET['action']) && $_GET['action'] == 'protocol_detail') {
    $e_id = escape($_GET['e_id']);
  }
  ?>
  <div id="<?php echo $var1; ?>" class="section scrollspy">
    <div class="row protocol-entry">
      <h5 class="center"><?php echo $var2;?></h5>
      <hr>
      <?php
      $query = "SELECT
        m.id,
        m.fornavn,
        m.efternavn,
        m.stemme,
        a.absence_id,
        a.absence_member_id,
        a.absence_event_id,
        a.absence_status
      FROM
        medlemmer AS m
      LEFT JOIN
        absence AS a
      ON
        a.absence_member_id = m.id
      WHERE
        a.absence_event_id = $e_id
      AND
        m.stemme = '{$var2}'
      AND
        bruger_status = 'aktiv'";

      $result = mysqli_query($conn, $query);
      while($arrayR = mysqli_fetch_assoc($result)) {
        $id = $arrayR['id'];
        $fornavn = $arrayR['fornavn'];
        $efternavn = $arrayR['efternavn'];
        $navn = $fornavn . " " . $efternavn;
        $absence_id = $arrayR['absence_id'];
        $absence_status = $arrayR['absence_status'];

        echo "<div class='col s6 m4 l3'>";
        if($absence_status == 0) {
          echo "<input type='checkbox' data-absence_id='" . $absence_id . "'  id='" . $id . "' checked/>";
        } else {
          echo "<input type='checkbox' data-absence_id='" . $absence_id . "'  id='" . $id . "'/>";
        }
        echo "<label for='" . $id . "' style='margin-top:15px;'>";
        echo "<div class='checkbox-info flow-text'>";
        echo $navn;
        echo "</div>";
        echo "</label>";
        echo "</div>";
      }
      ?>
    </div>
  </div>

<?php }

?>
