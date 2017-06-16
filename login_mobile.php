<?php include "includes/header.php"; ?>
<div class="container mobil-login">
  <div class="row">
    <a href="index.php">
    <div class="col s12">
      <p>Tilbage til forsiden<i class="material-icons left">arrow_back</i></p>
    </div>
    </a>
  </div>
  <div class="row">
    <form class="col s12 center" action="backoffice/includes/login.php" method="post">
      <div class="row">
        <div class="col s1"></div>
        <div class="input-field col s10">
          <input id="username" type="text" class="validate" name="username">
          <label for="username">Email</label>
        </div>
        <div class="col s1"></div>
      </div>
      <div class="row center">
        <div class="col s1"></div>
        <div class="input-field col s10">
          <input id="password" type="password" class="validate" name="password">
          <label for="password">Adgangskode</label>
        </div>
        <div class="col s1"></div>
      </div>
      <div class="row center">
        <button class="btn waves-effect waves-light" type="submit" name="login">Login<i class="material-icons right">send</i></button>
      </div>
    </form>
  </div>
</div>

<?php include "includes/footer.php"; ?>
