<?php
    // var_dump($_POST);
    $id = $_POST['bookID'];

    require '../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..'); // where is the env file?
    $dotenv->load(); // load the env file

    require('../templates/connection.php');

    $sql = "DELETE FROM `books` WHERE _id = $id";
    $result = mysqli_query($dbc, $sql);
    if ($result && mysqli_affected_rows($dbc) > 0) {
        header('Location: ../books/allBooks.php');
    } else if ($result && mysql_affected_rows($dbc) === 0) {
        header('Location: ../errors/404.php');
    } else {
        die('Can\'t delete book');
    }
