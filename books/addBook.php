<?php
    require('../templates/header.php');

    if(isset($_GET['id'])) { // does it exist
        // var_dump('We are editing a book');
        $pageTitle = 'Edit Book';
        $bookID = $_GET['id'];
        $sql = "SELECT books.`_id` as bookID, `title`, `description`, `year`, authors.name as author FROM `books` INNER JOIN authors ON books.author_id = authors._id WHERE books._id = $bookID";
        $result = mysqli_query($dbc, $sql);

        if($result && mysqli_affected_rows($dbc) > 0) {
            $singleBook = mysqli_fetch_array($result, MYSQLI_ASSOC);
            extract($singleBook);
        } else if ($result && mysqli_affected_rows($dbc) === 0) {
            header('Location: ../error/404.php');
        } else {
            die('something went wrong with editing the book');
        }
    } else {
        // var_dump('We are adding a new book');
        $pageTitle = 'Add New Book';
    }

    if($_POST) { // if form is submitted
        // var_dump($_POST);
        // var_dump($_POST['title']);
        // var_dump('You have submitted a book');

        extract($_POST); // taking the post array, all input fields that has a name will be added to the post array, reads array, creates a variable for each of the names (which are keys).
        // var_dump($title);
        // var_dump($author);
        // var_dump($description);

        $errors = array();

        if(empty($title)) {
            // var_dump('Fill out the title field please');
            array_push($errors, 'Please enter a book title');
        } else if (strlen($title) < 5) {
            array_push($errors, 'Please enter a book title with at least 5 characters');
        } else if (strlen($title) > 100) {
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
            $safetitle = mysqli_real_escape_string($dbc, $title); // safe version - turning everything into a string version to prevent sql injection
            $safeYear = mysqli_real_escape_string($dbc, $year);
            $safeAuthor = mysqli_real_escape_string($dbc, $author);
            $safeDescription = mysqli_real_escape_string($dbc, $description);


            $findSql = "SELECT * FROM `authors` WHERE name = '$safeAuthor'";
            $findResult = mysqli_query($dbc, $findSql);
            if ($findResult && mysqli_affected_rows($dbc) > 0) {
                $foundAuthor = mysqli_fetch_array($findResult, MYSQLI_ASSOC); // convert it into a way that we can read it
                $authorID = $foundAuthor['_id'];
            } else if ($findResult && mysqli_affected_rows($dbc) === 0){
                $sql = "INSERT INTO `authors`(`name`) VALUES ('$author')";
                $result = mysqli_query($dbc, $sql);
                if($result && mysqli_affected_rows($dbc) > 0) {
                    $authorID = $dbc->insert_id; // gives us the id of last inserted row
                } else {
                    die('couldnt add author');
                }
            } else {
                die('Couldn\'t find an author.');
            }

            if(isset($_GET)) {
                $booksSql= "UPDATE `books` SET `title`= '$safetitle',`description`='$safeDescription',`year`=$safeYear,`author_id`= $authorID WHERE _id = $bookID";
            } else {
                $booksSql= "INSERT INTO `books`(`title`, `description`, `year`, `author_id`) VALUES ('$safetitle', '$safeDescription', $safeYear, $authorID)";
            }


            $booksResult = mysqli_query($dbc, $booksSql);
            if($booksResult && mysqli_affected_rows($dbc) > 0) {
                if(!isset($_GET['id'])) {
                    $bookID = $dbc->insert_id;
                }
                header('Location:singleBook.php?id='.$bookID);
            } else {
                die('There is something wrong with your sql query');
            }
        }

    }

?>

        <div class="row mb-2">
            <div class="col">
                <h1><?php echo $pageTitle; ?></h1>
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
                <form action="./books/addBook.php<?php if (isset($_GET['id'])){ echo '?id='.$_GET['id']; }; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="title">Book Title</label>
                      <input type="text" class="form-control" name="title"  placeholder="Enter book title" value="<?php if(isset($title)) { echo $title; } ?>">
                    </div>

                    <div class="form-group author-group">
                      <label for="author">Author</label>
                      <input type="text" autocomplete="off" class="form-control"  name="author" placeholder="Enter books author" value="<?php if(isset($author)) { echo $author; } ?>">
                    </div>

                    <div class="form-group author-group">
                      <label for="year">Year</label>
                      <input type="number" autocomplete="off" class="form-control"  name="year" placeholder="<?php echo date('Y'); ?>" value="<?php if(isset($year)) { echo $year; } ?>">
                    </div>

                    <div class="form-group">
                      <label for="description">Book Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the book"><?php if(isset($description)) { echo $description; } ?></textarea>
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
