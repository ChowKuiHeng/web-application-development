<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>List of order sumarry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container p-0 bg-light">
        <?php
        include 'menu/navigation.php';
        ?>
        <div class="page-header p-3 pb-1">
            <h1>Read Order Summary</h1>
        </div>

        <?php

        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.order_id, customers.username,order_summary.order_date FROM order_summary INNER JOIN customers ON order_summary.customer_id = customers.id";
        if (!empty($searchKeyword)) {
            $query .= " WHERE customers.username LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY order_summary.order_id ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="order_create.php" class="btn btn-primary m-b-1em">Create New Order</a>
        </div>';

        echo '<div class="p-3">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search username..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';

        if ($num > 0) {
            echo "<div class='p-3'>";
            echo "<div class='table-responsive'> <table class='table table-hover table-bordered'>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Username</th>";
            echo "<th>Order Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td><a href='order_details_read.php?id={$order_id}' class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-dark link-dark'>{$username}</a></td>";
                echo "<td>{$order_date}</td>";
                echo "<td>";
            
                echo "<a href='order_update.php?order_id={$order_id}' class='btn btn-primary me-3'>Edit</a>";

                echo "<a href='#' onclick='delete_product({$order_id});'  class='btn btn-danger'>Delete</a>";

                echo "</td>";
                echo "</tr>";
            }
            echo "</table></div>";
            echo "</div>";
        } else {
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>

    <script type='text/javascript'>
        // confirm record deletion
        function delete_product(id) {
            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'order_delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>