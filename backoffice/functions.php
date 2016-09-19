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
      $alt1_query = "SELECT
        m.id,
        m.fornavn,
        m.efternavn,
        m.stemme,
        a.m_id,
        a.e_id,
        d.d_id,
        d.d_e_id
      FROM
        medlemmer AS m
      LEFT JOIN
        afbud AS a
      ON
        m.id = a.m_id
      LEFT JOIN
      	deltagere AS d
      ON
      	d.d_m_id = m.id
      WHERE
        (
          a.e_id != $e_id
        OR
          a.e_id IS NULL
        )
      AND
        m.stemme = '{$var2}'
      AND
        bruger_status = 'aktiv'
      GROUP BY m.id";

      $alt1_result = mysqli_query($conn, $alt1_query);
      while($alt1_array = mysqli_fetch_assoc($alt1_result)) {
        $id = $alt1_array['id'];
        $fornavn = $alt1_array['fornavn'];
        $efternavn = $alt1_array['efternavn'];
        $navn = $fornavn . " " . $efternavn;
        $deltager_aktiv = $alt1_array['d_e_id'];
        $deltager_id = $alt1_array['d_id'];

        echo "<div class='col s6 m4 l3'>";
        if($deltager_aktiv == $e_id) {
          echo "<input type='checkbox' data-deltager_id='" . $deltager_id . "' data-event_id='" . $e_id . "' data-member_id='" . $id . "' id='" . $id . "' value='" . $id . "' checked/>";
        } else {
          echo "<input type='checkbox' data-deltager_id='" . $deltager_id . "' data-event_id='" . $e_id . "' data-member_id='" . $id . "' id='" . $id . "' name='checkboxDeltagerArray[]' value='" . $id . "'/>";
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
