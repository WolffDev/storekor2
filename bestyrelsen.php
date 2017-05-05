<?php include "includes/header.php"; ?>
<!-- ****** Navbar *****-->
<?php include "includes/navbar.php"; ?>

<?php 
  $query = "SELECT
    CONCAT(fornavn,' ', efternavn) AS navn,
    bruger_rolle AS rolle
  FROM
    medlemmer
  WHERE
    bruger_rolle = 'kasserer'
  OR
    bruger_rolle = 'formand'
  OR
    bruger_rolle = 'bestyrelsen'
  ORDER BY 
    FIELD(bruger_rolle, 'formand') DESC";

  $get_members = mysqli_query($conn, $query);


?>

<!-- ****** INTRO ******-->
<div id="index-banner" class="parallax-container">
  <div class="section no-pad-bot">
    <div class="container"><br/><br/>
      <h1 class="header center white-text text-lighten-2">Storekor || Bestyrelsen</h1>
    </div>
  </div>
  <div class="parallax"><img src="img/koncert6.jpg" alt="Unsplashed background img 1"/></div>
</div>
<div class="container">
  <section>
    <div class="row">
      <div class="col s12 center-align">
        <div class="icon-block flow-text">
          <h2 class="center green-text"><i class="material-icons"></i>
          </h2>
          <?php
            while($row = mysqli_fetch_assoc($get_members)) {
              $navn = $row['navn'];
              $rolle = $row['rolle'];

              if($rolle == 'formand') {
                echo "<p>$navn || <b>$rolle</b></p>";
              } else if($rolle == 'kasserer'){
                echo "<p>$navn || <b>$rolle</b></p>";
              } else {
                echo "<p>$navn</p>";
              }
            }
          ?>
          <p>Skriv til bestyrelsen på <a href="mailto:korbestyrelsen@gmail.com">korbestyrelsen (at) gmail.com</a></p>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ****** FOOTER ******-->
<?php include "./includes/footer.php"; ?>
