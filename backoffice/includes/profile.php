<?php
if (!isset($_SESSION['logged_in']) || empty($_SESSION['logged_in']) || $_SESSION['auth'] > 4 || $_SESSION['user_id'] != $_GET['id']){
  header("Location: index.php");
  exit();
}
?>

<?php
  if(isset($_GET['id'])) {
    $user_id = escape($_GET['id']);
  } else {
    header("Location: ../index.php");
  }

  $query = "SELECT * FROM medlemmer WHERE id = $user_id";
  $select_users_query = mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($select_users_query)) {
        $brugernavn     = $row['brugernavn'];
        $fornavn        = $row['fornavn'];
        $efternavn      = $row['efternavn'];
        $adresse        = $row['adresse'];
        $postnr         = $row['postnr'];
        $bynavn         = $row['bynavn'];
        $email          = $row['email'];
        $telefon        = $row['telefon'];
        $alder          = $row['alder'];
        $stemme         = $row['stemme'];
        $erfaring       = $row['erfaring'];
        $kor_type       = $row['kor_type'];
        $job            = $row['job'];
        $relate         = $row['relate'];
        $persona        = $row['persona'];
        $bruger_rolle   = $row['bruger_rolle'];
        $bruger_status  = $row['bruger_status'];
        $app_status     = $row['app_status'];
        $db_profil_billede = $row['profil_billede'];
        $changed_pass   = $row['changed_pass'];
    }

?>

<?php
  if(isset($_POST['edit_profile'])) {
    $user_id = escape($_GET['id']);
    $fornavn = escape($_POST['fornavn']);
    $efternavn = escape($_POST['efternavn']);
    $adresse = escape($_POST['adresse']);
    $postnr = escape($_POST['postnr']);
    $bynavn = escape($_POST['bynavn']);
    $email = escape($_POST['email']);
    $telefon = escape($_POST['telefon']);
    // $brugernavn = substr($fornavn,0,2) . substr($efternavn,0,2) . substr($telefon,4,2);
    $alder = escape($_POST['alder']);
    $stemme = escape($_POST['stemme']);
    $erfaring = escape($_POST['erfaring']);
    $kor_type = escape($_POST['kor_type']);
    $job = escape($_POST['job']);
    $relate = escape($_POST['relate']);
    $persona = escape($_POST['persona']);
    if($user_id == 1) {
      $brugernavn = 'admin';
    } else {
      $brugernavn = $email;
    }


    $tid = strtotime($alder);
    // $alder = date('d-m/Y',$tid);
    // omregner alderen fra database til et tal.
    $alder_nu = floor(((time()- $tid)  /(3600 * 24 * 365)));


    if(!empty($_FILES['profil_billede']['name'])) {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["profil_billede"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      if(isset($_POST["edit_profile"])) {
          $check = getimagesize($_FILES["profil_billede"]["tmp_name"]);
          if($check == false) {
              $profil_billede = 'uploads/placeholder-user.png';
              $file_up_msg = urlencode("false");
              $uploadOk = 0;
          }
      }
      // Check if file already exists
      if (file_exists($target_file)) {
          $profil_billede = $target_dir . mt_rand(10000,99999) . basename($_FILES["profil_billede"]["name"]);
          $uploadOk = 1;
      }
      // Check file size
      if ($_FILES["profil_billede"]["size"] > 200000) {
          $profil_billede = $db_profil_billede;
          $file_up_msg = urlencode("<p>Profil billede blev ikke opdateret.<br>Filen du prøver at uploade fylder for meget - maks 200kb.<br>Læs vilkårene for upload af profil billede og prøv igen.");

          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $profil_billede = $db_profil_billede;
          $uploadOk = 0;
          $file_up_msg = urlencode("false");
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          $profil_billede = $db_profil_billede;
          $file_up = 'false';
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["profil_billede"]["tmp_name"], $profil_billede)) {
            $profil_billede = $profil_billede;

        } else {
            echo "Sorry, there was an error uploading your file.";
            $profil_billede = $db_profil_billede;
        }
      }
    } else {
      $profil_billede = $db_profil_billede;
      $file_up = '';
    }

    if(!empty($fornavn) && !empty($email) && !empty($efternavn)) {
      $query = "UPDATE medlemmer SET ";
      $query .="brugernavn = '{$brugernavn}', ";
      $query .="fornavn = '{$fornavn}', ";
      $query .="efternavn = '{$efternavn}', ";
      $query .="adresse = '{$adresse}', ";
      $query .="postnr = '{$postnr}', ";
      $query .="email = '{$email}', ";
      $query .="telefon = '{$telefon}', ";
      $query .="job = '{$job}', ";
      $query .="profil_billede = '{$profil_billede}' ";
      $query .="WHERE id = {$user_id} ";

      $create_user_query = mysqli_query($conn, $query);
      if(!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['new_validate_password'])) {

        $old_password = escape($_POST['old_password']);
        $new_password = escape($_POST['new_password']);
        $new_validate_password = escape($_POST['new_validate_password']);
        if($new_password !== $new_validate_password) {
          $message = urlencode("password_mismatch");
          header("Location: medlemmer.php?action=profile&id=$user_id&message=".$message);
          die;
        } else {

          $query = "SELECT * FROM medlemmer WHERE brugernavn = '{$brugernavn}'";
          $select_user_query = mysqli_query($conn, $query);
          if(!$select_user_query) {
            die("Query failed: ". mysqli_error($conn));
          } else {
            while($row = mysqli_fetch_array($select_user_query)) {
              $db_password = $row['password'];
              $changed_pass = $row['changed_pass'];
            }
            if(password_verify($old_password, $db_password)) {
              $new_password = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 10));

              $query_password_update = "UPDATE medlemmer SET password = '{$new_password}', changed_pass = '1' WHERE id = {$user_id}";
              $insert_password = mysqli_query($conn, $query_password_update);
              $password_changed = 'true';
            } else {
              $message = urlencode("password_wrong");
              header("Location: medlemmer.php?action=profile&id=".$user_id."&message=".$message);
              die;
            }
          }
        }
      }
      if(!$create_user_query) {
        die("Query Failed123: " . mysqli_error($conn));
      } else {
        if($password_changed == 'true') {
          $message = urlencode("success_edit_profile_password");
          $edit_name = urlencode($fornavn);
          header("Location: index.php?action=dashboard&message=" . $message . "&edit_name=" . $edit_name."&file_up=".$file_up."&file_up_msg=".$file_up_msg);
          die;
        } else {
          $message = urlencode("success_edit_profile");
          $edit_name = urlencode($fornavn);
          header("Location: index.php?action=dashboard&message=" . $message . "&edit_name=" . $edit_name."&file_up=".$file_up."&file_up_msg=".$file_up_msg);
          die;
        }
      }
    } else {
      $update_fail = "Du mangler at udfylde nogle felter der er påkrævet.<br>Udfyld venligst alle de vigtige felter.";
      $fornavn = escape($_POST['fornavn']);
      $efternavn = escape($_POST['efternavn']);
      $adresse = escape($_POST['adresse']);
      $postnr = escape($_POST['postnr']);
      $bynavn = escape($_POST['bynavn']);
      $email = escape($_POST['email']);
      $telefon = escape($_POST['telefon']);
      $job = escape($_POST['job']);
      mysqli_close($conn);
    }
  }
