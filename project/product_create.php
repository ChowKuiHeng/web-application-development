<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_product.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create_customer.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container mt-5">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>

        <!-- HTML form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created,  promotion_price=:promotion_price , manufacture_date=:manufacture_date, expired_date=:expired_date";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];

                // $error = array();

                // if (empty($name)) {
                //     echo "<div class='alert alert-danger'>Please enter the name!</div>";
                // } elseif (!preg_match("/^[a-zA-Z]+$/", $name)) {
                //     echo "<div class='alert alert-danger'>Name can only contain alphabetic characters!</div>";
                // }
                // if ($promotion_price >= $price) {
                //     echo "<div class='alert alert-danger'>Promotion price must be cheaper than original price<div>";
                // }
                // if ($manufacture_date >= $expired_date) {
                //     echo "<div class='alert alert-danger'>Manufacture date must be smaller than expired date</div>";
                // } elseif ($expired_date <= $manufacture_date) {
                //     echo "<div class='alert alert-danger'>Expired date must be earlier than manufacture date</div>";
                // } else {

                if ($promotion_price >= $price) {
                    echo "<div class='alert alert-danger'>Promotion price must be cheaper than original price
                        </div>";
                } elseif ($expired_date <= $manufacture_date) {
                    echo "<div class='alert alert-danger'>Expired date must be later than manufacture date</div>";
                } else {

                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $created = date('Y-m-d H:i:s'); // get the current date and time

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            } // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>


        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" pattern='^[A-Za-z\s]+$' title='Please enter a valid name (letters and spaces only).' id="name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="text" name="price" class="form-control" pattern='^\d+(\.\d{1,2})?$' title='Please enter a valid number.' id="price">
                </div>
            </div>
            <div class="row mb-3">
                <label for="promotion_price" class="col-sm-2 col-form-label">Promotion Price</label>
                <div class="col-sm-10">
                    <input type="text" name="promotion_price" class="form-control" pattern='^\d+(\.\d{1,2})?$' title='Please enter a valid number.' id="promotion_price">
                </div>
            </div>
            <div class="row mb-3">
                <label for="manufacture_date" class="col-sm-2 col-form-label">Manufacture Date</label>
                <div class="col-sm-10">
                    <input type="text" name="manufacture_date" class="form-control" id="manufacture_date">
                </div>
            </div>
            <div class="row mb-3">
                <label for="expired_date" class="col-sm-2 col-form-label">Expired Date</label>
                <div class="col-sm-10">
                    <input type="text" name="expired_date" class="form-control" id="expired_date">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <input type="submit" value="Save" class="btn btn-primary" />
                    <a href="index.php" class="btn btn-danger">Back to read products</a>
                </div>
            </div>
        </form>

    </div>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>