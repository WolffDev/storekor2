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
<?php
    }
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
  <div class="parallax"><img src="img/people3.jpg" alt="Unsplashed background img 1"/></div>
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
          <p>Vi holder løbende optagelseprøver og lige nu søger vi nye medlemmer til Storekoret.<br>Vi øver hver mandag fra kl. 19.00 til 21.30, ofte i lokale U77 på Syddansk Universitet.</p>
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
          <p>Vi er et meget socialt kor, der også ses uden for prøverne og koncerterne. Vores stamsted er Carlsens Kvarter, hvor vi som regel mødes efter den ugentlige korprøve.</p>
        </div>
      </div>
      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center yellow-text text-darken-3"><i class="material-icons">lightbulb_outline</i></h2>
          <h5 class="center yellow-text text-darken-3">Stadig med på moden</h5>
          <p>Storekoret har rødder helt tilbage til år 1964, hvor koret blev stiftet under navnet Skt. Knuds gymnasiums kor.<br>Storekorets medlemmer findes i alle aldre - de unge får stor udbytte fra de ældres erfaringer.</p>
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
  <div class="parallax"><img src="./img/people2.jpg" alt="Unsplashed background img 2"/></div>
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

          $start_date_format = date_format(new DateTime($start_date), '\d\. j\. M\, \k\l\. H:i');
          $end_date_format = date_format(new DateTime($end_date), '\d\. j\. M\, \k\l\. H:i');
          $start_date_check = date_format(new DateTime($start_date), 'd m Y');
          $end_date_check = date_format(new DateTime($end_date), 'd m Y');
          $end_date_time = date_format(new DateTime($end_date), '\k\l\. H:i');

        ?>
          <div class="row">
            <div class="col s12 l6">
              <h5 class="left-align"><?php echo $title; ?></h5>
              <span class="span">
                Start: <? echo $start_date_format . "<br>Slut: ";

                if($start_date_check === $end_date_check) {
                  echo $end_date_time;
                } else {
                  echo $end_date_format;
                } ?>
              </span>
              <p class="left-align"><?php echo $long_text; ?></p>
            </div>
            <div class="col s12 l6"><img src="img/background1.jpg"/></div>
          </div>
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
      <h5 class="header col s12">If you hear the birds singing does it have to have a message?</h5>
    </div>
  </div>
  <div class="parallax"><img src="./img/people4.jpg" alt="Unsplashed background img 2"/></div>
</div>
<div class="container">
  <div class="section">
    <div class="row">
      <div class="col s12 center">
        <h4 class="red-text"><i class="medium material-icons">mail_outline</i></h4>
        <h4>Kontakt</h4>
        <p class="left-align">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
      </div>
    </div>
  </div>
</div>
<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>
