<!DOCTYPE HTML>
<html>

<head>
    <title>List of Customers</title>
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
            <h1>Read Customer</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here

        // select all data

        // $query = "SELECT id, username, firstname, lastname, gender, date_of_birth, account_status FROM customers ORDER BY id DESC";
        // $stmt = $con->prepare($query);
        // $stmt->execute();
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, username, firstname, lastname,  email, gender, date_of_birth, account_status FROM customers";
        if (!empty($searchKeyword)) {
            $query .= " WHERE id LIKE :keyword OR username LIKE :keyword OR firstname LIKE :keyword OR lastname LIKE :keyword OR email LIKE :keyword OR gender LIKE :keyword OR date_of_birth LIKE :keyword OR account_status LIKE :keyword";
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
        echo "<a href='customer_create.php' class='btn btn-primary mb-3'>Create New Customer</a>";

        echo '<div class="p-3">
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search product..." value="' . str_replace('%', '', $searchKeyword) . '">
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
            echo "<th>Username</th>";
            echo "<th>Firstname</th>";
            echo "<th>Lastname</th>";
            echo "<th>Email</th>";
            echo "<th>Gender</th>";
            echo "<th>Date of Birth</th>";
            echo "<th>Account Status</th>";
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
                echo "<td>{$username}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$gender}</td>";
                echo "<td>{$date_of_birth}</td>";
                echo "<td>{$account_status}</td>";



                echo "</td>";

                echo "<td>";
                // read one record
                echo "<a href='customer_read_one.php?id={$id}' class='btn btn-info me-3'>Read</a>";

                // we will use these links in the next part of this post
                echo "<a href='customer_update.php?id={$id}' class='btn btn-primary me-3'>Edit</a>";

                // we will use this links in the next part of this post
                echo "<a href='#' onclick='delete_product({$id});' class='btn btn-danger me-3'>Delete</a>";
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

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>