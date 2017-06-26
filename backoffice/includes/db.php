<?php
    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "4100dk";
    $db['db_name'] = "webstorekoret";

    foreach($db as $key => $value) {
        define(strtoupper($key), $value);
    }
    mysql_set_charset('utf8');

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn) {
      // echo "We are connected";
    } else {
        echo mysqli_error($conn);
    }
    setlocale(LC_ALL, "da_DK.UTF-8", "Danish_Denmark.1252", "danish_denmark", "danish", "dk_DK@euro");
?>
