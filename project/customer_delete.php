<?php
include 'config/database.php';

try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $query = "DELETE FROM customers WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: customer_read.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}

catch(PDOException $exception){
    echo "<div class = 'alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
?>