<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container p-0 bg-light">
        <?php include 'menu/navigation.php'; ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Product</h1>
        </div>

        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';

        $query = "SELECT customers.username, products.id, products.name, products.promotion_price, products.price, order_summary.customer_id, order_summary.order_date, order_details.detail_id, order_details.order_id, order_details.product_id, order_details.quantity FROM order_details INNER JOIN products ON products.id = order_details.product_id INNER JOIN order_summary ON order_summary.order_id = order_details.order_id INNER JOIN customers ON customers.id = order_summary.customer_id WHERE order_details.order_id = :id";

        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $num = $stmt->rowCount();

        $customerQuery = "SELECT order_summary.order_date, customers.firstname, customers.lastname FROM order_details INNER JOIN order_summary ON order_details.order_id = order_summary.order_id INNER JOIN customers ON order_summary.customer_id = id WHERE order_details.order_id = :id ORDER BY order_details.detail_id ASC";
        $customerStmt = $con->prepare($customerQuery);
        $customerStmt->bindParam(":id", $id);
        $customerStmt->execute();
        $customerRow = $customerStmt->fetch(PDO::FETCH_ASSOC);
        $firstname = $customerRow['firstname'];
        $lastname = $customerRow['lastname'];
        $orderDateTime = $customerRow['order_date'];

        if ($num > 0) {
            $totalamount = 0;
            echo "<div class='p-3'>";
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
            echo "<div class='pt-2 d-flex justify-content-between'>";
            echo "<p class='ps-3'><strong>Customer Name: " . $firstname . " " . $lastname . "</strong></p>";
            echo "<p class='pe-4'><strong>Order Date: " . $orderDateTime . "</strong></p>";
            echo "</div>";
            echo "<th>Product Name</th>";
            echo "<th class='text-end'>Price</th>";
            echo "<th class='text-end'>Quantity</th>";
            echo "<th class='text-end'>Total Price</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $totalprice = ($promotion_price > 0) ? $promotion_price * $quantity : $price * $quantity;
                $totalamount += $totalprice;
                echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td class='text-end'>";
                if (!empty($promotion_price)) {
                    // Display promotion price if available
                    echo "<div class='text-decoration-line-through'> RM" . number_format($price, 2) . "</div>";
                    echo 'RM'  . number_format($promotion_price, 2);
                } else {
                    // Display regular price
                    echo 'RM'  . number_format($price, 2);
                }

                echo "</td>";
                echo "<td class='text-end'>{$quantity}</td>";
                echo "<td class='text-end'>RM" . number_format($totalprice, 2) . " </td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan='3' class='text-end'><strong>Total amount: </strong></td>";
            echo "<td class='text-end'>RM" . number_format($totalamount, 2) . "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<a href='order_list_read.php' class='btn btn-danger'>Back to order list</a>";
            echo "</div>";
        } else {
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>