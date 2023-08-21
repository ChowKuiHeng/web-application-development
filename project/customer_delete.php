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

    if ($order_count > 0) {
        header("Location: customer_read.php?action=failed");
        exit(); // Terminate the script
    }

    // Retrieve image filename
    $image_query = "SELECT image FROM customers WHERE id = ?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);

    // Delete customer record
    $delete_query = "DELETE FROM customers WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    if ($delete_stmt->execute()) {
        if ($image && isset($image['image'])) {
            unlink("uploads/" . $image['image']);
        }
        header("Location: customer_read.php?action=deleted");
        exit(); // Terminate the script
    } else {
        header("Location: customer_read.php?action=error");
        exit(); // Terminate the script
    }
} catch (PDOException $exception) {
    header("Location: customer_read.php?action=error");
    exit(); // Terminate the script
}
?>
