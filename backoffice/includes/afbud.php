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

      if(isset($_POST['meld_afbud'])) {
        $reason = escape($_POST['reason']);
        if($reason == '') {
          ?>
            <script type="text/javascript">
              var $toastContent = $('<span>Du har ikke indtastet en grund til afbud.</span>');
              Materialize.toast($toastContent, 4000, 'toastInvalidUser');
            </script>
          <?php
        } else {
          $date_cancel = date('Y-m-d H:i:s');
          $query = "INSERT INTO afbud(m_id, e_id, date_cancel, reason) VALUES('{$m_id}', '{$e_id}', now(), '{$reason}')";
          $insert_afmeld = mysqli_query($conn, $query);

          if(!$insert_afmeld) {
            die("Query Failed: " . mysqli_error($conn));
          } else {
            $message = urlencode("afbud_modtaget");
            header("Location: index.php?action=ovegange&message=".$message);
            mysqli_close($conn);

          }
        }
      }
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

          <form method="post" class="s6">
            <div class="row">
              <div class="input-field col s12 m6">
                <input type="text" name="reason" id="reason">
                <label for="reason">Hvorfor melder du afbud?</label>
              </div>
            </div>

            <div class="row s12">
              <div class="col s6 m3">
                <button class="btn waves-effect waves-light red darken-3 white-text" type="submit" name="meld_afbud">Meld afbud
                </button>
              </div>
              <div class="col s6 m3">
                <a href="index.php?action=ovegange"><button class="btn waves-effect waves-light white-text">Annuller</button></a>
              </div>
            </div>
          </form>
      </div>
  <?php }
  ?>


</div>
