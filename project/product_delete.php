<?php
// include database connection
include 'config/database.php';

try {
    // get record ID
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    // Check if there are associated order details
    $exists_query = "SELECT COUNT(*) FROM order_details WHERE product_id = ?";
    $exists_stmt = $con->prepare($exists_query);
    $exists_stmt->bindParam(1, $id); // Bind the parameter
    $exists_stmt->execute();
    $count = $exists_stmt->fetchColumn(); // Fetch the count directly

    if ($count > 0) {
        header("Location: product_read.php?action=failed");
        exit; // Terminate the script
    }

    // Fetch the image filename
    $image_query = "SELECT image FROM products WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);

    // Delete query
    $delete_query = "DELETE FROM products WHERE id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bindParam(1, $id);

    // Execute the delete query
    if ($delete_stmt->execute()) {
        unlink("uploads/" . $image['image']);
        // Redirect to read records page and tell the user record was deleted
        header('Location: product_read.php?action=deleted');
        exit; // Terminate the script
    } else {
        die('Unable to delete record.');
    }
} catch (PDOException $exception) {
    echo "<div class='alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
?>
