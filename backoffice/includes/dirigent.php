<?php
if(isset($_FILES['files'])){
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ) {
		$file_name = $_FILES['files']['name'][$key];
		$file_size = $_FILES['files']['size'][$key];
		$file_tmp = $_FILES['files']['tmp_name'][$key];
		$file_type= $_FILES['files']['type'][$key];

    $file_destination = "uploads/dirigent/";
    $random = substr(str_shuffle(MD5(microtime())), 0, 10);;
    move_uploaded_file($file_tmp, $file_destination . $random . $file_name);

    $file_path = $file_destination . $random . $file_name;


    $query="INSERT into uploads (upload_name, upload_size, upload_type, upload_date, upload_path) VALUES('$file_name','$file_size','$file_type', NOW(), '$file_path'); ";

    $upload_files = mysqli_query($conn, $query);
		echo "Success";
  }
}
?>
<div class="container content-container">
  <form method="post" enctype="multipart/form-data">
      <div class="file-field input-field">
        <div class="btn">
          <span>Vælg filer</span>
          <input type="file" multiple name="files[]">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" placeholder="Upload en eller flere filer på en gang">
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="upload">Upload
      <i class="material-icons right">send</i>
    </button>
    </form>
  </div>
