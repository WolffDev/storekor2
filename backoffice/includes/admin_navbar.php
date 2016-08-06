<div class="navbar">
  <nav role="navigation" class="white">
    <div class="nav-wrapper">
      <ul class="right hide-on-small-only">
        <li><a href="../">Forside</a></li>
        <ul class="right hide-on-small-only">
          <li><a class="dropdown-button" href="#!" data-activates="dropdown-profile"><?php echo ucfirst($_SESSION['fornavn']); ?><i class="material-icons left">account_box</i><i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>

        <ul id="dropdown-profile" class="dropdown-content">
          <li><a href="#">Rediger Profil</a></li>
          <li><a href="#">...</a></li>
          <li><a href="includes/logout.php">Logud</a></li>
        </ul>

      </ul>
      <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
      </div>
      <ul id="nav-mobile" class="side-nav fixed">
        <ul class="collapsible collapsible-accordion">
          <li><a href="./"><i class="material-icons left">home</i>Status oversigt</a></li>
          <li><a href="#!" class="collapsible-header  waves-effect waves-teal"><i class="material-icons left">account_box</i>Alle Medlemmer</a>
            <div class="div collapsible-body">
              <ul>
                <li><a href="medlemmer.php?action=view_all"><i class="material-icons left">supervisor_account</i>Se alle medlemmer</a></li>
                <li><a href="medlemmer.php?action=add_member"><i class="material-icons left">person_add</i>Tilføj nyt medlem</a></li>
              </ul>
            </div>

          </li>
          <li><a href="#">Dirigent</a></li>
          <li><a href="#!">Om Storekoret</a></li>
        </ul>
      </ul>
    </div>
  </nav>
</div>
