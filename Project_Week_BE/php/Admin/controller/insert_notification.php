<?php
include_once "../config/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Retrieve the adoption request data based on the provided ID
    $sql = "SELECT * FROM pet_adoptions WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Insert the adoption request data into the notifications table
        $insertSql = "INSERT INTO notifications (animal_id_fk, user_id_fk, request_date, living_condition, previous_experience, adoption_reason) 
                      VALUES ('{$row['animal_id_fk']}', '{$row['user_id_fk']}', '{$row['request_date']}', '{$row['living_condition']}', '{$row['previous_experience']}', '{$row['adoption_reason']}')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Notification inserted successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "No adoption request found with the provided ID";
    }
}
?>
