<?php session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
  } ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
    <div class="row">

        <?php include "./templates/sidebar.php"; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                    <span>Customers</span>
                </div>
            </div>
        </div>
            <br>
        <div class="row">
            <div class="col-10">
                <h4>Customers</h4>
            </div>
            <div class="col-2">
                <a href="#" id="add_button" data-bs-toggle="modal" data-bs-target="#userModal"
                    class="btn btn-warning btn-sm">
                    <i class="fa fa-plus" style="font-size:25px"></i></a>
                    
            </div>
        </div>
        <br>

        <div class="tab">
      
            <table id="ava" class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Index</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Stream</th>
                        <th>Intake</th>
                        <th>Mobile</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
            </main>
        </div>
    </div>

<!-- Modal -->

    <?php include_once("./templates/footer.php"); ?>

    <div class="modal fade" id="userModal">
        <div class="modal-dialog">
            <form method="post" id="pro_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Add </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label>Mobile </label>
                        <input type="text" name="mobile" id="mobile" class="form-control" />
                        <br />
                        <label>Username </label>
                        <input type="text" name="uname" id="uname" class="form-control" />
                        <br />
                        <label>Password </label>
                        <input type="text" name="pass" id="pass" class="form-control" />
                        <br />
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_id" id="user_id" />
                        <input type="hidden" name="operationA" id="operationA" />
                        <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <!-- USe datatable plugin -->
    <script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $('#add_button').click(function() {
            $('#pro_form')[0].reset();
            $('.modal-title').text("Add User");
            $('#action').val("Add");
            $('#operationA').val("Add");
            // $('#user_uploaded_image').html('');
        });

        var dataTable = $('#ava').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetchCus.php",
                type: "POST"
            },
            "columnDefs": [{
                // Column Ordering
                "targets": [0, 2, 3, 4, 5, 6],
                "orderable": false,
            }, ],

        });

        $(document).on('submit', '#pro_form', function(event) {
            event.preventDefault();
            var proTitle = $('#availability').val();
            
            if (proTitle != '') {
                $.ajax({
                    url: "insertCus.php",
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        $('#pro_form')[0].reset();
                        $('#userModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            } else {
                alert("Field cannot be empty");
            }
        });

        $(document).on('click', '.update', function() {

            // fetch id of the item
            var user_id = $(this).attr("id");
            // window.alert(user_id);

            $.ajax({
                url: "fetch_singleCus.php",
                method: "POST",
                data: {
                    user_id: user_id
                },
                dataType: "json",
                success: function(data) {


                    $('#userModal').modal('show');
                    $('#mobile').val(data.mobile);
                    $('#uname').val(data.uname);
                    $('#pass').val(data.pass);
                    $('.modal-title').text("Edit Customer");
                    $('#user_id').val(user_id);
                    $('#action').val("Edit");
                    $('#operationA').val("Edit");
                }
            })
        });

        $(document).on('click', '.delete', function() {
            var user_id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "deleteCus.php",
                    method: "POST",
                    data: {
                        user_id: user_id
                    },
                    success: function(data) {
                        alert(data);
                        dataTable.ajax.reload();
                    }
                });
            } else {
                return false;
            }
        });


    });
    </script>