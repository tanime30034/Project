<!-- Edit Modal -->
<div class="modal fade" id="edit_<?php echo $row['adopter_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Adoption Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="function/editAdopter.php" enctype="multipart/form-data">
                        <!-- Hidden fields for backend -->
                        <input type="hidden" name="adopter_id" id="hidden_adopter_id_<?php echo $row['adopter_id']; ?>" value="<?php echo $row['adopter_id']; ?>">
                        <input type="hidden" name="pet_id" id="hidden_pet_id_<?php echo $row['adopter_id']; ?>" value="<?php echo $row['pet_id']; ?>">

                        <!-- Numeric-only Pet ID -->
                        <div class="form-group">
                            <label for="pet_id">Pet ID</label>
                            <input 
                                class="form-control" 
                                type="number" 
                                name="pet_id_edit" 
                                id="editable_pet_id_<?php echo $row['adopter_id']; ?>" 
                                value="<?php echo $row['pet_id']; ?>" 
                                onchange="updateHiddenField('editable_pet_id_<?php echo $row['adopter_id']; ?>', 'hidden_pet_id_<?php echo $row['adopter_id']; ?>')" 
                                min="1" 
                                required>
                        </div>

                        <!-- Numeric-only Adopter ID -->
                        <div class="form-group">
                            <label for="adopter_id">Adopter ID</label>
                            <input 
                                class="form-control" 
                                type="number" 
                                name="adopter_id_edit" 
                                id="editable_adopter_id_<?php echo $row['adopter_id']; ?>" 
                                value="<?php echo $row['adopter_id']; ?>" 
                                onchange="updateHiddenField('editable_adopter_id_<?php echo $row['adopter_id']; ?>', 'hidden_adopter_id_<?php echo $row['adopter_id']; ?>')" 
                                min="1" 
                                required>
                        </div>

                        <!-- Adoption Date -->
                        <div class="form-group">
                            <label for="adoption_date">Adoption Date</label>
                            <input 
                                class="form-control" 
                                type="date" 
                                name="adoption_date" 
                                value="<?php echo $row['adoption_date']; ?>" 
                                required>
                        </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" name="edit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to sync editable and hidden fields -->
<script>
    function updateHiddenField(editableFieldId, hiddenFieldId) {
        // Sync the hidden field with the value of the editable field
        const editableValue = document.getElementById(editableFieldId).value;
        document.getElementById(hiddenFieldId).value = editableValue;
    }
</script>

<!-- Delete Modal -->
<div class="modal fade" id="delete_<?php echo $row['historyID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Adopter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="function/deleteAdopter.php" method="POST">
                <div class="modal-body">    
                    <p class="text-center">Are you sure you want to delete the adoption history?</p>
                    <h2 class="text-center"><?php echo $row['historyID']; ?></h2>
                    <!-- Hidden input to pass the historyID securely -->
                    <input type="hidden" name="historyID" value="<?php echo $row['historyID']; ?>">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="delete" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include jQuery library -->
<script src="../../plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $(".form-control").keyup(function () {
            var adopterName = $(this).val().trim();
            var responseContainer = $(this).closest('.form-group').find('#response'); // Adjusted to target the correct response container
            var submitButton = $(this).closest('.modal-content').find('button[type="submit"]');
            
            if (adopterName != '') {
                $.ajax({
                    url: 'function/checkDuplicate.php', // PHP script to check for duplicate
                    type: 'post',
                    data: { adopterName: adopterName }, // Changed the parameter name to match the PHP script
                    success: function (response) {
                        responseContainer.html(response); // Display response message
                        if (!response.includes('Adopter name already exists. Please enter a different name.')) {
                            submitButton.prop('disabled', false); // Enable submit button
                        } else {
                            submitButton.prop('disabled', true); // Disable submit button
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error); // Log error message
                    }
                });
            } else {
                responseContainer.html(""); // Clear response container
                submitButton.prop('disabled', true); // Disable submit button
            }
        });
    });
</script>
