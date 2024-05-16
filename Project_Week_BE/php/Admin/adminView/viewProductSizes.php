<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adoption Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Adoption Requests</h2>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">S.N.</th>
                    <th class="text-center">Adoption For</th>
                    <th class="text-center">Breed</th>
                    <th class="text-center">Adoption Request By</th>
                    <th class="text-center">Request Date</th>
                    <th class="text-center">Living Condition</th>
                    <th class="text-center">Previous Experience</th>
                    <th class="text-center">Adoption Reason</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once "../config/dbconnect.php";
                $sql = "SELECT pa.*, CONCAT(u.first_name, ' ', u.last_name) as user_name, a.name as name, a.breed
                        FROM pet_adoptions pa 
                        JOIN users u ON pa.user_id_fk = u.id
                        JOIN animals a ON pa.animal_id_fk = a.id";
                $result = $conn->query($sql);
                $count = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td class="text-center"><?= $count ?></td>
                            <td class="text-center"><?= $row["name"] ?></td>
                            <td class="text-center"><?= $row["breed"] ?></td>
                            <td class="text-center"><?= $row["user_name"] ?></td>
                            <td class="text-center"><?= $row["request_date"] ?></td>
                            <td class="text-center"><?= $row["living_condition"] ?></td>
                            <td class="text-center"><?= $row["previous_experience"] ?></td>
                            <td class="text-center"><?= $row["adoption_reason"] ?></td>
                            <td class="text-center">
                                <button class="btn btn-primary" style="height:40px" onclick="approveRequest('<?= $row['id'] ?>')">Approve</button>
                                <button class="btn btn-danger" style="height:40px" onclick="declineRequest('<?= $row['id'] ?>')">Decline</button>
                            </td>
                        </tr>
                <?php
                        $count++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        function approveRequest(id) {
            if (confirm('Are you sure you want to approve this request?')) {
                // Send AJAX request to insert the approved request data into the notifications table
                $.ajax({
                    url: '../controllers/insert_notification.php',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Redirect to the same page after successful insertion
                        window.location.href = 'adoption_requests.php';
                    }
                });
            }
        }

        function declineRequest(id) {
            if (confirm('Are you sure you want to decline this request?')) {
                window.location.href = 'decline_request.php?id=' + id;
            }
        }
    </script>
</body>

</html>
