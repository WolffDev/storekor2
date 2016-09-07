<div class="container div">
  <?php
    if(isset($_GET['action']) && $_GET['action'] == 'afbud_detail') {
      echo $event_id = escape($_GET['event']);
    }
  ?>
</div>
