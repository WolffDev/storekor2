<?php ob_start(); ?>
<!-- ****** Header *****-->
<?php include "./includes/header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "./includes/navbar.php"; ?>
<!-- ****** INTRO ******-->

<?php
  if(isset($_POST['optag_form'])) {
    $fornavn = escape($_POST['fornavn']);
    $efternavn = escape($_POST['efternavn']);
    $adresse = escape($_POST['adresse']);
    $bosted = escape($_POST['bosted']);
    $email = escape($_POST['email']);
    $telefon = escape($_POST['telefon']);
    $brugernavn = substr($fornavn,0,2) . substr($efternavn,0,2) . substr($telefon,4,2);
    $alder = escape($_POST['alder']);
    $stemme = escape($_POST['stemme']);
    $erfaring = escape($_POST['erfaring']);
    $kor_type = escape($_POST['kor_type']);
    $job = escape($_POST['job']);
    $relate = escape($_POST['relate']);
    $persona = escape($_POST['persona']);
    $tid = strtotime($alder);
    $alder = date('d-m/Y',$tid);
    // omregner alderen fra database til et tal.
    $alder_nu = floor(((time()- $tid)  /(3600 * 24 * 365)));

    $query = "INSERT INTO medlemmer(brugernavn, fornavn, efternavn, adresse, bosted, email, telefon, alder, stemme, erfaring, kor_type, job, relate, persona) VALUES('{$brugernavn}','{$fornavn}','{$efternavn}','{$adresse}','{$bosted}','{$email}','{$telefon}','{$alder}','{$stemme}','{$erfaring}','{$kor_type}','{$job}','{$relate}','{$persona}')";

    $create_user_query = mysqli_query($conn, $query);

    if(!$create_user_query) {
      die("Query Failed: " . mysqli_error($conn));
    } else {
      $message = urlencode("success");
      header("Location: index.php?message=".$message);
      die;
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
      <form class="col s12" action="" method="post" autocomplete="on">
        <div class="row">
          <div class="input-field col s12 m6">
            <input id="fornavn" type="text" class="validate" name="fornavn">
            <label for="fornavn">Fornavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="efternavn" type="text" class="validate" name="efternavn">
            <label for="efternavn">Efternavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="adresse" type="text" class="validate" name="adresse">
            <label for="adresse">Adresse</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="bosted" type="text" class="validate" name="bosted">
            <label for="bosted">Postnummer og by</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="email" type="email" class="validate" name="email">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="telefon" type="tel" class="validate" name="telefon">
            <label for="telefon">Telefon nummer</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6">
            <input id="alder" type="date" class="datepicker" name="alder">
            <label for="alder">Din fødselsdato</label>
          </div>
          <div class="input-field col s12 m6">
            <select name="stemme">
              <option value="" disabled selected>Vælg din stemme</option>
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
          </div>
          <div class="input-field col s12 m6">
            <input id="erfaring" type="text" class="validate" name="erfaring">
            <label for="erfaring">Hvilken stemme/r har du sunget før?</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="kor_type" type="text" class="validate" name="kor_type">
            <label for="kor_type">Hviklet type kor har du sunget i før?</label>
          </div>
          <div class="input-field col s12 m6">
            <select name="job">
              <option value="Studerende">Studerende</option>
              <option value="Selvstændig">Selvstændig</option>
              <option value="I arbejde">I arbejde</option>
              <option value="Ledig">Ledig</option>
              <option value="Studerende ved SDU">Studerende ved SDU</option>
              <option value="Har relation til SDU">Har relation til SDU</option>
              <option value="Pensionist">Pensionist</option>
              <option value="Ønsker ikke at oplyse">Ønsker ikke at oplyse</option>
            </select>
            <label>Beskæftigelse?</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="relate" type="text" class="validate" name="relate">
            <label for="relate">Hvor har du hørt på Storekoret?</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="persona" class="materialize-textarea" name="persona"></textarea>
            <label for="persona">Skriv en kort introduktion af dig selv</label>
          </div>
        </div>
      </div>
      <div class="row center">
        <button class="btn waves-effect waves-light" type="submit" name="optag_form">Send ansøgning<i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</section>

</div>
<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>
