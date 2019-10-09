<?php
    require('../templates/header.php');


    if($_POST) {
        var_dump($_POST);
        // var_dump($_POST['title']);
        // var_dump('You have submitted a book');

        extract($_POST);
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
        } else if (strlen($description) < 50) {
            array_push($errors, 'The description length must be at least 10 characters');
        } else if(strlen($description) > 65535) {
            array_push($errors, 'Description must have less than 65535 characters');
        }

        if(empty($errors)) {
            $safeBkTitle = mysqli_real_escape_string($dbc, $bkTitle); // safe version - turning everything into a string version
            $safeAuthor = mysqli_real_escape_string($dbc, $author);
            $safeDescription = mysqli_real_escape_string($dbc, $description);

            $sql = "INSERT INTO `authors`(`name`) VALUES ('$author')";
            $result = mysqli_query($dbc, $sql);
            if($result && mysqli_affected_rows($dbc) > 0) {
                var_dump('author was added');
            } else {
                die('couldnt add author');
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>
