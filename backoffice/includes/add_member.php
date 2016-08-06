<?php
  if(isset($_POST['optag_form'])) {
    $fornavn = escape($_POST['fornavn']);
    $efternavn = escape($_POST['efternavn']);
    $password = 'Storekor123';
    $password_validate = 'Storekor123';
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

    if(!empty($fornavn) && !empty($email) && !empty($efternavn) && !empty($password)) {
      if(($password == $password_validate)) {
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
        $query = "SELECT * FROM medlemmer WHERE brugernavn = '$brugernavn'";
        $check_conn = mysqli_query($conn, $query);
        $count = mysqli_num_rows($check_conn);
        if($count == 0) {
          $query = "INSERT INTO medlemmer(brugernavn, password, fornavn, efternavn, adresse, postnr, bynavn, email, telefon, alder, stemme, erfaring, kor_type, job, relate, persona, bruger_rolle, bruger_status, dato_oprettet, app_status) VALUES('{$brugernavn}', '{$password}','{$fornavn}','{$efternavn}','{$adresse}','{$postnr}','{$bynavn}','{$email}','{$telefon}','{$alder}','{$stemme}','{$erfaring}','{$kor_type}','{$job}','{$relate}','{$persona}','ikke godkendt','ikke godkendt','{$dato_oprettet}','oprettet af bestyrelsen')";

          $create_user_query = mysqli_query($conn, $query);

          if(!$create_user_query) {
            die("Query Failed: " . mysqli_error($conn));
          } else {
            $message = urlencode("success_add_member");
            $_SESSION["code"] = null;
            $_SESSION['logged_in'] = false;
            header("Location: index.php?message=".$message);
            mysqli_close($conn);
          }
        } else {
          $query = "INSERT INTO medlemmer(brugernavn, password, fornavn, efternavn, adresse, postnr, bynavn, email, telefon, alder, stemme, erfaring, kor_type, job, relate, persona, flag_status, bruger_rolle, bruger_status, dato_oprettet, app_status) VALUES('{$brugernavn}', '{$password}','{$fornavn}','{$efternavn}','{$adresse}','{$postnr}','{$bynavn}','{$email}','{$telefon}','{$alder}','{$stemme}','{$erfaring}','{$kor_type}','{$job}','{$relate}','{$persona}', 1,'ikke godkendt','ikke godkendt','{$dato_oprettet}', 'oprettet af bestyrelsen')";

          $create_user_query = mysqli_query($conn, $query);

          if(!$create_user_query) {
            die("Query Failed: " . mysqli_error($conn));
          } else {
            $message = urlencode("success_add_member");
            header("Location: index.php?message=".$message);
            die;
          }
        }
      } else {
        $password_fail = "Det password du har indtastet stemmer ikke overens i begge felter.<br>Indtast det samme password i begge felter.";
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
    } else {
      $login_fail = "Du mangler at udfylde nogle felter der er påkrævet.<br>Udfyld venligst alle de vigtie felter.";
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



<div class="container">
  <section>
    <div class="row">
      <?php
        if(isset($human_error)) {
          echo "<div class='col s12'>";
          echo "<p class='red-text'>";
          echo $human_error;
          echo "</p>";
          echo "</div>";
        }
        if(isset($login_fail)) {
          echo "<div class='col s12'>";
          echo "<p class='red-text'>";
          echo $login_fail;
          echo "</p>";
          echo "</div>";
        }
        if(isset($password_fail)) {
          echo "<div class='col s12'>";
          echo "<p class='red-text'>";
          echo $password_fail;
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
            <input id="alder" required="required" type="date" class="datepicker" name="alder">
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
        <button class="btn waves-effect waves-light" type="submit" name="optag_form">Tilføj nyt medlem<i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</section>

</div>
