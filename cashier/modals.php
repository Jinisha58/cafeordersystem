<?php
function renderEditModal($order_id, $status) {
?>
    <!-- Modal for Editing Status -->
    <div class="modal fade" id="editModal<?php echo $order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $order_id; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?php echo $order_id; ?>">Edit Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="update_order_status.php">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <div class="form-group">
                        <label for="status">Select New Status:</label>
                        <select name="status" class="form-control" required>
                            <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="In Progress" <?php if ($status == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Completed" <?php if ($status == 'Completed') echo 'selected'; ?>>Completed</option>
                        </select>       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}

function renderDeleteModal($order_id) {
?>
    <!-- Modal for Deleting Order -->
    <div class="modal fade" id="deleteModal<?php echo $order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $order_id; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?php echo $order_id; ?>">Delete Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="delete_order.php">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this order?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="delete_order" class="btn btn-danger">Delete Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
