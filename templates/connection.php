<?php
    date_default_timezone_set('Pacific/Auckland');
    // $dbc = mysqli_connect(host, username, password, table); // connect to mysql
    $dbc = mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_TABLE'));

    if($dbc) {
        // var_dump('we are connected');
        $dbc->set_charset('utf-8mb4');
    } else {
        die('Couldn\'t connect to the db, check your env file. There is an example of the env file called "example.env" Please duplicate and fill in the variables, or go to the read me.');
    }



?>
