<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Product Items</h2>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-secondary " style="height:40px;margin-top:10px;margin-bottom:10px;" data-toggle="modal" data-target="#myModal">
            Add Product
        </button>
        <table class="table ">
            <thead>
                <tr>
                    <th class="text-center">S.N.</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Breed</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code for displaying product items -->
                <?php
                include_once "../config/dbconnect.php";
                $sql = "SELECT * FROM animals";
                $result = $conn->query($sql);
                $count = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?=$count?></td>
                            <td><img height='100px' src='<?=$row["image"]?>'></td>
                            <td><?=$row["name"]?></td>
                            <td><?=$row["description"]?></td>
                            <td><?=$row["breed"]?></td>
                            <td><?=$row["price"]?></td>
                            <td><button class="btn btn-primary" style="height:40px" onclick="itemEditForm('<?=$row['id']?>')">Edit</button></td>
                            <td><button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?=$row['id']?>')">Delete</button></td>
                        </tr>
                        <?php
                        $count++;
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Pet</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for adding a new pet -->
                        <form  enctype='multipart/form-data' onsubmit="addItems()" method="POST">
                            <div class="form-group">
                                <label for="p_name">Pet Name:</label>
                                <input type="text" class="form-control" id="p_name" name="p_name" required>
                            </div>
                            <div class="form-group">
                                <label for="p_price">Price:</label>
                                <input type="number" class="form-control" id="p_price" name="p_price" required>
                            </div>
                            <div class="form-group">
                                <label for="p_desc">Description:</label>
                                <input type="text" class="form-control" id="p_desc" name="p_desc" required>
                            </div>
                            <div class="form-group">
                                <label for="p_address">Address:</label>
                                <input type="text" class="form-control" id="p_address" name="p_address" required>
                            </div>
                            <div class="form-group">
                                <label for="p_size">Size:</label>
                                <input type="text" class="form-control" id="p_size" name="p_size" required>
                            </div>
                            <div class="form-group">
                                <label for="p_age">Age:</label>
                                <input type="number" class="form-control" id="p_age" name="p_age" required>
                            </div>
                            <div class="form-group">
                                <label for="p_vaccinated">Vaccinated:</label>
                                <input type="text" class="form-control" id="p_vaccinated" name="p_vaccinated" required>
                            </div>
                            <div class="form-group">
                                <label for="p_breed">Breed:</label>
                                <input type="text" class="form-control" id="p_breed" name="p_breed" required>
                            </div>
                            <div class="form-group">
                                <label for="p_status">Status:</label>
                                <input type="number" class="form-control" id="p_status" name="p_status" required>
                            </div>
                            <div class="form-group">
                                <label for="p_agency_id_fk">Agency ID:</label>
                                <input type="number" class="form-control" id="p_agency_id_fk" name="p_agency_id_fk" required>
                            </div>
                            <div class="form-group">
                                <label for="file">Choose Image:</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary" style="height:40px" name="upload">Add Pet</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
