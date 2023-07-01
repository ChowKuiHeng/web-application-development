<!DOCTYPE HTML>
<html>

<head>
    <title>Product Create</title>
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

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];

                $errors = array();

                // $errors = array();

                // if (empty($name)) {
                //   $errors[] = "Name is required.";
                // } if (empty($description)) {
                //     $errors[] = "Description is required.";

                if (empty($name)) {
                    $errors[] = "Name is required.";
                }
                if (empty($description)) {
                    $errors[] = "Description is required.";
                }
                if (empty($price)) {
                    $errors[] = "Price is required.";
                } elseif (!is_numeric($price)) {
                    $errors[] = "Price must be a numeric value.";
                }
                if (empty($promotion_price)) {
                    $errors[] = "Promotion Price is required.";
                } elseif (!is_numeric($promotion_price)) {
                    $errors[] = "Promotion Price must be a numeric value.";
                }
                if (empty($manufacture_date)) {
                    $errors[] = "Manufacture Date is required.";
                }
                if (empty($expired_date)) {
                    $errors[] = "Expired Date is required.";
                }

                if ($promotion_price >= $price) {
                    $errors[] = "Promotion price must be cheaper than the original price.";
                }
                if ($expired_date <= $manufacture_date) {
                    $errors[] = "Expired date must be later than the manufacture date.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created,  promotion_price=:promotion_price , manufacture_date=:manufacture_date, expired_date=:expired_date";
                    $stmt = $con->prepare($query);
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);

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
            <div class="row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" title='Please enter a valid name (letters and spaces only).' id="name">
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
                    <input type="text" name="price" class="form-control" title='Please enter a valid number.' id="price">
                </div>
            </div>
            <div class="row mb-3">
                <label for="promotion_price" class="col-sm-2 col-form-label">Promotion Price</label>
                <div class="col-sm-10">
                    <input type="text" name="promotion_price" class="form-control" title='Please enter a valid number.' id="promotion_price">
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
    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>