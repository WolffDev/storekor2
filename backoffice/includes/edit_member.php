<?php
  if (session_status() === PHP_SESSION_NONE){session_start();}
  if(!isset($_SESSION['bruger_status']) || $_SESSION['bruger_status'] == 'ikke godkendt') {
    header("Location: ../index.php");
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

      if($profil_billede == '') {
        $profil_billede = 'images/placeholder-user.png';
      }

?>

<div class="card large">
  <div class="card-image waves-effect waves-block waves-light">
    <img class="activator" src="<?php echo $profil_billede ?>">
  </div>
  <div class="card-content">
    <span class="card-title activator grey-text text-darken-4"><?php echo $fornavn . " " . $efternavn; ?> <a href="#">Rediger medlem</a><i class="material-icons right">more_vert</i></span>
    <p>
      <?php echo $adresse . "<br>" . $postnr . " " . $bynavn . "<br>" . $telefon; ?>
    </p>
    <p>
      Tryk på billedet for at se mere information omkring personen.
    </p>
  </div>
  <div class="card-reveal">
    <span class="card-title grey-text text-darken-4"><?php echo $fornavn . " " . $efternavn; ?><i class="material-icons right">close</i></span>
    <p>Here is some more information about this product that is only revealed once clicked on.</p>
  </div>
</div>
