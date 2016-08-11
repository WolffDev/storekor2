<?php
if (!isset($_SESSION['logged_in']) || empty($_SESSION['logged_in']) || $_SESSION['auth'] > 4 || $_SESSION['user_id'] != $_GET['id']){
  header("Location: index.php");
  exit();
}
?>
<?php
  if(isset($_POST['edit_profile'])) {
    $user_id = escape($_GET['id']);
    $fornavn = escape($_POST['fornavn']);
    $efternavn = escape($_POST['efternavn']);
    $adresse = escape($_POST['adresse']);
    $postnr = escape($_POST['postnr']);
    $bynavn = escape($_POST['bynavn']);
    $email = escape($_POST['email']);
    $telefon = escape($_POST['telefon']);
    // $brugernavn = substr($fornavn,0,2) . substr($efternavn,0,2) . substr($telefon,4,2);
    $brugernavn = $email;
    $alder = escape($_POST['alder']);
    $stemme = escape($_POST['stemme']);
    $erfaring = escape($_POST['erfaring']);
    $kor_type = escape($_POST['kor_type']);
    $job = escape($_POST['job']);
    $relate = escape($_POST['relate']);
    $persona = escape($_POST['persona']);
    $dato_oprettet = date('Y-m-d H:i:s');

    $tid = strtotime($alder);
    // $alder = date('d-m/Y',$tid);
    // omregner alderen fra database til et tal.
    $alder_nu = floor(((time()- $tid)  /(3600 * 24 * 365)));

    if(!empty($fornavn) && !empty($email) && !empty($efternavn)) {
      $query = "UPDATE medlemmer SET ";
      $query .="brugernavn = '{$brugernavn}', ";
      $query .="fornavn = '{$fornavn}', ";
      $query .="efternavn = '{$efternavn}', ";
      $query .="adresse = '{$adresse}', ";
      $query .="postnr = '{$postnr}', ";
      $query .="email = '{$email}', ";
      $query .="telefon = '{$telefon}', ";
      $query .="alder = '{$alder}', ";
      $query .="stemme = '{$stemme}', ";
      $query .="erfaring = '{$erfaring}', ";
      $query .="kor_type = '{$kor_type}', ";
      $query .="job = '{$job}', ";
      $query .="relate = '{$relate}', ";
      $query .="persona = '{$persona}', ";
      $query .="dato_oprettet = '{$dato_oprettet}' ";
      $query .="WHERE id = {$user_id} ";

      $create_user_query = mysqli_query($conn, $query);
      if(!$create_user_query) {
        die("Query Failed123: " . mysqli_error($conn));
      } else {
        ///////
        $message = urlencode("success_edit_profile");
        $edit_name = urlencode($fornavn . " " . $efternavn);
        header("Location: index.php?message=" . $message . "&edit_name=" . $edit_name);
        die;
      }
    } else {
      $update_fail = "Du mangler at udfylde nogle felter der er påkrævet.<br>Udfyld venligst alle de vigtige felter.";
      $fornavn = escape($_POST['fornavn']);
      $efternavn = escape($_POST['efternavn']);
      $adresse = escape($_POST['adresse']);
      $postnr = escape($_POST['postnr']);
      $bynavn = escape($_POST['bynavn']);
      $email = escape($_POST['email']);
      $telefon = escape($_POST['telefon']);
      $alder = escape($_POST['alder']);
      $stemme = escape($_POST['stemme']);
      $erfaring = escape($_POST['erfaring']);
      $kor_type = escape($_POST['kor_type']);
      $job = escape($_POST['job']);
      $relate = escape($_POST['relate']);
      $persona = escape($_POST['persona']);
      mysqli_close($conn);
    }
  }
?>

<?php
  if(isset($_GET['id'])) {
    $user_id = escape($_GET['id']);
  } else {
    header("Location: ../index.php");
  }

  $query = "SELECT * FROM medlemmer WHERE id = $user_id";
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

