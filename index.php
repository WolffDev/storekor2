<?php include "includes/header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "includes/navbar.php"; ?>
<!-- ****** INTRO ******-->
<?php
  if(isset($_GET['message'])) {
    if ($_GET['message'] === 'success') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Optagelse afsendt</h4>
          <p>Vi har nu modtaget din ansøgning.<br>Du vil modtage et svar fra Korbestryrelsen inden for 7 dage.<br>Er det uden for sæsson, skal du påregne op til 4 uger svar tid.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

    if ($_GET['message'] === 'success_edit_profile_password' && $_GET['logout'] == 'true') {
      $edit_name = escape($_GET['edit_name']); 
    ?>
      <div class="container">
        <div class="row teal">
          <div class="col s12 center white-text bold">
            <p>
              <?php echo ucfirst($edit_name); ?>, din profil og adgangskode er nu blevet ændret.
              <br>
              Du er blevet logget ud.
              <br>
              Venligst login igen, med den nye adgangskode.
            </p>
          </div>
        </div>
      </div>
<?php }

    if ($_GET['message'] === 'unapproved') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Ansøgning modtaget</h4>
          <p>Vi har modtaget din ansøgning, men den er endnu ikke blevet godkendt.<br>Hvis det er uden for sæssonen, så kan der gå op til 4 uger, før vi får gennemgået din ansøgning og fået sendt en email til dig.<br>Vi beklager ulejligheden og for snarest gennemgået din ansøgning.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

    if ($_GET['message'] === 'resetpassword') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Adgangskode nustillet</h4>
          <p>
            Din adgangskode er nu blevet nulstillet.<br>
            Der er sendt en mail til <?php echo escape($_GET['resetmail']); ?><br><br>
            I mailen vil der være et link til en side, hvor du kan vælge en ny adgangskode.<br>
            HUSK - dette link vil kun være aktivt i 30 minutter fra du modtager mailen.<br><br>
            Der kan nogen gange gå op til 10 minutter før du modtager mailen.<br>
            Mailen kan nogen gange ligge i din spam mappe.
          </p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

    if ($_GET['message'] === 'resetrecent') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Adgangskode nustillet</h4>
          <p>
            Din adgangskode er blevet nulstillet for nyligt - mindre end 10 minutter siden.<br>
            Vent mindst 10 minutter, før du prøver at nulstille din adgangskode igen.<br><br>
            Hvis du efter gentagende forsøg stadig ikke modtager en mail, så tag kontakt til bestyrrelsen, hvorefter de vil kunne guide dig videre, med at nulstille din adgangskode.
          </p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

    if ($_GET['message'] === 'resetpasswordold') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Udløbet</h4>
          <p>
            Dit link for at nulstille din adgangskode er udløbet.<br><br>
            Du kan prøve at nulstille din adgangskode igen.<br>
            HUSK - du har 30 minutter efter du har modtaget mailen, til at nulstille din adgangskode.
          </p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

    if ($_GET['message'] === 'resetpasswordtrue') { ?>
      <div id="modal1" class="modal">
        <div class="modal-content black-text">
          <h4>Ny adgangskode oprettet</h4>
          <p>
            Din nye adgangskode er nu aktiv.<br>
            Du kan nu logge ind med den nye adgangskode.
          </p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Luk besked</a>
        </div>
      </div>
      <script type="text/javascript">
        $('#modal1').openModal();
      </script>
<?php }

  if ($_GET['message'] === 'invalid_login') { ?>
    <script type="text/javascript">
      var $toastContent = $('<span>Email og/eller password er forkert.</span>');
      Materialize.toast($toastContent, 4000, 'toastInvalidUser');
    </script>
<?php } }?>
<div id="index-banner" class="parallax-container">
  <div class="section no-pad-bot">
    <div class="container"><br/><br/>
      <h1 class="header center white-text text-lighten-2">Storekor || Odense</h1>
      <div class="row center">
        <h5 class="header col s12">Klassisk repertoire med a cappella og orkesterledsagelse</h5>
      </div>
      <?php
      $query = "SELECT * FROM optagelse_status WHERE id = 1";
      $status_query = mysqli_query($conn, $query);
      while($status_read = mysqli_fetch_assoc($status_query)) {
        $status = $status_read['status'];
      }
      if($status == 1) {
      ?>
      <div class="row center"><a href="./optagelse.php" class="btn-large waves-effect waves-light teal lighten-1">Søg optagelse!</a></div>
      <?php } ?>
    </div>
  </div>
  <div class="parallax"><img src="img/koncert6.jpg" alt=""/></div>
