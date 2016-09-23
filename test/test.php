<?php
define("UPLOAD_DIR", "uploads/");
if (!empty($_FILES["profil_billede"])) {
  $profil_billede = $_FILES["profil_billede"];

  if ($profil_billede["error"] !== UPLOAD_ERR_OK) {
      echo "<p>Der skete en fejl, prøv at uploade et nyt billede.</p>";
      exit;
  }

  // ensure a safe filename
  $name = preg_replace("/[^A-Z0-9._-]/i", "_", $profil_billede["name"]);
  // $name = 'profil' . $user_id . $fornavn;

  // don't overwrite an existing file
  $i = 0;
  $parts = pathinfo($name);
  $new_name = 'profil' . $user_id . $fornavn . "." . $parts['extention'];
  while (file_exists(UPLOAD_DIR . $name)) {
      $i++;
      $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
  }

  // preserve file from temporary directory
  $success = move_uploaded_file($profil_billede["tmp_name"],
      UPLOAD_DIR . $new_name);
  if (!$success) {
      echo "<p>Kan ikke gemme filen.</p>";
      exit;
  } else {
    $path_to_file = UPLOAD_DIR . $new_name;
    if(empty($path_to_file)) {
      $path_to_file = 'uploads/placeholder-user.png';
    }
  // set proper permissions on the new file
    chmod(UPLOAD_DIR . $new_name, 0644);
  }
}
