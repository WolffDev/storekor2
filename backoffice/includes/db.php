<?php
    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "4100";
    $db['db_name'] = "storekor";

    foreach($db as $key => $value) {
        define(strtoupper($key), $value);
    }

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn) {
      // echo "We are connected";
    } else {
        echo mysqli_error($conn);
    }
?>
