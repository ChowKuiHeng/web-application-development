<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Categories Read</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <!-- container -->
    <div class="container">
        <!-- Navigation Menu -->
        <?php
        include 'menu/navigation.php';
        ?>

        <div class="page-header">
            <h1>Categories Read</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        if ($action == 'failed') {
            echo "<div class='alert alert-danger'>There are products inside this Category.</div>";
        }



        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, categories_name, description FROM categories";
        if (!empty($searchKeyword)) {
            $query .= " WHERE categories_name LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY id DESC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='categories_create.php' class='btn btn-primary mt-2 mb-2'>Create New Categories</a>";

        echo '<div class="p-3">
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search categories name..." value="' . str_replace('%', '', $searchKeyword) . '">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>';

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Categories Name</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td><a href='categories_read_one.php?id={$id}' class='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-dark link-dark'>{$categories_name}</a></td>";

                echo "</td>";

                echo "<td>";
                // we will use these links in the next part of this post
                echo "<a href='categories_update.php?id={$id}' class='btn btn-primary me-3'>Edit</a>";

                // we will use this links in the next part of this post
                echo "<a href='#' onclick='categories_delete({$id});' class='btn btn-danger me-3'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function categories_delete(id) {
            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'categories_delete.php?id=' + id;
            }
        }
    </script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>