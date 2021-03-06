<?php
  if(isset($_GET['app_id'])) {
    $app_id = escape($_GET['app_id']);
  }

  if(isset($_POST['deny_app'])) {
    $query = "DELETE FROM medlemmer WHERE id = '{$app_id}'";
    $delete_app = mysqli_query($conn, $query);
    if(!$delete_app) {
      die("Query Failed123: " . mysqli_error($conn));
    } else {
      $mail_name = $_POST['mail_name'];
      $mail_email = $_POST['mail_email'];
      $message = urlencode('new_app_delete');
      header("Location: index.php?action=send_mail&app=deny&name=" . $mail_name . "&mail=" . $mail_email . "");
    }

  }

  if(isset($_POST['approve_app'])) {
    $stemme = escape($_POST['new_voice']);
    $query = "UPDATE medlemmer SET ";
    $query .= "stemme = '{$stemme}', ";
    $query .= "app_status = 'godkendt', ";
    $query .= "bruger_status = 'aktiv', ";
    $query .= "bruger_rolle = 'sanger', ";
    $query .= "auth = '4' ";
    $query .= "WHERE id = '{$app_id}'";
    $update_app = mysqli_query($conn, $query);

    $edit_by_id = $_SESSION['user_id'];
    $edit_by_name = $_SESSION['fornavn'];
    $date_now = date('Y-m-d H:i:s');

    $mail_name = $_POST['mail_name'];
    $mail_email = $_POST['mail_email'];

    $update_edit = "INSERT INTO medlemmer_edit(member_id, edit_by_id, edit_by_name, edit_date) VALUES({$app_id}, {$edit_by_id}, '{$edit_by_name}', '{$date_now}')";
    $query_edit = mysqli_query($conn, $update_edit);

    if(!$update_app) {
      die("Query Failed123: " . mysqli_error($conn));
    } else {
      $message = urlencode('new_app_godkendt');
      header("Location: index.php?action=send_mail&app=approved&name=" . $mail_name . "&mail=" . $mail_email . "");
    }
  }

  $query = "SELECT * FROM medlemmer WHERE id = {$app_id}";
  $get_new_app = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($get_new_app)) {
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
  $name = $fornavn . " " . $efternavn;
  if(empty($persona)) {
    $persona = "<i>Personen har ikke udfyldt dette felt</i>";
  }

?>

<div class="container new-app">
   <div class="row">
     <div class="col s12">
       <h5 class="grey-text text-darken-4"><?php echo $name . " || " . alderNu($alder) . " år gammel"; ?></h5>
     </div>
   </div>
   <div class="row">
     <div class="col s12 m4 flow-text">
       <p>
         Adresse:<?php echo "<br>" . $adresse . "<br>" . $postnr . " " . $bynavn; ?><br><br>
         <?php echo "Email: <a href='mailto:".$email."'>".$email."</a>"; ?>
         <br>
         <?php echo "Tlf: <a href='tel:".$telefon."'>".$telefon."</a>"; ?>
       </p>
     </div>
     <div class="col s12 m4 flow-text">
       <p>
         Ønsker at synge:<br><span class="bold"><?php echo $stemme; ?></span><br>
         <br>Plejer at synge:<br><span class="bold"><?php echo $erfaring; ?></span><br>
         <br>Tidligere kor:<br><span class="bold"><?php echo $kor_type; ?></span>
       </p>
     </div>
     <div class="col s12 m4 flow-text">
       <p>
         Har hørt om koret fra:<br><span class="bold"><?php if(isset($relate)) { echo $relate; } else { echo "<i>Personen har ikke skrevet noget</i>";} ?></span><br>
         <br>Beskæftigelse:<br><span class="bold"><?php if(isset($job)) { echo $job; } ?></span><br>
         <br>Lidt info om personen:<br><span class="bold"><?php if(isset($persona)) { echo $persona; } ?></span>
       </p>
     </div>
   </div>
   <div class="row">
     <div class="col s12 m6">
       <form method="post">
         <div class="input-field col s12">
          <select name="new_voice">
            <option value="" disabled selected>Vælg stemme og godkend ansøgningen</option>
            <option value="1. Sopran">1. Sopran</option>
            <option value="2. Sopran">2. Sopran</option>
            <option value="1. Alt">1. Alt</option>
            <option value="2. Alt">2. Alt</option>
            <option value="1. Tenor">1. Tenor</option>
            <option value="2. Tenor">2. Tenor</option>
            <option value="1. Bass">1. Bass</option>
            <option value="2. Bass">2. Bass</option>
            <option value="Ved ikke">Stemmevalg er ikke besluttet endnu</option>
          </select>

          <input type="hidden" name="mail_name" value="<?php echo $name; ?>">
          <input type="hidden" name="mail_email" value="<?php echo $email; ?>">

          <button class="btn waves-effect waves-light" type="submit" name="approve_app">Godkend ansøgning
            <i class="material-icons right">send</i>
          </button>
          <br>
          <br>
          <button class="btn waves-effect waves-light red darken-3" type="submit" name="deny_app">Afvis ansøgning
            <i class="material-icons right">send</i>
          </button>
        </div>

        <div class="col s12">
        </div>
       </form>
     </div>
   </div>
 </div>