?>

<div class="container">
  <section>
    <div class="row">
      <?php
        if(isset($update_fail)) {
          echo "<div class='col s12'>";
          echo "<p class='red-text'>";
          echo $update_fail;
          echo "</p>";
          echo "</div>";
        }
      ?>

    </div>
  </section>

  <section>
    <?php
      if(isset($_GET['message']) && $_GET['message'] === 'password_mismatch') {
        ?>
          <div class="row">
            <div class="col s12 teal white-text">
              <p>
                De to nye adgangskoder du har indtastet er ikke ens.<br>Prøv igen.
              </p>
            </div>
          </div>
        <?php
      }

      if(isset($_GET['message']) && $_GET['message'] === 'password_wrong') {
        ?>
          <div class="row">
            <div class="col s12 teal white-text">
              <p>
                Din nuværrende adganskode du har indtastet er forkert - prøv igen.<br>Hvis du efter flere forsøg stadig ikke kan huske din nuværrende adganskode, så få tilsendt et nyt.<br>LINK HER!!!
              </p>
            </div>
          </div>
        <?php
      }
    ?>
    <?php if($changed_pass == 0) { ?>
      <div class="row">
        <div class="col s12 red white-text">
          <p class="center">
            Du har endnu ikke ændret din adgangskode.<br>Gør venligst dette nederst på siden nu.
          </p>
        </div>
      </div>
    <?php } ?>


    
    <div class="row">
      <div class="col s12">
        <p>Her kan du redigere dine personlige informationer.<br>Husk at holde det opdateret, hvis du fx flytter adresse, skifter telefon nummer eller email.<br>Din email er også dit login, så hvis du skifter den, så bliver dit login også ændret til næste gang du vil logge ind.</p>
      </div>
      <form class="col s12" action="" method="post" autocomplete="on" id="profile_edit" enctype="multipart/form-data">
        <div class="row">
          <div class="input-field col s12 m6">
            <input id="fornavn" required="required" type="text" class="validate" name="fornavn" value="<?php if(isset($fornavn)) {echo $fornavn;} ?>">
            <label for="fornavn">Fornavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="efternavn" required="required" type="text" class="validate" name="efternavn" value="<?php if(isset($efternavn)){echo $efternavn;} ?>">
            <label for="efternavn">Efternavn</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="email" type="email" class="validate" name="email" value="<?php if(isset($email)){echo $email;} ?>">
            <label for="email">Email</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="telefon" required="required" type="tel" class="validate" name="telefon" value="<?php if(isset($telefon)){echo $telefon;} ?>">
            <label for="telefon">Telefon nummer</label>
          </div>
          <div class="input-field col s6">
            <input id="adresse" required="required" type="text" class="validate" name="adresse" value="<?php if(isset($adresse)){echo $adresse;} ?>">
            <label for="adresse">Adresse</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="postnr" required="required" type="text" class="validate" name="postnr" value="<?php if(isset($postnr)){echo $postnr;} ?>">
            <label for="postnr">Postnummer</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="bynavn" required="required" type="text" class="validate" name="bynavn" value="<?php if(isset($bynavn)){echo $bynavn;} ?>">
            <label for="bynavn">By</label>
          </div>

          <div class="input-field col s12 m6">
            <select name="job">
              <option value="Studerende" <?php if($job == '') {echo "selected='selected'";} ?>>Studerende</option>

              <option value="Selvstændig"<?php if($job == 'Selvstændig') {echo "selected='selected'";} ?>>Selvstændig</option>

              <option value="I arbejde"<?php if($job == 'I arbejde') {echo "selected='selected'";} ?>>I arbejde</option>

              <option value="Ledig"<?php if($job == 'Ledig') {echo "selected='selected'";} ?>>Ledig</option>

              <option value="Studerende ved SDU"<?php if($job == 'Studerende ved SDU') {echo "selected='selected'";} ?>>Studerende ved SDU</option>

              <option value="Arbejder ved SDU"<?php if($job == 'Arbejder ved SDU') {echo "selected='selected'";} ?>>Arbejder ved SDU</option>

              <option value="Pensionist"<?php if($job == 'Pensionist') {echo "selected='selected'";} ?>>Pensionist</option>

              <option value="Ønsker ikke at oplyse"<?php if($job == 'Ønsker ikke at oplyse') {echo "selected='selected'";} ?>>Ønsker ikke at oplyse</option>

            </select>
            <label>Beskæftigelse?</label>
          </div>
        </div>

        <div class="divider"></div>

        <div class="row">
          <div class="col s12 m6">
            <p>
              Når du uploader dit profil billede, skal følgende krav være opfyldt:
              <br>
              Billedet skal være et .jpg, .jpeg, .png eller .gif fil.
              <br>
              Billedet må maks fylde 200kb.
            </p>
          </div>

          <div class="file-field input-field col s12 m6">
            <div class="btn">
              <span>Billede</span>
              <input type="file" name="profil_billede" value="<?php if(isset($db_profil_billede)){echo $db_profil_billede;} ?>">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" placeholder="<?php echo substr($db_profil_billede, 8); ?>" type="text">
            </div>
          </div>
        </div>

        <div class="divider"></div>

        <div class="row">
          <div class="col s12 m6">
            <p>
              Hvis du vil ændre din adgangskode, så indtast din nuværrende og derefter den nye.
            </p>
          </div>
          <div class="input-field col s12 m6">
            <input id="old_password" type="password" class="validate" name="old_password">
            <label for="old_password">Indtast din gamle adgangskode</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col 12 m6">
            <input id="new_password" type="password" class="validate" name="new_password">
            <label for="new_password">Indtast ny adgangskode</label>
          </div>
          <div class="input-field col 12 m6">
            <input id="new_validate_password" type="password" class="validate" name="new_validate_password">
            <label for="new_validate_password">Gentag ny adgangskode</label>
          </div>
        </div>

      <div class="row center">
        <button class="btn waves-effect waves-light" type="submit" name="edit_profile">Opdater medlem<i class="material-icons right">send</i>
        </button>
      </div>
    </form>
  </div>
</section>

</div>
