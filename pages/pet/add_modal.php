<!-- Add Pet Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg"> <!-- Modal size set to large -->
        <form method="post" action="function/addPet.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Pet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"> <!-- Row Start -->

                        <!-- First Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pet_name">Pet Name</label>
                                <input class="form-control" type="text" id="pet_name" name="pet_name" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Pet Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" selected disabled>Select Pet Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="breed">Breed</label>
                                <input class="form-control" type="text" id="breed" name="breed" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age (in years)</label>
                                <input class="form-control" type="number" id="age" name="age" min="0" required>
                            </div>
                        </div>
                        <!-- End First Column -->

                        <!-- Second Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Adoption Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="Available">Available</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Adopted">Adopted</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Second Column -->

                        <!-- Third Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="photoPath">Upload Pet Image</label>
                                <input class="form-control-file" type="file" id="photoPath" name="photoPath" accept="image/*" onchange="previewImage()" required>
                            </div>
                            <img id="imagePreview" src="#" alt="Profile Image Preview" style="max-width: 100%; display: none;">
                        </div>
                        <!-- End Third Column -->
                    </div> <!-- End Row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to preview the selected image
    function previewImage() {
        var fileInput = document.getElementById('photoPath');
        var imagePreview = document.getElementById('imagePreview');

        // Check if a file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            // When image file is loaded
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image preview
            };

            // Read the image file
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>