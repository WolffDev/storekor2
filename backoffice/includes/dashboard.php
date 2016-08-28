<script src="js/chart.bundle.2.2.2.min.js"></script>
<?php
if(isset($_POST['status_open'])) {
  $query = "UPDATE optagelse_status SET status = 1 WHERE id = 1";
  $upate_status = mysqli_query($conn, $query);
}
if(isset($_POST['status_close'])) {
  $query = "UPDATE optagelse_status SET status = 0 WHERE id = 1";
  $upate_status = mysqli_query($conn, $query);
}
?>
<div class="row">
  <div class="col s12">
    <h5>Velkommen <?php echo $_SESSION['fornavn']; ?></h5>
    <div class="divider"></div>
  </div>
</div>
<div class="container dashboard">
  <?php
  $status_query = "SELECT * FROM optagelse_status WHERE id = 1";
  $get_status = mysqli_query($conn, $status_query);
  while($row = mysqli_fetch_assoc($get_status)) {
    $optagelse_status = $row['status'];
  }
  if($optagelse_status == 0) { ?>
    <div class="row">
      <div class="col s12 m4 dashboard-card red darken-3 white-text center">
        <p>Optalgelse status</p>
        <h5>LUKKET</h5>
        <div class="row">
          <form class="" action="" method="post">
            <button class="btn waves-effect waves-light" type="submit" name="status_open">Åben optagelse</button>
          </form>
        </div>
      </div>
  <?php } else { ?>
    <div class="row">
      <div class="col s12 m4 dashboard-card teal lighten-1 white-text center">
        <p>Optalgelse status</p>
        <h5>ÅBEN</h5>
        <div class="row">
          <form class="" action="" method="post">
            <button class="btn waves-effect red darken-3 waves-light" type="submit" name="status_close">Luk optagelse</button>
          </form>
        </div>
      </div>
  <?php } ?>
      <div class="col s12 m4 dashboard-card new-apps blue darken-2 white-text center">
        <p class="flow-text">
          Nye anøsninger
        </p>
        <ul>
          <?php
            $query = "SELECT id, fornavn, efternavn, app_status FROM medlemmer WHERE app_status = 'ny' || app_status = 'oprettet af bestyrelsen' LIMIT 4";
            $get_new_apps = mysqli_query($conn, $query);
            $row_count = mysqli_num_rows($get_new_apps);
            if($row_count > 0) {
              while($row = mysqli_fetch_assoc($get_new_apps)) {
                $app_id = $row['id'];
                $fornavn = $row['fornavn'];
                $efternavn = $row['efternavn'];
                $name = $fornavn . " " . $efternavn;
                echo "<a href='index.php?action=view_new_app&app_id=$app_id'><button class='btn waves-effect teal waves-light'>$name</button></a>";
              }
            } else {
              echo "<p>Ingen nye ansøgninger</p>";
            }
          ?>
        </ul>
      </div>
      <div class="col s12 m4 dashboard-card">
      </div>
    </div>

    <div class="row">
      <?php
        $voice_query = "SELECT stemme FROM medlemmer WHERE app_status = 'godkendt'"; //get array result
        $voice_result = mysqli_query($conn, $voice_query);
        while($row = mysqli_fetch_assoc($voice_result)) {
          $stemmer[] = $row['stemme'];
        }
        $total_count = array_count_values($stemmer);
        $total_count_1sopran = $total_count['1. Sopran'];
        $total_count_2sopran = $total_count['2. Sopran'];
        $total_count_1alt = $total_count['1. Alt'];
        $total_count_2alt = $total_count['2. Alt'];
        $total_count_1tenor = $total_count['1. Tenor'];
        $total_count_2tenor = $total_count['2. Tenor'];
        $total_count_1bass = $total_count['1. Bass'];
        $total_count_2bass = $total_count['2. Bass'];
      ?>

      <?php
      $s1 = 0;
      $s2 = 0;
      $a1 = 0;
      $a2 = 0;
      $t1 = 0;
      $t2 = 0;
      $b1 = 0;
      $b2 = 0;
      $count_query = "SELECT stemme, bruger_status FROM medlemmer WHERE app_status = 'godkendt'";
      $count_result = mysqli_query($conn, $count_query);
      while($row = mysqli_fetch_assoc($count_result)) {
        $stemme = $row['stemme'];
        $bruger_status = $row['bruger_status'];
        if($stemme == '1. Sopran' && $bruger_status == 'orlov') {
          $s1++;
        }
        if($stemme == '2. Sopran' && $bruger_status == 'orlov') {
          $s2++;
        }
        if($stemme == '1. Alt' && $bruger_status == 'orlov') {
          $a1++;
        }
        if($stemme == '2. Alt' && $bruger_status == 'orlov') {
          $a2++;
        }
        if($stemme == '1. Tenor' && $bruger_status == 'orlov') {
          $t1++;
        }
        if($stemme == '2. Tenor' && $bruger_status == 'orlov') {
          $t2++;
        }
        if($stemme == '1. Bass' && $bruger_status == 'orlov') {
          $b1++;
        }
        if($stemme == '2. Bass' && $bruger_status == 'orlov') {
          $b2++;
        }
      }
      ?>

      <div class="col s12 m3">

      </div>

      <div class="col s12 m3">

      </div>

      <div class="col s12 m3">

      </div>

      <div class="col s12 m3">

      </div>

    </div>

</div>
