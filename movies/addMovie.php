<?php
    require('../templates/header.php');

    if($_POST) {
        // var_dump($_POST);
        extract($_POST);
        $movieErrors = array();

        if (empty($title)) {
          array_push($movieErrors, 'Please enter a movie title');
        } else if (strlen($title) < 5) {
          array_push($movieErrors, 'The title should have at least 5 characters');
        }  else if (strlen($title) > 1000) {
          array_push($movieErrors, 'The title can be no more than 1000 characters');
        }

        if (empty($director)) {
          array_push($movieErrors, 'Please enter a movie director');
        } else if (strlen($director) < 6) {
          array_push($movieErrors, 'The movie title should have a least 6 characters');
        }  else if (strlen($director) > 100) {
          array_push($movieErrors, 'The movie director name can be no more than 100 characters');
        }

        if (empty($year)) {
            array_push($movieErrors, 'State the year that the movie was released');
        } else if (strlen($year) < 4) {
            array_push($movieErrors, 'The year must have 4 digits');
        } else if (strlen($year) > 4) {
            array_push($movieErrors, 'The year can\'t be more than 4 digits');
        }

        if (empty($description)) {
            array_push($movieErrors, 'Enter a description');
        } else if (strlen($description) > 65535) {
            array_push($movieErrors, 'Description has to be at least ');
        } else if(strlen($description) < 15) {
            array_push($movieErrors, 'Description must be at least 15 characters long');
        }

        if ($movieErrors > 1) {
            var_dump($movieErrors);
        }
    }
?>

        <div class="row mb-2">
            <div class="col">
                <h1>Add New Movie</h1>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="alert alert-danger pb-0" role="alert">
                    <ul>
                        <li>Error Message</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="title">Movie Title</label>
                      <input type="text" class="form-control" name="title"  placeholder="Enter movie title" value="">
                    </div>

                    <div class="form-group author-group">
                      <label for="author">Director</label>
                      <input type="text" autocomplete="off" class="form-control"  name="director" placeholder="Enter movies director" value="">
                    </div>

                    <div class="form-group author-group">
                      <label for="author">Year Released</label>
                      <input type="number" autocomplete="off" class="form-control"  name="year" placeholder="Enter movie's year Released" value="">
                    </div>

                    <div class="form-group">
                      <label for="description">Movie Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the movie"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="file">Upload an Image</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>

                    <button type="submit" class="btn btn-outline-info btn-block">Submit</button>
                </form>
            </div>
        </div>

    </div>

    <?php require('../templates/script.php'); ?>
