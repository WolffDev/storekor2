<?php
$e_id = escape($_GET['e_id']);

$check_query = "SELECT
  d_e_id
FROM
  deltagere
WHERE
  d_e_id = {$e_id}
GROUP BY
  d_e_id";
$check_conn = mysqli_query($conn, $check_query);
$query_count = mysqli_num_rows($check_conn);
if($query_count > 0) {
  echo "<div class='container content-container'>";
  echo "<div class='row'>";
  echo "<div class='col s12 teal white-text center flow-text'>";
  echo "Protokol listen er blevet opdateret for i dag.<br>";
  echo "Hvis der skal rettes i protokollen, så kun hak af i de nye tilkommende, eller de personer som ikke er hakket af første gang.";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

if(isset($_POST['checkboxDeltagerArray'])) {
  foreach($_POST['checkboxDeltagerArray'] as $checkbox_deltager_id) {
    $deltager_query = "INSERT INTO
      deltagere(d_m_id, d_e_id, d_date)
    VALUES(
      {$checkbox_deltager_id}, {$e_id}, NOW()
    )";
    $deltager_conn = mysqli_query($conn, $deltager_query);
  }
  if(!$deltager_conn) {
    die("Query Failed: " . mysqli_error($conn));
  } else {
    echo "<div class='container content-container'>";
    echo "<div class='row'>";
    echo "<div class='col s12 teal white-text center flow-text'>";
    echo "Protokol listen er blevet opdateret for i dag.<br>";
    echo "Hvis der skal rettes i protokollen, så kun hak af i de nye tilkommende, eller de personer som ikke er hakket af første gang.";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}
?>
<div class="container content-container protocol_detail">
  <form action="" method="post">
    <div class="row">
      <div class="col s12 m9 l10">

        <?php protocol_detail('1sopran', '1. Sopran'); ?>
        <?php protocol_detail('2sopran', '2. Sopran'); ?>
        <?php protocol_detail('1alt', '1. Alt'); ?>
        <?php protocol_detail('2alt', '2. Alt'); ?>
        <?php protocol_detail('1tenor', '1. Tenor'); ?>
        <?php protocol_detail('2tenor', '2. Tenor'); ?>
        <?php protocol_detail('1bass', '1. Bass'); ?>
        <?php protocol_detail('2bass', '2. Bass'); ?>

      </div>

      <div class="col hide-on-small-only m3 l2">
        <ul class="section table-of-contents fixedElement">
          <li><a href="#1sopran">1. Sopran</a></li>
          <li><a href="#2sopran">2. Sopran</a></li>
          <li><a href="#1alt">1. Alt</a></li>
          <li><a href="#2alt">2. Alt</a></li>
          <li><a href="#1tenor">1. Tenor</a></li>
          <li><a href="#2tenor">2. Tenor</a></li>
          <li><a href="#1bass">1. Bass</a></li>
          <li><a href="#2bass">2. Bass</a></li>
          <li>
            <button class="btn waves-effect waves-light" type="submit" name="submit">Indsend
              <i class="material-icons right">send</i>
            </button>
          </li>
        </ul>
      </div>

    </div>
  </form>
</div>
