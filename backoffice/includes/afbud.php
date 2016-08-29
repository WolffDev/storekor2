<div class="afbud">
  <?php
    if(isset($_GET['cancel']) && $_GET['cancel'] == 'true') {
      $e_id = escape($_GET['e_id']);
      $m_id = escape($_GET['m_id']);

      $query = "SELECT type, start_date FROM events WHERE id = {$e_id}";
      $get_event = mysqli_query($conn, $query);

      while($row = mysqli_fetch_assoc($get_event)) {
        $e_type = $row['type'];
        $start_date = $row['start_date'];
      }
      $start_date_format = date_format(new DateTime($start_date), 'D \d\. j\. M \k\l\. H:i');
      ?>
      <div class="container">
        <h5>Melde afbud</h5>
        <div class="row">
          <div class="col s12 m8 flow-text">
            <p>
              Du er ved at melde dig fra følgende event:<br>
              Type: <?php echo $e_type; ?>
              <br>
              Med start: <?php echo $start_date_format; ?>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col s6 m3">
            <form method="post">
              <button class="btn waves-effect waves-light red darken-3 white-text" type="submit" name="meld_afbud">Meld afbud
              </button>
            </form>
          </div>
          <div class="col s6 m3">
            <a href="index.php?action=ovegange"><button class="btn waves-effect waves-light white-text">Annuller</button></a>
          </div>
        </div>
      </div>
  <?php }
  ?>


</div>
