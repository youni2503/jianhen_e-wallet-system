<?php 
include 'header.php';

$sql_emp = "SELECT * FROM employee ORDER BY employee_name DESC";
$result_emp = mysqli_query($connection,$sql_emp);

$sql_vendor = "SELECT * FROM Vendors ORDER BY vendor_name DESC";
$result_vendor = mysqli_query($connection,$sql_vendor);
?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users Management</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th class="table-plus datatable-nosort" style=" text-align: left;">#</th>
        <th style=" text-align: left;">Name</th>
        <th style=" text-align: left;">Emp ID</th>
        <th style=" text-align: left;">Email</th>
        <th style=" text-align: left;">Ewallet Balance</th>
        <th style=" text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$i = 0;
while($row_emp = mysqli_fetch_array($result_emp)){ 
?>
<tr>
<td><?php echo ++$i ?></td>
<td style="text-align: left;"><?php echo $row_emp['employee_name'] ?></td>
<td style="text-align: left;"><?php echo $row_emp['employee_id'] ?></td>
<td style="text-align: left;"><?php echo $row_emp['employee_email'] ?></td>
<td style="text-align: left;">RM <?php echo $row_emp['employee_ewallet_balance'] ?></td>
<td>

<button type="button" 
class="btn btn-sm btn-info edit" 
data-toggle="modal"
data-id="<?php echo $row_emp['emp_id'] ?>"
data-target="#bd-example-modal-lg">Update Credit</button>

</td>

</tr>

<?php
} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Vendor List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th class="table-plus datatable-nosort" style=" text-align: left;">#</th>
        <th style=" text-align: left;">Name</th>
        <th style=" text-align: left;">Email</th>
        <th style=" text-align: left;">Ewallet Balance</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$i = 0;
while($row_vendor = mysqli_fetch_array($result_vendor)){ 
?>
<tr>
<td><?php echo ++$i ?></td>
<td style="text-align: left;"><?php echo $row_vendor['vendor_name'] ?></td>
<td style="text-align: left;"><?php echo $row_vendor['vendor_email'] ?></td>
<td style="text-align: left;">RM <?php echo $row_vendor['vendor_ewallet_balance'] ?></td>
</tr>
<?php
} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->
<div
        class="modal fade bs-example-modal-lg"
        id="bd-example-modal-lg"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myLargeModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                    Create New User
                    </h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                    >

                    </button>
                </div>
                <form action="postUser.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                <div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="employee_name" id="employee_name" disabled/>
        </div>
    </div>

    <div class="col-md-5 col-sm-12">
        <div class="form-group">
            <label>Employee ID</label>
            <input type="text" class="form-control" name="employee_id" id="employee_id" disabled>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label>Ewallet Balance</label>
            <input type="text" class="form-control" name="employee_ewallet_balance" id="employee_ewallet_balance" required/>
        </div>
    </div>
</div>
                </div>
                <div class="modal-footer">
                
                    <button type="submit" id="submibtn" class="btn btn-success">
                        Update
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
</form>
            </div>
        </div>
    </div>
<?php include 'footer.php';?>

<script>
$(document).ready(function(){

$(".edit").click(function(){
var id = $(this).data('id');

$('#id').val(id);

$.ajax({
url: 'fetchEmp.php',
type: 'POST',
data: { id: id },
dataType: 'json',
success: function(data) {

$('#employee_name').val(data.employee_name).prop('disabled',true);
$('#employee_id').val(data.employee_id).prop('disabled',true);
$('#employee_ewallet_balance').val(data.employee_ewallet_balance).prop('disabled',false);

$('#submibtn').html('Update');
$('#submibtn').show();
$('#type').val('E');
$('.modal-title').html('Update Employee Ewallet Credits');

},
error: function() {
alert('Whoops! Error.');
}
});

});

});

</script>