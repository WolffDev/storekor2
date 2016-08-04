<div class="navbar-fixed">
  <nav role="navigation" class="white">
    <div class="nav-wrapper container"><a id="logo-container" href="./" class="brand-logo"><img src="img/logo.svg"/></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="./">Forside</a></li>
        <li><a href="./optagelse.php">Optagelse</a></li>
        <li><a href="#">Dirigent</a></li>
        <li><a href="#" data-activates="dropdown1" class="dropdown-button">Om Os<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a href="./#kontakt">Kontakt</a></li>
        <?php if($_SESSION['logged_in'] == true) { ?>
          <li><a href="./backoffice/">Admin</a></li>
          <li><a href="./backoffice/includes/logout.php">Logud</a></li>
        <?php } ?>
        <?php if($_SESSION['logged_in'] == null) { ?>
          <li>
            <span class="login-pin">
              <a href="#" id="login-trigger">Login</a>
              <div id="login-content">
                <form class="" action="./backoffice/includes/login.php" method="post">
                  <div class="row">
                    <div class="input-field col">
                      <input type="text" name="username" value="" id="username" required>
                      <label for="username">Email</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col">
                      <input type="password" name="password" value="" id="login-password" required>
                      <label for="login-password">Adganskode</label>
                    </div>
                  </div>
                  <div class="row center">
                    <button class="btn waves-effect waves-light" type="submit" name="login">Login<i class="material-icons right">send</i></button>
                  </div>
                </form>
              </div>
            </span>
          </li>
        <?php } ?>
      </ul>



      <div id="dropdown1" class="dropdown-content">
        <ul>
          <li><a href="#">Om Storekoret</a></li>
          <li><a href="#">Bestyrelsen</a></li>
          <li><a href="#">Historie</a></li>
          <li class="divider"></li>
          <li><a href="#">PR</a></li>
        </ul>
      </div>
      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Forside</a></li>
        <li><a href="./optagelse.php">Optagelse</a></li>
        <li><a href="#">Koncerter</a></li>
        <li><a href="#">Dirigent</a></li>
        <li><a href="#!">Om Storekoret</a></li>
        <li><a href="#!">Bestyrelsen</a></li>
        <li><a href="#!">Historie</a></li>
        <li><a href="#!">PR</a></li>
        <li><a href="./#kontakt">Kontakt</a></li>
        <li><a href="#">Login</a></li>
      </ul><a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
</div>
