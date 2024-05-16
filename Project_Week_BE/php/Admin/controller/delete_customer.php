<?php
include_once "../config/dbconnect.php";

// Check if ID parameter is provided
if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the SQL query to delete the customer
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Deletion successful
        echo "Customer deleted successfully";
    } else {
        // Error occurred
        echo "Error deleting customer: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // ID parameter not provided
    echo "No customer ID provided";
}
?>
