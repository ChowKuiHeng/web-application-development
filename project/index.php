<?php include "session.php"; ?>
<!DOCTYPE HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include 'menu/navigation.php';
        include 'config/database.php';

        $cusnumquery = "SELECT COUNT(*) FROM customers";
        $pronumquery = "SELECT COUNT(*) FROM products";
        $ornumquery = "SELECT COUNT(*) FROM order_summary";

        $cusnum = $con->query($cusnumquery)->fetchColumn();
        $pronum = $con->query($pronumquery)->fetchColumn();
        $ornum = $con->query($ornumquery)->fetchColumn();
        ?>

        <!-- Display customer, product, and order counts -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="text-center shadow p-4 bg-body-tertiary rounded">
                    <h1><?php echo $cusnum; ?></h1>
                    <br>
                    <h5>Customers Registered</h5>
                </div>
            </div>
            <div class="col">
                <div class="text-center shadow p-4 bg-body-tertiary rounded">
                    <h1><?php echo $pronum; ?></h1>
                    <br>
                    <h5>Products Available</h5>
                </div>
            </div>
            <div class="col">
                <div class="text-center shadow p-4 bg-body-tertiary rounded">
                    <h1><?php echo $ornum; ?></h1>
                    <br>
                    <h5>Orders Created</h5>
                </div>
            </div>
        </div>

        <!-- Display latest order details -->
        <div class="container bg-dark bg-opacity-25 py-5">
            <h2 class="text-center text-dark text-opacity-75">An Overview of Order</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="border border-3 shadow p-4 text-center bg-white">
                        <h3>Latest Order ID and Summary</h3>
                        <p class="mt-3"><span>Customer Name :</span>
                            <?php
                            $latest_order_query = "SELECT * FROM order_summary WHERE order_id=(SELECT MAX(order_id) FROM order_summary)";
                            $latest_order_stmt = $con->prepare($latest_order_query);
                            $latest_order_stmt->execute();
                            $latest_order = $latest_order_stmt->fetch(PDO::FETCH_ASSOC);

                            $customer_id = $latest_order['customer_id'];

                            $latest_customer_name_query = "SELECT * FROM customers where id=?";
                            $latest_customer_name_stmt = $con->prepare($latest_customer_name_query);
                            $latest_customer_name_stmt->bindParam(1, $customer_id);
                            $latest_customer_name_stmt->execute();
                            $latest_names = $latest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                            echo $latest_names['firstname'] . " " . $latest_names['lastname'];
                            ?>
                        </p>
                        <p><span>Order Date :</span>
                            <?php echo $latest_order['order_date']; ?>
                        </p>
                        <p><span>Total Amount :</span>
                            <?php echo "RM " . number_format((float)$latest_order['total_amount'], 2, '.', ''); ?>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="border border-3 shadow p-4 text-center bg-white">
                        <h3>Highest Purchased Amount Order</h3>
                        <p class="mt-3"><span>Customer Name :</span>
                            <?php
                            $highest_order_query = "SELECT * FROM order_summary WHERE total_amount=(SELECT MAX(total_amount) FROM order_summary)";
                            $highest_order_stmt = $con->prepare($highest_order_query);
                            $highest_order_stmt->execute();
                            $highest_order = $highest_order_stmt->fetch(PDO::FETCH_ASSOC);

                            $customer_id = $highest_order['customer_id'];

                            $highest_customer_name_query = "SELECT * FROM customers where id=?";
                            $highest_customer_name_stmt = $con->prepare($highest_customer_name_query);
                            $highest_customer_name_stmt->bindParam(1, $customer_id);
                            $highest_customer_name_stmt->execute();
                            $highest_names = $highest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                            echo $highest_names['firstname'] . " " . $highest_names['lastname'];
                            ?>
                        </p>
                        <p><span>Order Date :</span>
                            <?php echo $highest_order['order_date']; ?>
                        </p>
                        <p><span>Total Amount :</span>
                            <?php echo "RM " . number_format((float)$highest_order['total_amount'], 2, '.', ''); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container bg-dark bg-opacity-50 py-5">
            <h2 class="text-center text-white">An Overview of Our Product</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <div class="border border-3 shadow p-4 text-center bg-white">
                        <h3>Top 5 Selling Products</h3>
                        <?php
                        $top_product_query = "SELECT product_id, SUM(quantity) AS total_quantity FROM order_details GROUP BY product_id ORDER BY total_quantity DESC";
                        $top_product_stmt = $con->prepare($top_product_query);
                        $top_product_stmt->execute();
                        $top_products = $top_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                        for ($i = 0; $i < 5; $i++) {
                            if (!empty($top_products[$i])) {
                                $top_product_id = $top_products[$i]['product_id'];
                                $top_product_name_query = "SELECT * FROM products WHERE id=?";
                                $top_product_name_stmt = $con->prepare($top_product_name_query);
                                $top_product_name_stmt->bindParam(1, $top_product_id);
                                $top_product_name_stmt->execute();
                                $top_product_names = $top_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                                echo "<p>" . $top_product_names['name'] . " (" . $top_products[$i]['total_quantity'] . " SOLD)";
                            } else {
                                echo "";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div class="border border-3 shadow p-4 text-center bg-white">
                        <h3>3 Products Never Purchased</h3>
                        <?php
                        $no_purchased_product_query = "SELECT id FROM products WHERE NOT EXISTS(SELECT product_id FROM order_details WHERE order_details.product_id=products.id)";
                        $no_purchased_product_stmt = $con->prepare($no_purchased_product_query);
                        $no_purchased_product_stmt->execute();
                        $no_purchased_products = $no_purchased_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                        for ($i = 0; $i < 3; $i++) {
                            if (!empty($no_purchased_products[$i])) {
                                $no_purchased_product_id = $no_purchased_products[$i]['id'];
                                $no_purchased_product_name_query = "SELECT * FROM products WHERE id=?";
                                $no_purchased_product_name_stmt = $con->prepare($no_purchased_product_name_query);
                                $no_purchased_product_name_stmt->bindParam(1, $no_purchased_product_id);
                                $no_purchased_product_name_stmt->execute();
                                $no_purchased_product_name = $no_purchased_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                                echo "<p>" . $no_purchased_product_name['name'] . "</p>";
                            } else {
                                echo "";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>