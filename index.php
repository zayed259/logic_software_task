<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h3 class="text-center">User Information</h3>
        <hr>
        <div>
            <form id="addForm">
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="0">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="phone">Cell No</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="gender">Gender</label>
                    <select id="gender" class="form-select" aria-label="Gender">
                        <option class="gender" value="-1" selected>Select Option</option>
                        <?php
                        $gender = [
                            1 => 'Male',
                            2 => 'Female',
                            3 => 'Other'
                        ];
                        foreach ($gender as $key => $value) {
                            echo '<option class="gender" value="' . $key . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    <button type="submit" class="btn btn-success" id="updateBtn">Update</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </form>
        </div>
        <hr>
        <h3 class="text-center">User List</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Cell No</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#updateBtn').hide();
            // add data
            $('#addForm').on('submit', function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var address = $('#address').val();
                var gender = $('.gender:checked').val();
                var dob = $('#dob').val();
                // alert(gender);
                // return;

                // email validation
                if (email != '') {
                    var atposition = email.indexOf("@");
                    var dotposition = email.lastIndexOf(".");
                    if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
                        alert("Please enter a valid e-mail address");
                        return false;
                    }
                }
                if (name == '') {
                    alert('Name is required');
                } else if (phone == '') {
                    alert('Cell No is required');
                } else if (isNaN(phone)) {
                    alert('Cell No must be numeric');
                } else if (phone.length != 11) {
                    alert('Cell No must be 11 digits');
                } else {
                    $.ajax({
                        url: 'add.php',
                        type: 'POST',
                        data: {
                            name: name,
                            phone: phone,
                            email: email,
                            address: address,
                            gender: gender,
                            dob: dob
                        },
                        success: function(response) {
                            $('#addForm')[0].reset();
                            alert('Data added successfully');
                            showAllRecords();
                        }
                    });
                }
            });

            // show all data
            showAllRecords();

            function showAllRecords() {
                $.ajax({
                    url: 'show.php',
                    type: 'GET',
                    data: {
                        show: 1
                    },
                    success: function(response) {
                        $('#tbody').html(response);
                    }
                });
            }

            // delete data
            $('tbody').on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                var deleteId = $(this).attr('id');
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        alert(response);
                        showAllRecords();
                    }
                });
            });

            // edit data
            $('tbody').on('click', '.editBtn', function() {
                var id = $(this).attr('id');
                // console.log(id);
                $.ajax({
                    type: "POST",
                    url: "edit.php",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        // console.log(res);
                        $('#id').val(res.id);
                        $('#name').val(res.name);
                        $('#phone').val(res.phone);
                        $('#email').val(res.email);
                        $('#address').val(res.address);
                        $('#gender option[value="' + res.gender + '"]').prop('selected', true);
                        $('#dob').val(res.dob);
                        $('#saveBtn').hide();
                        $('#updateBtn').show();
                    }
                });
            });

            // update data
            $('#updateBtn').on('click', function(e) {
                e.preventDefault();
                $('#id').empty();
                var id = $('#id').val();
                var name = $('#name').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var address = $('#address').val();
                var gender = $('.gender:checked').val();
                var dob = $('#dob').val();
                // alert(id);
                // return;
                
                // email validation
                if (email != '') {
                    var atposition = email.indexOf("@");
                    var dotposition = email.lastIndexOf(".");

                    if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length) {
                        alert("Please enter a valid e-mail address");
                        return false;
                    }
                }
                if (name == '') {
                    alert('Name is required');
                } else if (phone == '') {
                    alert('Cell No is required');
                } else if (isNaN(phone)) {
                    alert('Cell No must be numeric');
                } else if (phone.length != 11) {
                    alert('Cell No must be 11 digits');
                } else {
                    $.ajax({
                        url: 'update.php',
                        type: 'POST',
                        data: {
                            id: id,
                            name: name,
                            phone: phone,
                            email: email,
                            address: address,
                            gender: gender,
                            dob: dob
                        },
                        success: function(response) {
                            $('#addForm')[0].reset();
                            alert('Data updated successfully');
                            showAllRecords();
                            $('#saveBtn').show();
                            $('#updateBtn').hide();
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>