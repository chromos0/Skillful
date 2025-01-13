<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "progetto_personale";

    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$connection) {
        die("Errore nella connessione: ". mysqli_connect_error());
    } else {
        echo '<script>console.log("Connesso al DB! '.mysqli_get_host_info($connection).'")</script>';
    }