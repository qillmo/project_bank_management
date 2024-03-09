<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bank Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        <?php include './css/style.css'; ?>
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 my-5 justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <div class="card" style="border-radius: 2rem;background-color:#f3fadc;">
                        <div class="text-center" style="margin-top: 30px;background-color: #64a986;color:#fff;">
                            <h2>เพิ่มสมุดบัญชี</h2>
                        </div>
                        <div class="card-body p-sm-5">
                            <form id="bankAccountForm" action="add_bank_account.php" method="post">
                                <div class="mb-3 d-flex">
                                    <div class="col-9 mb-6">
                                        <input class="form-control" type="text" name="account_name" placeholder="ชื่อบัญชีธนาคาร" />
                                    </div>
                                    <div class="col-3 mb-3 ps-3">
                                        <input class="form-control" type="text" name="account_name" placeholder="ชื่อตัวย่อ" />
                                    </div>
                                </div>
                                <div class="mb-3 d-flex">
                                    <div class="col-9 mb-6">
                                        <input class="form-control" type="text" name="account_number" placeholder="เลขที่บัญชี xxx-x-xxxx-x" />
                                    </div>
                                    <div class="col-3 mb-3 ps-3">
                                        <input class="form-control" type="text" name="account_name" placeholder="xxxx-x" />
                                    </div>
                                </div>
                                <div class="mb-3"><input class="form-control" type="text" name="account_type" placeholder="ออมทรัพย์" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="bank_name" placeholder="ยอดเริ่มต้น" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="bank_name" placeholder="หมายเหตุ" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="bank_name" placeholder="เลือกวันที่" /></div>

                                <div class="mb-3 d-flex justify-content-center">
                                    <button class="btn btn-primary mt-3 m-3" type="submit" name="submit" style="background-color: #0097b2;">บันทึก</button>
                                    <button class="btn btn-danger mt-3 ml-2 m-3" type="button" name="cancel">ยกเลิก</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#bankAccountForm").submit(function(e) {
                e.preventDefault();

                // Perform the form submission using AJAX
                $.ajax({
                    type: "POST",
                    url: "add_bank_account_process.php", // Point this to the correct processing file
                    data: $("#bankAccountForm").serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // Show success SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Account added successfully!',
                            }).then(() => {
                                window.location.href = 'add_bank_account.php';
                            });
                        } else {
                            // Show error SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
</body>

</html>