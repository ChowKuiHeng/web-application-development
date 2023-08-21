<?php
include 'config/database.php';

try {
    // Get the ID from the query parameter
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    // Check if there are related products
    $product_exist_query = "SELECT COUNT(*) FROM products WHERE categories_name = (SELECT categories_name FROM categories WHERE id = ?)";
    $product_exist_stmt = $con->prepare($product_exist_query);
    $product_exist_stmt->bindParam(1, $id);
    $product_exist_stmt->execute();
    $product_count = $product_exist_stmt->fetchColumn();

    if ($product_count > 0) {
        header("Location: categories_read.php?action=failed");
        exit(); // Terminate the script
    }

    // Delete query
    $delete_query = "DELETE FROM categories WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    if ($delete_stmt->execute()) {
        header("Location: categories_read.php?action=deleted");
        exit(); // Terminate the script
    } else {
        header("Location: categories_read.php?action=error");
        exit(); // Terminate the script
    }
} catch (PDOException $exception) {
    header("Location: categories_read.php?action=error");
    exit(); // Terminate the script
}
?>
