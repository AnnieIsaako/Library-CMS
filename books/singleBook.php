<?php
    require('../templates/header.php');
    $bookID = $_GET['id'];
    $sql = "SELECT * FROM `books` WHERE _id = $bookID"; // select all rows that has the same _id of bookID
    $result = mysqli_query($dbc, $sql);

    if($result && mysqli_affected_rows($dbc) > 0) { // you have run the query and you've got a row
        $singleBook = mysqli_fetch_array($result, MYSQLI_ASSOC); // fetch one row
    } else if ($result && mysqli_affected_rows($dbc) === 0) { // if query was successful, but doesn't get anything back
        header('Location: ../error/404.php');
    } else {
        die('something went wrong with getting the book');
    }
?>

        <div class="row mb-2">
            <div class="col">
                <h1><?php echo $singleBook['title']; ?></h1>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <a class="btn btn-outline-primary" href="">Edit</a>
                <button class="btn btn-outline-danger" type="button" name="button" data-toggle="modal" data-target="#confirmModal">Delete</button>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-sm-4 align-self-center">
                <img class="img-fluid" src="images/HarryPotter1.jpg" alt="">
            </div>
            <div class="col-12 col-sm-8 align-self-center">
                <h3><?php echo $singleBook['title']; ?></h3>
                <h4><?php echo $singleBook['author_id']; ?></h4>
                <p><?php echo $singleBook['year']; ?></p>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <p><?php echo $singleBook['description']; ?></p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete <?php echo $singleBook['title']; ?>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>

    <?php require('../templates/script.php'); ?>
