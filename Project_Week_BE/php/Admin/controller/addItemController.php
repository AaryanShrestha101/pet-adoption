<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
        $name = $_POST['p_name'];
        $description = $_POST['p_desc'];
        $price = $_POST['p_price'];
        $address = $_POST['p_address'];
        $size = $_POST['p_size'];
        $age = $_POST['p_age'];
        $vaccinated = $_POST['p_vaccinated'];
        $breed = $_POST['p_breed'];
        $status = $_POST['p_status'];
        $agency_id_fk = $_POST['p_agency_id_fk'];

        $image = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $target_dir = "../uploads/";
        $finalImage = $target_dir . $image;

        move_uploaded_file($temp, $finalImage);

        $insert = mysqli_query($conn, "INSERT INTO animals
        (name, image, price, description, address, size, age, vaccinated, breed, status, agency_id_fk) 
        VALUES ('$name', '$finalImage', $price, '$description', '$address', '$size', $age, '$vaccinated', '$breed', $status, $agency_id_fk)");

        if(!$insert)
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "Record added successfully.";
        }
    }
?>
