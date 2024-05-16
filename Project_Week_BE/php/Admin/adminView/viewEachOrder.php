<div class="container">
<table class="table table-striped">
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
    <?php
        include_once "../config/dbconnect.php";
        $ID= $_GET['orderID'];
        //echo $ID;
        $sql="SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) as user_name, a.name as name, a.breed
        FROM orders o
        JOIN users u ON pa.user_id_fk = u.id
        JOIN animals a ON pa.animal_id_fk = a.id";
        $result=$conn-> query($sql);
        $count=1;
        if ($result-> num_rows > 0){
            while ($row=$result-> fetch_assoc()) {
                $v_id=$row['variation_id'];
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
                        </tr>
    <?php
                $count=$count+1;
            }
        }else{
            echo "error";
        }
    ?>
</table>
</div>
