<?php
  if (!isset($_SESSION['logged_in']) || empty($_SESSION['logged_in']) && $_SESSION['auth'] > 2){
    header("Location: ../../index.php");
    exit();
  }
?>
<?php
  if(isset($_GET['id'])) {
    $user_id = escape($_GET['id']);
  } else {
    header("Location: ../medlemmer.php?action=view_all");
  }

  $query = "SELECT * FROM medlemmer WHERE id = $user_id ";
  $select_users_query = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_users_query)) {

        $brugernavn     = $row['brugernavn'];
        $fornavn        = $row['fornavn'];
        $efternavn      = $row['efternavn'];
        $adresse        = $row['adresse'];
        $postnr         = $row['postnr'];
        $bynavn         = $row['bynavn'];
        $email          = $row['email'];
        $telefon        = $row['telefon'];
        $alder          = $row['alder'];
        $stemme         = $row['stemme'];
        $erfaring       = $row['erfaring'];
        $kor_type       = $row['kor_type'];
        $job            = $row['job'];
        $relate         = $row['relate'];
        $persona        = $row['persona'];
        $bruger_rolle   = $row['bruger_rolle'];
        $bruger_status  = $row['bruger_status'];
        $dato_oprettet  = $row['dato_oprettet'];
        $app_status     = $row['app_status'];
        $profil_billede = $row['profil_billede'];

    }

    // if($profil_billede == '') {
    //   $profil_billede = 'images/placeholder-user.png';
    // }

    $edit_query = "SELECT * FROM medlemmer_edit WHERE member_id = {$user_id} ORDER BY edit_date DESC LIMIT 1";
    $get_last_edit = mysqli_query($conn, $edit_query);
    if(!$get_last_edit) {
      die("Query Failed123: " . mysqli_error($conn));
    }
    while($row = mysqli_fetch_assoc($get_last_edit)) {
      $edit_by_id = $row['edit_by_id'];
      $edit_by_name = $row['edit_by_name'];
      $edit_date = $row['edit_date'];
    }

?>

<div class="card large">
  <div class="card-image waves-effect waves-block waves-light">
    <img class="activator" src="<?php echo $profil_billede ?>">
  </div>
  <div class="card-content">
    <?php if(!empty($edit_by_id)) { $edit_date = date_create($edit_date); ?>
      <div class="">Sidst redigeret af: <?php echo $edit_by_name; ?> den <?php echo date_format($edit_date, 'j\. M \k\l\. H:i - Y'); ?><br></div>
    <?php } ?>
    <div class="card-title activator grey-text text-darken-4">
      <?php echo $fornavn . " " . $efternavn . " || " . alderNu($alder) . " år || " . $bruger_status . " || " . $bruger_rolle; ?>
      <a href="medlemmer.php?action=edit&id=<?php echo $user_id; ?>">Rediger medlem</a>
    </div>
    <div class="flow-text">
      <p>
        <?php echo $adresse . "<br>" . $postnr . " " . $bynavn . "<br>" . "Tlf: " . $telefon; ?>
      </p>
      <p>
        Tryk på navn eller billedet for at se mere information omkring personen.
      </p>
    </div>
  </div>
  <div class="card-reveal">
    <div class="row">
      <div class="col s12 m4 center">
        <img src="<?php echo $profil_billede; ?>" alt="" style="max-width:250px;"/>
      </div>
      <div class="grey-text text-darken-4 col s12 m8">
        <span class="card-title"><?php echo $fornavn . " " . $efternavn . " - " . alderNu($alder) . " år"; ?>
          <i class="material-icons right">close</i>
          <span>
        <ul class="collapsible" data-collapsible="accordion">
          <li>
            <div class="collapsible-header">Adresse</div>
            <div class="collapsible-body grey lighten-4">
              <p>
                <?php echo $adresse . "<br>" . $postnr . " " . $bynavn ?>
                <br>
                <?php echo $email; ?>
              </p>
            </div>
          </li>
          <li>
            <div class="collapsible-header">Stemme og erfaring</div>
            <div class="collapsible-body grey lighten-4">
              <p>Synger <?php echo $stemme; ?>.<br>Har tidligere sunget <?php echo $erfaring; ?>.<br>Har tidligere erfaring med: <?php echo $kor_type ?>.</p></div>
          </li>
          <li>
            <div class="collapsible-header">Personlig info</div>
            <div class="collapsible-body grey lighten-4">
              <p>
                Rolle: <?php echo $bruger_rolle; ?>.
                <br>
                Status: <?php echo $bruger_status; ?>.
                <br>
                Beskæftligelse: <?php echo $job; ?>.
                <br>
                Kender Storekoret fra: <?php echo $relate; ?>.
                <br>
                Profil:
                <br>
                <?php echo $persona; ?>
              </p>
            </div>
          </li>
        </ul>
      </div>

  </div>
</div>
