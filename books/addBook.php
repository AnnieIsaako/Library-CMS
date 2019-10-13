<?php
    require('../templates/header.php');


    if($_POST) { // if form is submitted
        // var_dump($_POST);
        // var_dump($_POST['title']);
        // var_dump('You have submitted a book');

        extract($_POST); // taking the post array, all input fields that has a name will be added to the post array, reads array, creates a variable for each of the names (which are keys).
        // var_dump($bkTitle);
        // var_dump($author);
        // var_dump($description);

        $errors = array();

        if(empty($bkTitle)) {
            // var_dump('Fill out the title field please');
            array_push($errors, 'Please enter a book title');
        } else if (strlen($bkTitle) < 5) {
            array_push($errors, 'Please enter a book title with at least 5 characters');
        } else if (strlen($bkTitle) > 100) {
            array_push($errors, 'Please enter a book title that has less than 100 characters');
        }

        if (empty($author)) {
            // var_dump('Fill out the author field please');
            array_push($errors, 'Please state the author');
        } else if (strlen($author) < 5) {
            // var_dump('the length must be at least 5');
            array_push($errors, 'Please enter an author that is at least 5 characters');
        } else if (strlen($author) > 100) {
            // var_dump('the length must be less than 100');
            array_push($errors, 'Please enter an author that has less than 100 characters');
        }

        if (empty($year)) {
            // var_dump('Fill out the author field please');
            array_push($errors, 'Please state the year');
        } else if (strlen($year) > 4) {
            // var_dump('the length must be less than 100');
            array_push($errors, 'Year can only be 4 numbers');
        }

        if (empty($description)) {
            array_push($errors, 'Please enter a book description');
        } else if (strlen($description) < 10) {
            array_push($errors, 'The description length must be at least 10 characters');
        } else if(strlen($description) > 65535) {
            array_push($errors, 'Description must have less than 65535 characters');
        }

        if(empty($errors)) { // if there are no errors SECURITY
            $safeBkTitle = mysqli_real_escape_string($dbc, $bkTitle); // safe version - turning everything into a string version to prevent sql injection
            $safeYear = mysqli_real_escape_string($dbc, $year);
            $safeAuthor = mysqli_real_escape_string($dbc, $author);
            $safeDescription = mysqli_real_escape_string($dbc, $description);



            $findSql = "SELECT * FROM `authors` WHERE name = '$safeAuthor'";
            $findResult = mysqli_query($dbc, $findSql);
            if ($findResult && mysqli_affected_rows($dbc) > 0) {
                $sql = "INSERT INTO `authors`(`name`) VALUES ('$author')";
                $result = mysqli_query($dbc, $sql);
                if($result && mysqli_affected_rows($dbc) > 0) {
                    $authorID = $dbc->insert_id; // gives us the id of last inserted row
                } else {
                    die('couldnt add author');
                }
            } else if ($findResult && mysqli_affected_rows($dbc) > 0){

            } else {
                die('Couldn\'t find an author.');
            }


            die();
            $booksSql= "INSERT INTO `books`(`title`, `description`, `year`, `author_id`) VALUES ('$safeBkTitle', '$safeDescription', $safeYear, $authorID)";
            $booksResult = mysqli_query($dbc, $booksSql);
            if($booksResult && mysqli_affected_rows($dbc) > 0) { // if successful query and something happened
                $bookID = $dbc->insert_id;
                header('Location:singleBook.php?id='.$bookID);
            } else {
                die('There is something wrong with your sql query');
            }
        }

    }

?>

        <div class="row mb-2">
            <div class="col">
                <h1>Add New Book</h1>
            </div>
        </div>

        <?php if($_POST && !empty($errors)): ?>
            <div class="row mb-2">
                <div class="col">
                    <div class="alert alert-danger pb-0" role="alert">
                        <ul>
                            <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row mb-2">
            <div class="col">
                <form action="./books/addBook.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="bkTitle">Book Title</label>
                      <input type="text" class="form-control" name="bkTitle"  placeholder="Enter book title" value="<?php if($_POST) { echo $bkTitle; }?>">
                    </div>

                    <div class="form-group author-group">
                      <label for="author">Author</label>
                      <input type="text" autocomplete="off" class="form-control"  name="author" placeholder="Enter books author" value="<?php if($_POST) { echo $author; }?>">
                    </div>

                    <div class="form-group author-group">
                      <label for="year">Year</label>
                      <input type="number" autocomplete="off" class="form-control"  name="year" placeholder="<?php echo date('Y'); ?>" value="<?php if($_POST) { echo $year; }?>">
                    </div>

                    <div class="form-group">
                      <label for="description">Book Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the book"><?php if($_POST) { echo $description; }?></textarea>
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
