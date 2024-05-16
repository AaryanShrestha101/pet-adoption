<div>
    <h2>All Customers</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Username</th>
                <th class="text-center">Email</th>
                <th class="text-center">Contact Number</th>
                <th class="text-center">Address</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $count = 1;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $row["first_name"] ?> <?= $row["last_name"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td><?= $row["phone"] ?></td>
                    <td><?= $row["address"] ?></td>
                    <td><?= $row["status"] ?></td>
                    <td>
                        <button class="btn btn-danger" style="height: 40px" onclick="deleteCustomer(<?= $row['id'] ?>)">Delete</button>
                    </td>
                </tr>
        <?php
                $count = $count + 1;
            }
        }
        ?>
    </table>
</div>

<!-- Delete Customer Modal -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCustomerModalLabel">Confirm Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this customer?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCustomerBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteCustomer(id) {
        // Set the delete customer ID in the hidden input field
        $('#deleteCustomerModal').find('input[name="customer_id"]').val(id);
        // Show the modal
        $('#deleteCustomerModal').modal('show');
    }

    // Handle delete confirmation
    $('#confirmDeleteCustomerBtn').on('click', function() {
        // Get the customer ID from the hidden input field
        var id = $('#deleteCustomerModal').find('input[name="customer_id"]').val();
        // AJAX request to delete the customer
        $.ajax({
            url: 'delete_customer.php',
            type: 'post',
            data: {
                id: id
            },
            success: function(response) {
                // Reload the page after deletion
                location.reload();
            }
        });
    });
</script>
