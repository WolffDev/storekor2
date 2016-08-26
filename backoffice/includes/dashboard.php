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
            while($row = mysqli_fetch_assoc($get_new_apps)) {
              $app_id = $row['id'];
              $fornavn = $row['fornavn'];
              $efternavn = $row['efternavn'];
              $name = $fornavn . " " . $efternavn;
              echo "<a href='index.php?action=view_new_app&app_id=$app_id'><button class='btn waves-effect teal waves-light'>$name</button></a>";
            }
          ?>
        </ul>
      </div>
      <div class="col s12 m4 dashboard-card">test</div>
    </div>
</div>
