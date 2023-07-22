<!DOCTYPE HTML>
<html>

<head>
    <title>Categories Create</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Menu -->
    <?php
    include 'menu/navigation.php';
    ?>

    <!-- Container -->
    <div class="container mt-5">
        <div class="page-header">
            <h1>Categories Create</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php

        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $categories_name = $_POST['categories_name'];
                $description = $_POST['description'];

                $errors = array();



                if (empty($categories_name)) {
                    $errors[] = "Categories Name is required.";
                }
                if (empty($description)) {
                    $errors[] = "Description is required.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO categories SET categories_name=:categories_name, description=:description";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':categories_name', $categories_name);
                    $stmt->bindParam(':description', $description);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Error: " . $exception->getMessage() . "</div>";
            }
        }
        ?>

        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Categories Name</td>
                    <td><input type="text" name="categories_name" class="form-control" id="categories_name"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type="text" name="description" class="form-control" id="description"></td>

                </tr>

                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='categories_read.php' class='btn btn-danger'>Back to categories read</a>
                </td>
                </tr>


            </table>
        </form>

    </div>
    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>