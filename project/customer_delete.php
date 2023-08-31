<?php
include 'config/database.php';

try {
    // Get the ID from the query parameter
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    // Check for related orders
    $order_count_query = "SELECT COUNT(*) FROM order_summary WHERE customer_id = ?";
    $order_count_stmt = $con->prepare($order_count_query);
    $order_count_stmt->bindParam(1, $id);
    $order_count_stmt->execute();
    $order_count = $order_count_stmt->fetchColumn();

    $image_query = "SELECT image FROM customers WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM customers WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if ($customers > 0) {
        header("Location: customer_read.php?action=failed");
    } else {
        if ($stmt->execute()) {
            if ($image['image'] != "") {
                if (file_exists($image['image'])) {
                    unlink($image['image']);
                }
            }
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    echo "<div class = 'alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
