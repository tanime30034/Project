<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg"> <!-- Large modal size -->
        <form method="post" action="function/addAdopter.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Adoption Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"> <!-- Start row -->
                        <div class="col-md-6"> <!-- First column -->
                            <div class="form-group">
                                <label for="userID">User ID</label>
                                <input class="form-control" type="number" id="userID" name="userID" required>
                            </div>
                        </div> <!-- End first column -->
                        <div class="col-md-6"> <!-- Second column -->
                            <div class="form-group">
                                <label for="petID">Pet ID</label>
                                <input class="form-control" type="number" id="petID" name="petID" required>
                            </div>
                        </div> <!-- End second column -->
                    </div> <!-- End row -->
                    <div class="row"> <!-- Start row for adoption date -->
                        <div class="col-md-6"> <!-- First column -->
                            <div class="form-group">
                                <label for="adoption_date">Adoption Date</label>
                                <input class="form-control" type="date" id="adoption_date" name="adoption_date" required>
                            </div>
                        </div> <!-- End first column -->
                    </div> <!-- End row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_button" name="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->