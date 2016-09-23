<?php
  if(isset($_POST['send_mail'])) {
    $to_mail = escape($_POST['to_mail']);
    $from_mail = escape($_POST['from_mail']);
    $subject = escape($_POST['subject']);
    $from_user = escape($_POST['from_user']);
    $message = escape($_POST['message']);

    mail_utf8($to_mail, $from_user, $from_mail, $subject, $message);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>mail test</title>
  </head>
  <body>
    <form method="post">
      <input type="text" name="to_mail" value="" placeholder="to_mail">
      <br>
      <input type="text" name="from_mail" value="" placeholder="from_mail">
      <br>
      <input type="text" name="subject" value="" placeholder="subject">
      <br>
      <input type="text" name="from_user" value="" placeholder="from_user">
      <br>
      <input type="text" name="message" value="" placeholder="message">
      <br>
      <input type="submit" name="send_mail" value="Send mail">
    </form>
  </body>
</html>