</div>
<div class="container">
  <section>
    <div class="row">
      <div class="col s12 m4">
        <div class="icon-block">
          <?php
            if($status == 1) {
          ?>
          <h2 class="center green-text"><i class="material-icons">power_settings_new</i>
          </h2>
          <h5 class="center green-text">Åben for optagelse</h5>
          <p>Vi holder løbende optagelsesprøver og søger nye medlemmer til Storekoret. Vi øver hver mandag fra kl. 19.00 til 21.30i Henriettesalen på Henriette Hørlücks skole</p>
          <?php } else { ?>
            <h2 class="center red-text"><i class="material-icons">power_settings_new</i>
            </h2>
            <h5 class="center red-text">Lukket for optagelse</h5>
            <p>Vores medlemsantal er på nuværrende tidspunkt <strong><em>opfyldt</em></strong>, så vi søger ikke nye medlemmer.<br>Du er altid velkommen til at skrive til os og vi vil gemmen din ansøgning, hvis der opstår en åben plads.</p>
          <?php } ?>
        </div>
      </div>
      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center blue-text darken-4"><i class="material-icons">group</i></h2>
          <h5 class="center blue-text darken-4">Kort om Storekoret</h5>
          <p>Vi er et alsidigt kor med overvejende klassisk repertoire, både a cappella og større værker med orkesterledsagelse. Vi er også et socialt kor der ses uden for prøverne og koncerterne til årstidernes fester, og vi mødes ofte på Carlsens Kvarter efter den ugentlige korprøve</p>
        </div>
      </div>
      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center yellow-text text-darken-3"><i class="material-icons">lightbulb_outline</i></h2>
          <h5 class="center yellow-text text-darken-3">Storekoret består</h5>
          <p>Storekoret har dybe rødder i det fynske korliv. Koret blev i 1964 stiftet som Skt. Knuds gymnasiums kor. I 1984 blev koret tilknyttet Odense Universitet og siden Syddansk Universitet som indtil 2017 har lønnet korets dirigent. Fra 2017 videreføres koret som et uafhængigt kor under navnet Storekoret, Odense</p>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- ****** KONCERTER ******-->
<div class="parallax-container valign-wrapper">
  <div class="section no-pad-bot container">
    <div class="row center">
    </div>
  </div>
  <div class="parallax"><img src="./img/koncert2.jpg" alt="Unsplashed background img 2"/></div>
</div>
<div id="koncerter" class="container">
  <div class="section">
    <div class="row">
      <div class="col s12 center">
        <h4 class="yellow-text text-darken-3"><i class="medium material-icons">star_border</i><i class="medium material-icons">star_border</i><i class="medium material-icons">star_border</i>
          <h4>Koncerter</h4>
        </h4>
      </div>
    </div>
    <?php
      $query = "SELECT
        title,
        long_text,
        event_img,
        start_date,
        end_date
      FROM
        events
      WHERE
        old_event = 0
      AND
        type = 'koncert'
      AND
        start_date >= SUBDATE( NOW(), INTERVAL 12 HOUR)
      ORDER BY
        start_date
      LIMIT
       3";
      $koncert_result = mysqli_query($conn, $query);
      if(mysqli_num_rows($koncert_result) > 0) {
        while($row = mysqli_fetch_assoc($koncert_result)) {
          $title = $row['title'];
          $long_text = $row['long_text'];
          $start_date = $row['start_date'];
          $end_date = $row['end_date'];
          $event_img = $row['event_img'];

          $start_date_format = date_format(new DateTime($start_date), '\, \d\. j\. F ');
          $start_date_time = date_format(new DateTime($start_date), 'H:i');
          $end_date_time = date_format(new DateTime($end_date), 'H:i');

        ?>
          <div class="row">
            <div class="col s12 l6"><img src="img/koncert.jpg"/></div>
            <div class="col s12 l6 concert-details">
              <div class="col m7 s12 left-align">
                <h5><?php echo $title; ?></h5>
              </div>
              <div class="col m5 s12 left-align">
                <span class="concert-time">klokken <?php echo $start_date_time; ?> - <?php echo $end_date_time .  $start_date_format; ?> </span>
              </div>
              <div class="col s12 left-align">
                <p class="left-align"><?php echo $long_text; ?></p>
              </div>
            </div>
          </div>
          <hr class="style14">
          <!-- https://codepen.io/ibrahimjabbari/pen/ozinB -->
        <?php } ?>
      <?php } else { ?>
        <div class="row">
          <div class="col s12">
            <h5 class="center">Der er ingen planlagte koncerter på programmet.</h5>
          </div>
        </div>
      <?php } ?>
  </div>
</div>
<!-- ****** KONTAKT******-->
<div id="kontakt" class="parallax-container valign-wrapper">
  <div class="section no-pad-bot container">
    <div class="row center">
      <h5 class="header col s12"></h5>
    </div>
  </div>
  <div class="parallax"><img src="./img/koncert5.jpg" alt="Unsplashed background img 2"/></div>
</div>
<div class="container">
  <div class="section">
    <div class="row">
      <div class="col s12 center">
        <h4 class="red-text"><a href="mailto:kontakt@storekor.dk"><i class="medium material-icons">mail_outline</i></a></h4>
        <h4>Kontakt</h4>
        <p class="center">Hvis du er interesseret i at komme ind i Storekoret skal du søge om optagelse <a href="/optagelse">her på siden</a>.
        <br>
        Hvis du har andre spørgsmål, kan du enten ringe til vores dirigent, Theis Lyng Reinvang, på <a href="tel:31188873">31 18 88 73</a>,<br>skrive til Theis på <a href="mailto:reinvang@gmail.com">reinvang (at) gmail.com</a> eller sende en mail til korets bestyrelse på <a href="mailto:kontakt@storekor.dk">kontakt (at) storekor.dk</a>.</p>
      </div>
    </div>
  </div>
</div>
<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>
