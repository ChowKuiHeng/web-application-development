<!DOCTYPE HTML>
<html>

<head>
    <title>Create New Order</title>
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
            <h1>Create New Order</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // Include database connection
        include 'config/database.php';
        $product_query = "SELECT id, name FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $product = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST) {
            try {
                $customer = $_POST['customer'];
                $order_date = date('Y-m-d H:i:s'); // get the current date and time

                // Insert into order_summary table
                $summary_query = "INSERT INTO order_summary SET customer_id=:customer, order_date=:order_date";
                $summary_stmt = $con->prepare($summary_query);
                $summary_stmt->bindParam(':customer', $customer);
                $summary_stmt->bindParam(':order_date', $order_date);
                $summary_stmt->execute();

                // Get the generated order_id
                $order_id = $con->lastInsertId();

                $product_id = $_POST['product'];
                $quantity = $_POST['quantity'];
                $customer = $_POST['customer'];
                 // Insert into order_detail table
                $details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                $details_stmt = $con->prepare($details_query);
                for ($i = 0; $i < count($product_id); $i++) {
                    $details_stmt->bindParam(':order_id', $order_id);
                    $details_stmt->bindParam(':product_id', $product_id[$i]);
                    $details_stmt->bindParam(':quantity', $quantity[$i]);
                    $details_stmt->execute();
                }
                echo "<div class='alert alert-success'>Order successfully.</div>";
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Unable to place order.</div>";
            }
        }

        ?>

        <!-- HTML form here where the order information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Customer</td>
                    <td>
                        <select class="form-select" name="customer">
                            <?php
                            // Fetch customers from the database
                            $query = "SELECT id, username FROM customers";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Generate select options
                            foreach ($customers as $customer) {
                                echo "<option value='{$customer['id']}'>{$customer['username']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <?php
                // Generate three dropdown menus for product selections
                for ($i = 1; $i <= 3; $i++) {
                    echo "<tr>
                        <td>Product $i</td>
                        <td>
                            <select class='form-select' name='product[]'>
                                <option value=''>Select a product</option>";
                    // Fetch products from the database
                    $query = "SELECT id, name FROM products";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Generate select options for each product
                    foreach ($products as $product) {
                        echo "<option value='{$product['id']}'>{$product['name']}</option>";
                    }

                    echo "</select>
                        </td>
                    </tr>";
                }
                ?>
                <tr>
                    <td>Quantities</td>
                    <td>
                        <?php
                        // Generate input fields for quantities corresponding to selected products
                        for ($i = 1; $i <= 3; $i++) {
                            echo "<div><input type='number' name='quantity[]' min='1' value='1' /> Product $i</div>";
                        }
                        ?>
                    </td>
                </tr>
                <td></td>
                <td>
                    <input type='submit' value='Create Order' class='btn btn-primary' />
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