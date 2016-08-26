<?php
  if(isset($_GET['app_id'])) {
    $app_id = escape($_GET['app_id']);
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

?>

<div class="container new_app">
   <div class="row">
     <div class="col s12">
       <h5 class="grey-text text-darken-4"><?php echo $name . " || " . alderNu($alder) . " år gammel"; ?></h5>
     </div>
   </div>
   <div class="row">
     <div class="col s12 m4">
     Adresse: <?php echo "<br>" . $adresse . "<br>" . $postnr . " " . $bynavn; ?>
     <br><br>
     <?php echo "<a href='mailto:".$email."'>".$email."</a>"; ?>
     <br>
     <?php echo "<a href='tel:".$telefon."'>".$telefon."</a>"; ?>
     </div>
     <div class="col s12 m4">
       Ønsker at synge: <span class="bold"><?php echo $stemme; ?>.</span><br>
       Har tidligere sunget: <span class="bold"><?php echo $erfaring; ?>.</span><br>
       Har tidligere kor erfaring: <span class="bold"><?php echo $kor_type; ?></span>.
     </div>
   </div>
   <div class="row">
     <div class="col s12 m6">
       <form action="index.html" method="post">
         <div class="input-field col s12">
          <select>
            <option value="" disabled selected>Vælg stemme</option>
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
          <label>Vælg stemme og godkend ansøgningen</label>
          <button class="btn waves-effect waves-light" type="submit" name="action">Godkend ansøgning
            <i class="material-icons right">send</i>
          </button>
        </div>
       </form>
     </div>
   </div>
 </div>
