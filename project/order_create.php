<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create New Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>


    <!-- Container -->
    <div class="container">
        <!-- Navigation Menu -->
        <?php
        include 'menu/navigation.php';
        ?>
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // Include database connection
        date_default_timezone_set('asia/Kuala_Lumpur');
        include 'config/database.php';

        // Fetch products from the database
        $query = "SELECT * FROM products";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if ($_POST) {
            try {

                $errors = array();
                $product_id = $_POST['product'];
                $quantity_array = $_POST['quantity'];
                $customer = $_POST['customer'];
                $selected_product_count = count($_POST['product']);
                $noduplicate = array_unique($product_id);

                if (sizeof($noduplicate) != sizeof($product_id)) {
                    foreach ($product_id as $key => $val) {
                        if (!array_key_exists($key, $noduplicate)) {
                            $errors[] = "Duplicated products have been chosen ";
                            array_splice($product_id, $key, 1);
                            array_splice($quantity_array, $key, 1);
                        }
                    }
                }

                $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($_POST['product']);
                //add for loop for product id 

                // $quantity_array = $_POST['customer']; // Incorrect variable assignment


                if (empty($customer)) {
                    $errors[] = "You need to select the customer.";
                }
                foreach ($product_id as $product) {
                    if (empty($product)) {
                        $errors[] = "Please select a product.";
                    }
                }

                foreach ($quantity_array as $quantity) {
                    if (empty($quantity)) {
                        $errors[] = "Please fill in the quantity of products.";
                    }
                    if ($quantity == 0) {
                        $errors[] = "Quantity cannot be zero.";
                    }
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $customer = $_POST['customer'];
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time

                    $total_amount = 0;
                    for ($x = 0; $x < $selected_product_count; $x++) {
                        $amount =  ($products[$product_id[$x] - 1]['promotion_price'] != 0) ?  $products[$product_id[$x] - 1]['promotion_price'] * $quantity_array[$x] : $products[$product_id[$x] - 1]['price'] * $quantity_array[$x];

                        $total_amount += $amount;
                    }

                    // Insert into order_summary table
                    $summary_query = "INSERT INTO order_summary SET customer_id=:customer, total_amount=:total_amount, order_date=:order_date";
                    $summary_stmt = $con->prepare($summary_query);
                    $summary_stmt->bindParam(':customer', $customer);
                    $summary_stmt->bindParam(":total_amount", $total_amount);
                    $summary_stmt->bindParam(':order_date', $order_date);
                    $summary_stmt->execute();

                    // Get the generated order_id
                    $order_id = $con->lastInsertId();

                    $product_id = $_POST['product'];
                    $quantity = $_POST['quantity'];

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
                }
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Unable to place order.</div>";
            }
        }

        ?>

        <!-- HTML form here where the order information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <tr>
                <td>Customer</td>
                <td>
                    <select class="form-select" name="customer">
                        <option value=''>Select a customer</option>";
                        <?php
                        // Fetch customers from the database
                        $query = "SELECT id, username FROM customers";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Generate select options
                        for ($x = 0; $x < count($customers); $x++) {
                            $customer_selected = isset($_POST["customer"]) && $customers[$x]['id'] == $_POST["customer"] ? "selected" : "";
                            echo "<option value='{$customers[$x]['id']}' $customer_selected>{$customers[$x]['username']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <br>
            <table class='table table-hover table-responsive table-bordered' id="row_del">

                <tr>
                    <td class="text-center ">#</td>
                    <td class="text-center ">Product</td>
                    <td class="text-center ">Quantity</td>
                    <td class="text-center ">Action</td>
                </tr>
                <?php
                $product_keep = (!empty($error)) ? $selected_product_count : 1;
                for ($x = 0; $x < $product_keep; $x++) {
                ?>
                    <tr class="pRow">
                        <td class="text-center">1</td>
                        <td>
                            <select class='form-select' name='product[]' aria-label=".form-select-lg example">
                                <option value=''>Select a products</option>";
                                <?php
                                for ($i = 0; $i < count($products); $i++) {
                                    $product_selected = isset($_POST["product"]) && $products[$i]['id'] == $_POST["product"][$x] ? "selected" : "";
                                    echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                                }
                                ?>

                            </select>
                        </td>
                        <td><input type="number" class='form-control' name='quantity[]' value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'][$x] : 0; ?>" aria-label=".form-select-lg example" />


                        </td>
                        <td><input href='#' onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1' value="Delete" /></td>
                    </tr>
                <?php

                } ?>
                <tr>
                    <td>

                    </td>
                    <td colspan="4">
                        <input type="button" value="Add More Product" class="btn btn-success add_one" />
                        <input type='submit' value='Create Order' class='btn btn-primary' />
                    </td>
                </tr>
                </tr>
            </table>
        </form>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var rows = document.getElementsByClassName('pRow');
                    // Get the last row in the table
                    var lastRow = rows[rows.length - 1];
                    // Clone the last row
                    var clone = lastRow.cloneNode(true);
                    // Insert the clone after the last row
                    lastRow.insertAdjacentElement('afterend', clone);

                    // Loop through the rows
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                }
            }, false);

            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("row_del").deleteRow(i);

                    var rows = document.getElementsByClassName('pRow');
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                } else {
                    alert("You need order at least one item.");
                }
            }
        </script>
    </div>
    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </script>
</body>

</html>