<?php
  
  $user_id = $_SESSION['user_id'];
?>
<div class="navbar">
  <nav role="navigation" class="white">
    <div class="nav-wrapper">
      <ul class="right hide-on-small-only">
        <li><a href="../"><i class="material-icons left">home</i>Forside</a></li>
        <li><a href="medlemmer.php?action=profile&id=<?php echo $user_id; ?>"><?php echo ucfirst($_SESSION['fornavn']); ?><i class="material-icons left">account_box</i></a></li>
        <li><a href="includes/logout.php">Logud</a></li>
      </ul>
      <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
      </div>
      <ul id="nav-mobile" class="side-nav fixed">
        <ul class="">
          <li class="hide-on-med-and-up"><a href="../"><i class="material-icons left">home</i>Forside</a></li>
          <li><a href="./"><i class="material-icons left">dashboard</i>Oversigt</a></li>
          <?php
          if ($_SESSION['auth'] < 3) {
          ?>
            <li><a href="medlemmer.php?action=view_all"><i class="material-icons left">supervisor_account</i>Medlemmer</a></li>
            <li><a href="medlemmer.php?action=add_member"><i class="material-icons left">person_add</i>Tilføj medlem</a></li>
          <?php } else { ?>
            <li><a href="medlemmer.php?action=view_all_single"><i class="material-icons left">supervisor_account</i>Medlemmer</a></li>
          <?php } ?>
          <?php
          if ($_SESSION['auth'] < 4) {
          ?>
            <li><a href="#"><i class="material-icons left">accessibility</i>Dirigent</a></li>
          <?php } ?>
          <li><a href="index.php?action=ovegange"><i class="material-icons left">music_note</i>Korlender</a></li>
          <?php
          if ($_SESSION['auth'] < 4) {
          ?>
          <li><a href="index.php?action=afbud"><i class="material-icons left">alarm_off</i>Afbud</a></li>
          <?php } ?>
          <ul class="div hide-on-med-and-up">
            <li><a href="medlemmer.php?action=profile&bruger=<?php echo $user_id; ?>"><?php echo ucfirst($_SESSION['fornavn']); ?><i class="material-icons left">account_box</i></a></li>
            <li><a href="includes/logout.php"><i class="material-icons left">power_settings_new</i>Logud</a></li>
          </ul>
        </ul>
      </ul>
    </div>
  </nav>
</div>
