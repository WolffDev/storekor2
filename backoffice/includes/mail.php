<?php
if(isset($_POST['send_mail_deny'])) {
  $mail_name = $_POST['mail_name'];
  $mail_email = $_POST['mail_email'];
  $message_mail = "Kære " . $mail_name . ",<br>";
  $message_mail .="<br>Vi har gennemgået din ansøgning og vi ser os nødsaget til at afvise din ansøgning.<br><br>";
  $message_add = escape(nl2br($_POST['more_text']));
  $message_end = "<br><br>Hilsen,<br>Korbestyrelsen";


  // $to_mail = $mail_name;
  $to_mail = 'davidbkwolff@gmail.com';
  $from_mail = 'no-reply@storekor.dk';
  $subject = 'Afvisning af ansøgning til Storekoret';
  $from_user = 'Korbestyrelsen';
  $message_add = str_replace('\r\n', '', $message_add);
  $msg = $message_mail . $message_add . $message_end;

  mail_utf8($to_mail, $from_user, $from_mail, $subject, $msg);
  $message = urlencode('new_app_deny');
  header("Location: index.php?action=dashboard&message=" . $message . "");

}

if(isset($_POST['send_mail_approved'])) {
  $mail_name = $_POST['mail_name'];
  $mail_email = $_POST['mail_email'];
  $message_mail = "Kære " . $mail_name . ",<br>";
  $message_mail .="<br>Vi har gennemgået din ansøgning og vi vil gerne byde dit velkommen til Storekoret.<br><br>";
  $message_add = escape(nl2br($_POST['more_text']));
  $message_end = "<br><br>Hilsen,<br>Korbestyrelsen";


  // $to_mail = $mail_name;
  $to_mail = 'davidbkwolff@gmail.com';
  $from_mail = 'no-reply@storekor.dk';
  $subject = 'Godkendelse af ansøgning til Storekoret';
  $from_user = 'Korbestyrelsen';
  $message_add = str_replace('\r\n', '', $message_add);
  $msg = $message_mail . $message_add . $message_end;

  mail_utf8($to_mail, $from_user, $from_mail, $subject, $msg);
  $message = urlencode('new_app_approved');
  header("Location: index.php?action=dashboard&message=" . $message . "");
}

?>
<div class="container content-container">
  <?php if(isset($_GET['app']) && $_GET['app'] == 'approved') {
    $mail_name = escape($_GET['name']);
    $mail_email = escape($_GET['mail']);
    ?>
    <div class="row">
      <div  class="flow-text col s12 m4">
        <p>
          Der vil blive afsendt en standard mail til ansøgerender fortæller at ansøgningen er blevet GODKENDT.
        </p>
        <p>
          Her kan du skrive flere detaljer til ansøgeren, med vigtive relevante oplysninger, der ikke indgår i standard mailen.
        </p>
      </div>

      <div class="col s12 m8">
        <form method="post">
          <input type="hidden" name="mail_name" value="<?php echo $mail_name;?>">
          <input type="hidden" name="mail_email" value="<?php echo $mail_email;?>">

          <textarea id="icon_prefix2" class="materialize-textarea" placeholder="Indtast ekstra tekst, som vil blive sendt i mailen til den nye ansøger" name="more_text"></textarea>
          <button class="btn waves-effect waves-light" type="submit" name="send_mail_approved">Send mail og godkend ansøger
            <i class="material-icons right">send</i>
          </button>
          <p>
            Standard mail der bliver afsendt:<br>
            "Vi har gennemgået din ansøgning og vi vil gerne byde dit velkommen til Storekoret."
          </p>
        </form>
      </div>
    </div>
  <?php } ?>

  <?php if(isset($_GET['app']) && $_GET['app'] == 'deny') {
    $mail_name = escape($_GET['name']);
    $mail_email = escape($_GET['mail']);
    ?>
    <div class="row">
      <div  class="flow-text col s12 m4">
        <p>
          Der vil blive afsendt en standard mail til ansøgerender fortæller at ansøgningen er blevet AFVIST.
        </p>
        <p>
          Her kan du skrive flere detaljer til ansøgeren, om hvorfor ansøgningen blev afvist.
        </p>
      </div>

      <div class="col s12 m8">
        <form method="post">
          <input type="hidden" name="mail_name" value="<?php echo $mail_name;?>">
          <input type="hidden" name="mail_email" value="<?php echo $mail_email;?>">

          <textarea id="icon_prefix2" class="materialize-textarea" placeholder="Indtast ekstra tekst, som vil blive sendt i mailen til den nye ansøger" name="more_text"></textarea>

          <button class="btn waves-effect waves-light red darken-3" name="send_mail_deny" type="submit">Send mail og afvis ansøger
            <i class="material-icons right">send</i>
          </button>
          <p>
            Standard mail der bliver afsendt:<br>
            "Vi har gennemgået din ansøgning og vi ser os nødsaget til at afvise din ansøgning."
          </p>
        </form>
      </div>
    </div>
  <?php } ?>

</div>
