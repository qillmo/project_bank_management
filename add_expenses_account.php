<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bank Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <style>
        <?php include './css/style.css'; ?>
    </style>
</head>
<!-- กรอกข้อมูล
Date
Type = receiveable
Cheq No.
From Bank Account No
To Bank Account No
Balance -->

<body>
    <?php include 'header.php'; ?>
    <!-- <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 py-6 justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>Add Expenses Account</h2>
                        </div>
                        <div class="card-body p-4 p-sm-5">
                            <form id="bankExpensesForm" action="add_expenses_account_process.php" method="post">
                                <div class="input-group date datepicker mb-3">
                                    <input class="form-control" type="text" name="date" placeholder="Date" />
                                    <span class="input-group-append d-flex align-middle">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                                <div class="mb-3"><input class="form-control" type="text" placeholder="Type" value="Deposit" disabled /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="cheq_no" placeholder="Cheq No" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="from_account_no" placeholder="From Bank Account No" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="to_account_no" placeholder="To Bank Account No" /></div>
                                <div class="mb-3"><input class="form-control custom4" type="text" name="balance" placeholder="Balance"></div>
                                <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 my-5 justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <div class="card" style="border-radius: 2rem;background-color:#fbeff2;">
                        <div class="text-center" style="margin-top: 30px;background-color: #f0595c;color:#fff;">
                            <h2>รายจ่าย (Payable)</h2>
                        </div>
                        <div class="card-body p-sm-5">
                            <form id="bankAccountForm" action="add_bank_account.php" method="post">
                                <div class="mb-3"><input class="form-control" type="text" name="bank_name" placeholder="เลือกวันที่" /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="cheq_no" placeholder="หมายเลขเช็ค Cheq No." /></div>
                                <div class="mb-3"><input class="form-control" type="text" name="to_account_no" placeholder="จ่ายเงินจากบัญชี xxxx-x (5 ตัวหลัง)" /></div>
                                <div class="mb-3 d-flex">
                                    <div class="col-9 mb-6">
                                        <input class="form-control" type="text" name="account_name" placeholder="ชื่อบัญชีธนาคาร" />
                                    </div>
                                    <div class="col-3 mb-3 ps-3">
                                        <input class="form-control" type="text" name="account_name" placeholder="ชื่อตัวย่อ" />
                                    </div>
                                </div>
                                <div class="mb-3"><input class="form-control custom4" type="text" name="balance" placeholder="ยอดเงิน"></div>
                                <div class="mb-3"><input class="form-control" type="text" name="bank_name" placeholder="หมายเหตุ" /></div>
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
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy', // Format that you want
                autoclose: true
            });

            $(function() {
                $('.custom4').maskMoney();
            })
            
            $("#bankExpensesForm").submit(function(e) {
                e.preventDefault();
                // Perform the form submission using AJAX
                $.ajax({
                    type: "POST",
                    url: "add_expenses_account_process.php", // Point this to the correct processing file
                    data: $("#bankExpensesForm").serialize(),
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