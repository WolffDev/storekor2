<?php
$uploaded = false;
if(isset($_POST['upload_files'])){
  if(!empty($_POST['category']) && !empty($_FILES['files'])) {
    $upload_category = $_POST['category'];
  	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ) {
  		$file_name = $_FILES['files']['name'][$key];
  		$file_size = $_FILES['files']['size'][$key];
  		$file_tmp = $_FILES['files']['tmp_name'][$key];
  		$file_type= $_FILES['files']['type'][$key];

      $temp_ext = explode('.', $file_name);
      $ext = end($temp_ext);

      $file_destination = "uploads/dirigent/";
      $random = substr(str_shuffle(MD5(microtime())), 0, 15);;
      move_uploaded_file($file_tmp, $file_destination . $random . "." . $ext);

      $file_path = $file_destination . $random . "." . $ext;


      $query="INSERT into uploads (upload_name, upload_size, upload_type, upload_date, upload_category, upload_status, upload_path) VALUES('$file_name','$file_size','$file_type', NOW(), '$upload_category', 1, '$file_path'); ";

      $upload_files = mysqli_query($conn, $query);
  		$uploaded = true;
    }
  } else {
    echo "asdasd";
  }
}

if(isset($_POST['checkBoxArray'])) {
  foreach($_POST['checkBoxArray'] as $checkbox_upload_id) {
    $bulk_options = $_POST['bulk_options'];

    switch ($bulk_options) {
      case 'noder':
        $query = "UPDATE uploads SET upload_category = '{$bulk_options}' WHERE upload_id = '{$checkbox_upload_id}'";
        $update = mysqli_query($conn, $query);
        break;
      case 'øvefiler':
        $query = "UPDATE uploads SET upload_category = '{$bulk_options}' WHERE upload_id = '{$checkbox_upload_id}'";
        $update = mysqli_query($conn, $query);
        break;
      case 'koncert programmer':
        $query = "UPDATE uploads SET upload_category = '{$bulk_options}' WHERE upload_id = '{$checkbox_upload_id}'";
        $update = mysqli_query($conn, $query);
        break;
      case 'pr materiale':
        $query = "UPDATE uploads SET upload_category = '{$bulk_options}' WHERE upload_id = '{$checkbox_upload_id}'";
        $update = mysqli_query($conn, $query);
        break;
      case 'delete':
        $file_query = "SELECT upload_path FROM uploads WHERE upload_id = '{$checkbox_upload_id}'";
        $get_file = mysqli_query($conn, $file_query);
        while($row = mysqli_fetch_assoc($get_file)) {
          $file_path = $row['upload_path'];
        }
        $script_path = $_SERVER['DOCUMENT_ROOT'];
        $path = $script_path . "/" . "backoffice" . "/" . $file_path;

        unlink($path);

        $query = "DELETE FROM uploads WHERE upload_id = '{$checkbox_upload_id}'";
        $update = mysqli_query($conn, $query);
        break;
    }
  }
}

if(isset($_POST['rename'])) {
  var_dump($_POST['rename']);
  var_dump($_POST['rename_id']);

}
?>
<div class="container content-container">
  <?php if ($_SESSION['auth'] < 4) { ?>

  <div class="row">
    <div class="col s12 m4 flow-text">
      <?php if($uploaded) { ?>
        <p class="teal darken-2 center white-text">
          Filen er nu uploadet
        </p>
      <?php } ?>
      <p>
        Her kan du uploade filer som resten af koret kan se.
      </p>
      <p>
        Husk at slette de filer der ikke længere er nødvendige, da filerne vil optage unødvendig plads på serveren.
      </p>
    </div>

    <form method="post" enctype="multipart/form-data" class="col s12 m8">
      <div class="file-field input-field col s12">
        <div class="btn">
          <span>Vælg filer</span>
          <input type="file" multiple name="files[]" required>
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Upload en eller flere filer på en gang">
        </div>
      </div>
      <div class="input-field col s12">
        <select class="" name="category" required>
          <option value="" disabled selected="selected">Vælg kategori til upload</option>
          <option value="noder">Noder</option>
          <option value="øvefiler">Øvefiler</option>
          <option value="pr materiale">PR Materiale</option>
          <option value="koncert programmer">Koncert Programmer</option>
        </select>
      </div>
      <div class="col s12">
        <button class="btn waves-effect waves-light blue darken-2" type="submit" name="upload_files" id="upload_btn_activate_spinner">Upload
        <i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
  <hr>
  <?php } ?>

  <div class="row content-container">

    <form method="post">
      <?php if ($_SESSION['auth'] < 4) { ?>
        <div class="col m3"></div>
        <div id="bulkOptionContainer" class="col s12 m3">
          <select class="form-control" name="bulk_options">
            <option disabled selected value="">Vælg handling</option>
            <option value="noder" >Kategory: Noder</option>
            <option value="øvefiler">Kategory: Øvefiler</option>
            <option value="pr materiale">Kategory: PR Materiale</option>
            <option value="koncert">Kategory: Koncert Programmer</option>
            <option value="delete">Slet fil permanent</option>
          </select>
        </div>
        <div class="col s12 m3">
          <button class="btn waves-effect waves-light" type="submit" name="update_files">Opdater</button>
        </div>
        <div class="col m3"></div>
      <?php } ?>

      <table class="striped" id="medlemmer_table">
        <thead>
          <tr>
            <?php if ($_SESSION['auth'] < 4) { ?>
              <th><input name="select_all" value="" id="selectAllBoxes" type="checkbox" /></th>
            <?php } ?>
            <th>Filnavn</th>
            <th>Filtype</th>
            <th>Kategory</th>
            <th>Upload dato</th>
            <th>#</th>
          </tr>
        </thead>

        <tbody>
          <?php
            $download_query = "SELECT
              *
            FROM
              uploads
            ORDER BY
              upload_date ASC";
            $download_result = mysqli_query($conn, $download_query);

            while($row = mysqli_fetch_assoc($download_result)) {
              $upload_id = $row['upload_id'];
              $upload_name = $row['upload_name'];
              $upload_type = $row['upload_type'];
              $upload_date = $row['upload_date'];
              $upload_category = $row['upload_category'];
              $upload_path = $row['upload_path'];

              $str_length = strlen($upload_type);
              $str_cut = strpos($upload_type, "/");
              $new_upload_type = strtoupper(substr($upload_type, ($str_cut + 1), $str_length));

              if (strlen($upload_name) >= 30) {
                $str_cut_short = strlen($upload_name);
                $upload_name = substr_replace($upload_name, '...', 20, -10);
              }

              $upload_date = date_format(new DateTime($upload_date), 'j\. M \k\l\. H:i');

              echo "<tr>";
              if ($_SESSION['auth'] < 4) {
                echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='" . $upload_id . "'></td>";
              }
              echo "<td>" . $upload_name . "</td>";
              echo "<td>" . $new_upload_type . "</td>";
              echo "<td>" . $upload_category . "</td>";
              echo "<td>" . $upload_date . "</td>";
              echo "<td><a href='" . $upload_path . "' target='_blank'><div class='btn teal darken-2 waves-effect waves-light'>Download</div></a></td>";
              echo "</tr>";
            }
          ?>
        </tbody>

      </table>

    </form>
  </div>

</div>