<div class="container">
  <section>
    <div class="row">
      <?php
        if(isset($update_fail)) {
          echo "<div class='col s12'>";
          echo "<p class='red-text'>";
          echo $update_fail;
          echo "</p>";
          echo "</div>";
        }
      ?>

    </div>
  </section>

  <section>
    <div class="row">
      <div class="col s12"><p>Indtast oplysningerne på det nye medlem.<br><span class="red-text">Husk at godkende</span> det nye medlem du opretter, under "Alle medlemmer".</p><p>Alle nye medlemmer der bliver oprettet vil automatisk få tildelt adganskoden <span class="red-text">Storekor123</span>.</p><p>Efter godkendelse skal det nye medlem have en <span class="red-text">påmindelse om at ændre deres password!</span></p></div>
      <form class="col s12" action="" method="post" autocomplete="on" id="registration">
        <div class="row">
          <div class="input-field col s12 m6">
            <input id="fornavn" required="required" type="text" class="validate" name="fornavn" value="<?php if(isset($fornavn)) {echo $fornavn;} ?>">
            <label for="fornavn">Fornavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="efternavn" required="required" type="text" class="validate" name="efternavn" value="<?php if(isset($efternavn)){echo $efternavn;} ?>">
            <label for="efternavn">Efternavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="email" type="email" class="validate" name="email" value="<?php if(isset($email)){echo $email;} ?>">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="telefon" required="required" type="tel" class="validate" name="telefon" value="<?php if(isset($telefon)){echo $telefon;} ?>">
            <label for="telefon">Telefon nummer</label>
          </div>
          <div class="input-field col s12">
            <input id="adresse" required="required" type="text" class="validate" name="adresse" value="<?php if(isset($adresse)){echo $adresse;} ?>">
            <label for="adresse">Adresse</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="postnr" required="required" type="text" class="validate" name="postnr" value="<?php if(isset($postnr)){echo $postnr;} ?>">
            <label for="postnr">Postnummer</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="bynavn" required="required" type="text" class="validate" name="bynavn" value="<?php if(isset($bynavn)){echo $bynavn;} ?>">
            <label for="bynavn">By</label>
          </div>
        </div>
        <br>
        <div class="divider"></div>
        <br>
        <div class="row">
          <div class="input-field col s12 m6">
            <input id="alder" required="required" type="date" class="datepicker" name="alder" data-value="<?php if(isset($alder)) {echo $alder;} ?>">
            <label for="alder">Fødselsdato</label>
          </div>
          <div class="input-field col s12 m6">
            <select name="stemme" value="<?php if(isset($stemme)){echo $stemme;} ?>">
              <option value="1. Sopran">1. Sopran</option>
              <option value="2. Sopran">2. Sopran</option>
              <option value="1. Alt">1. Alt</option>
              <option value="2. Alt">2. Alt</option>
              <option value="1. Tenor">1. Tenor</option>
              <option value="2. Tenor">2. Tenor</option>
              <option value="1. Bass">1. Bass</option>
              <option value="2. Bass">2. Bass</option>
              <option value="Ved ikke">Jeg ved ikke hvad han/hun synger</option>
            </select>
            <label for="stemme">Vælg stemme</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="erfaring" required="required" type="text" class="validate" name="erfaring" value="<?php if(isset($erfaring)){echo $erfaring;} ?>">
            <label for="erfaring">Hvilken stemme/r har han/hun sunget før?</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="kor_type" required="required" type="text" class="validate" name="kor_type" value="<?php if(isset($kor_type)){echo $kor_type;} ?>">
            <label for="kor_type">Hviklet type kor har han/hun sunget i før?</label>
          </div>
          <div class="input-field col s12 m6">
            <select name="job" value="<?php if(isset($job)){echo $job;} ?>">
              <option value="Studerende">Studerende</option>
              <option value="Selvstændig">Selvstændig</option>
              <option value="I arbejde">I arbejde</option>
              <option value="Ledig">Ledig</option>
              <option value="Studerende ved SDU">Studerende ved SDU</option>
              <option value="Arbejder ved SDU">Arbejder ved SDU</option>
              <option value="Pensionist">Pensionist</option>
              <option value="Ønsker ikke at oplyse">Ønsker ikke at oplyse</option>
            </select>
            <label>Beskæftigelse?</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="relate" type="text" class="validate" name="relate" value="<?php if(isset($relate)){echo $relate;} ?>">
            <label for="relate">Hvor har han/hun hørt på Storekoret?</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="persona" class="materialize-textarea" name="persona"><?php if(isset($persona)){echo $persona;} ?></textarea>
            <label for="persona">Skriv en kort introduktion af ham/hende</label>
          </div>
        </div>
        <div class="row"></div>
      </div>
      <div class="row center">
        <button class="btn waves-effect waves-light" type="submit" name="edit_profile">Opdater medlem<i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</section>

</div>
