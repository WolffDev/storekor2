<?php
if(isset($_FILES['files'])){
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ) {
		$file_name = $_FILES['files']['name'][$key];
		$file_size = $_FILES['files']['size'][$key];
		$file_tmp = $_FILES['files']['tmp_name'][$key];
		$file_type= $_FILES['files']['type'][$key];

    $temp_ext = explode('.', $file_name);
    $ext = end($temp_ext);

    $file_destination = "uploads/dirigent/";
    $random = substr(str_shuffle(MD5(microtime())), 0, 10);;
    move_uploaded_file($file_tmp, $file_destination . $random . $file_name);

    $file_path = $file_destination . $random . "." . $ext;


    $query="INSERT into uploads (upload_name, upload_size, upload_type, upload_date, upload_path) VALUES('$file_name','$file_size','$file_type', NOW(), '$file_path'); ";

    $upload_files = mysqli_query($conn, $query);
		echo "Success";
  }
}
?>
<div class="container content-container">
  <?php if ($_SESSION['auth'] < 4) { ?>
  <div class="row">
    <div class="col s12 m4 flow-text">
      <p>
        Her kan du uploade filer som resten af koret kan se.
      </p>
      <p>
        Husk at slette de filer der ikke længere er nødvendige, da filerne vil optage unødvendig plads på serveren.
      </p>
    </div>

    <form method="post" enctype="multipart/form-data" class="col s12 m8">
      <div class="input-field col s12">
        <select class="" name="category">
          <option value="" disabled selected="selected">Vælg kategori til upload</option>
          <option value="noder">Noder</option>
          <option value="oevefiler">Øvefiler</option>
          <option value="pr">PR Materiale</option>
          <option value="koncert_programmer">Koncert Programmer</option>
        </select>
      </div>
      <div class="file-field input-field col s12">
        <div class="btn">
          <span>Vælg filer</span>
          <input type="file" multiple name="files[]">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Upload en eller flere filer på en gang">
        </div>
      </div>
      <div class="col s12">
        <button class="btn waves-effect waves-light blue darken-2" type="submit" name="upload">Upload
        <i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
  <?php } ?>

</div>
