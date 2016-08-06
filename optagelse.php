<?php include "./includes/header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/navbar.php"; ?>
<!-- ****** INTRO ******-->

<?php
  if(isset($_POST['optag_form'])) {
    if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"]) {
      $fornavn = escape($_POST['fornavn']);
      $efternavn = escape($_POST['efternavn']);
      $password = escape($_POST['password']);
      $password_validate = escape($_POST['password_validate']);
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
            $query = "INSERT INTO medlemmer(brugernavn, password, fornavn, efternavn, adresse, postnr, bynavn, email, telefon, alder, stemme, erfaring, kor_type, job, relate, persona, bruger_rolle, bruger_status, dato_oprettet, app_status) VALUES('{$brugernavn}', '{$password}','{$fornavn}','{$efternavn}','{$adresse}','{$postnr}','{$bynavn}','{$email}','{$telefon}','{$alder}','{$stemme}','{$erfaring}','{$kor_type}','{$job}','{$relate}','{$persona}','ikke godkendt','ikke godkendt','{$dato_oprettet}','ny')";

            $create_user_query = mysqli_query($conn, $query);

            if(!$create_user_query) {
              die("Query Failed: " . mysqli_error($conn));
            } else {
              $message = urlencode("success");
              $_SESSION["code"] = null;
              $_SESSION['logged_in'] = false;
              header("Location: index.php?message=".$message);
              mysqli_close($conn);
            }
          } else {
            $query = "INSERT INTO medlemmer(brugernavn, password, fornavn, efternavn, adresse, postnr, bynavn, email, telefon, alder, stemme, erfaring, kor_type, job, relate, persona, flag_status, bruger_rolle, bruger_status, dato_oprettet, app_status) VALUES('{$brugernavn}', '{$password}','{$fornavn}','{$efternavn}','{$adresse}','{$postnr}','{$bynavn}','{$email}','{$telefon}','{$alder}','{$stemme}','{$erfaring}','{$kor_type}','{$job}','{$relate}','{$persona}', 1,'ikke godkendt','ikke godkendt','{$dato_oprettet}', 'ny')";

            $create_user_query = mysqli_query($conn, $query);

            if(!$create_user_query) {
              die("Query Failed: " . mysqli_error($conn));
            } else {
              $message = urlencode("success");
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
    } else {
      $human_error = "Du har tastet forkerte cifrer under verificering - prøv igen.<br>Hvis fejlen fortsætter, gå ind på kontakt siden og udfyld kontakt formularen, hvor du beskriver fejlen.";
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


<div id="index-banner" class="parallax-container">
  <div class="section no-pad-bot">
    <div class="container">
      <h1 class="header center white-text text-lighten-2">Storekor || Optagelse</h1>
      <div class="row center">
        <h5 class="header col s12">Optagelse og optagelseskrav</h5>
      </div>
      <br/><br/>
    </div>
  </div>
  <div class="parallax"><img src="img/people3.jpg" alt="Unsplashed background img 1"/></div>
</div>
<div class="container">
  <section>
    <div class="row">
      <div class="col s12"><h4>Optagelse</h4></div>
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
      <div class="col s12">
        <p>
          For at søge om optagelse i Storekoret, skal du gennemlæse optagelseskravene.<br>Længere nede på siden er der en formular du kan udfylde og sende til os.<br>Vi vil svare dig inde for maks 7 dage, hvis vi er i korsæsonen. I mailen vil der fremkomme yderligere informationer.<br>Udenfor korsæsonen kan svartiden være op til 4 uger.
        </p>
      </div>
    </div>
  </section>
  <section>
    <div class="row">
      <!-- <div class="col m1"></div> -->
      <div class="col s12"><h4>Optagelseskrav</h4></div>
      <div class="col s12">

        <ul class="collapsible" data-collapsible="accordion">
          <li>
            <div class="collapsible-header active"><i class="material-icons">done</i>Kan du synge?</div>
            <div class="collapsible-body">
              <p>For at blive optaget i koret kræves det, at du kan synge rent, kan orientere dig i noderne, har et godt gehør og har korerfaring.</p>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Før stemmeprøven</div>
            <div class="collapsible-body">
              <p>Før selve stemmeprøven kan du synge med til et par mandagsprøver for at finde ud af, om det er noget for dig. ¿¿De første fire mandagsprøver i hvert semester er åbne for alle interesserede, og i forlængelse af den fjerde korprøve afholdes stemmeprøver.??</p>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Stemmeprøven</div>
            <div class="collapsible-body">
              <p>Stemmeprøven tager 5-10 minutter.<br>Dirigenten vil bede dig om at synge nogle sangøvelser for at få en ide om din stemmes spændvidde - noget gehørsang (du skal gentage de toner, der bliver spillet på klaveret) og et vers eller to af en sang du kender.<br>Du vil efter et par dage få skriftlig besked om, hvorvidt du er blevet optaget.<br>Ved stemmeprøven vil der, udover dirigenten, være to af bestyrelsesmedlemmerne tilstede.</p>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">done</i>Kontigent</div>
            <div class="collapsible-body">
              <p>Kontingent for en sæson (september til maj) er 500 kroner.<br>Er der problemer med at betale de 500 kroner på en gang, kan der i særlige tilfælde indgås individuelle aftaler om at betale à to gange. Snak med kassereren om det.</p>
            </div>
          </li>
        </ul>
      </div>
      <!-- <div class="col m1"></div> -->
    </div>
  </section>

  <section>
    <div class="row">
      <div class="col s12"><h4>Dine oplysninger</h4></div>
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
          <div class="input-field col s12 m6">
            <input id="password" required type="password" class="validate password" name="password" minlength="8">
            <ul class="helper-text">
                <li class="length">Mindst 8 bogstaver.</li>
                <li class="lowercase">Skal indeholde et lille bogstav.</li>
                <li class="uppercase">Skal indeholde et stort bogstav.</li>
                <li class="special">Skal indeholde et tal eller et tegn (!, #, ?, %).</li>
            </ul>
            <label for="password">Kodeord</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="password_validate" required="required" type="password" class="validate" name="password_validate" minlength="8">
            <label for="password_validate">Gentag kodeord</label>
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
            <label for="alder">Din fødselsdato</label>
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
              <option value="Ved ikke">Jeg ved ikke hvad jeg synger</option>
            </select>
            <label for="stemme">Vælg din stemme</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="erfaring" required="required" type="text" class="validate" name="erfaring" value="<?php if(isset($erfaring)){echo $erfaring;} ?>">
            <label for="erfaring">Hvilken stemme/r har du sunget før?</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="kor_type" required="required" type="text" class="validate" name="kor_type" value="<?php if(isset($kor_type)){echo $kor_type;} ?>">
            <label for="kor_type">Hviklet type kor har du sunget i før?</label>
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
            <label for="relate">Hvor har du hørt på Storekoret?</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="persona" class="materialize-textarea" name="persona"><?php if(isset($persona)){echo $persona;} ?></textarea>
            <label for="persona">Skriv en kort introduktion af dig selv</label>
          </div>
        </div>
        <div class="input-field col s12 m6">
          <img src="includes/recaptcha.php" alt="reCaptcha image - human verification" />
        </div>
        <div class="input-field col s12 m6">
            <input type="text" name="captcha" class="validate" required="" id="captcha">
            <label for="captcha">Indtast nummeret.</label>
        </div>
        <div class="row"></div>
      </div>
      <div class="row center">
        <button class="btn waves-effect waves-light" type="submit" name="optag_form">Send ansøgning<i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</section>

</div>
<script type="text/javascript" src="js/form_validate.js"></script>
<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>
