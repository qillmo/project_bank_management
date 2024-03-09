<nav class="navbar" style="background-color: #545454;justify-content: center;">
    <div>
        <a class="navbar-brand text-white" href="#">ระบบบันทึกข้อมูลการเงิน (รายรับ-รายจ่าย)</a>
    </div>
</nav>

<div class="d-flex justify-content-evenly" style="margin: auto; width: 80%; margin-top: 10px;">
    <button type="button" class="btn m-2" style="border-radius: 30px; color: #fff; min-width: 200px; background-color: #64a986;" onclick="location.href='add_bank_account.php'">เพิ่มสมุดบัญชี</button>
    <button type="button" class="btn m-2" style="border-radius: 30px; color: #fff; min-width: 200px; background-color: #0097b2;" onclick="location.href='add_revenue_account.php'">รายรับ</button>
    <button type="button" class="btn m-2" style="border-radius: 30px; color: #fff; min-width: 200px; background-color: #f0595c;" onclick="location.href='add_expenses_account.php'">รายจ่าย</button>
    <button type="button" class="btn m-2" style="border-radius: 30px; color: #fff; min-width: 200px; background-color: #f5ad27;" onclick="location.href='add_transfer_account.php'">โอนเงิน</button>
    <button type="button" class="btn m-2" style="border-radius: 30px; color: #fff; min-width: 200px; background-color: #4f2d2d;" onclick="location.href='report.php'">สรุปบัญชี</button>
</div>

<!-- <div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto text-uppercase f1">
                <li class="nav-item">
                    <a class="nav-link" href="add_bank_account.php" aria-current="page">หน้าเพิ่มบัญชี<br>Add Bank Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_revenue_account.php">หน้าบันทึกการรับ<br>Revenue Accounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_expenses_account.php">หน้าบันทึกการจ่าย<br>Expenses Accounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_transfer_account.php">หน้าบันทึกการโอนเงิน<br>Transfer Accounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="index.php">หน้าค้นหาข้อมูล<br>Show Data</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownReports" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        หน้ารายงาน<br>Report
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownReports">
                        <li><a class="dropdown-item" href="statement_report.php">รายงาน statement</a></li>
                        <li><a class="dropdown-item" href="revenue_report.php">รายงานรายรับ</a></li>
                        <li><a class="dropdown-item" href="expenses_report.php">รายงานรายจ่าย</a></li>
                        <li><a class="dropdown-item" href="transfer_report.php">รายงานโอนเงิน</a></li>
                    </ul>
                </li>
            </ul>
            <button class="btn btn-danger me-2 ms-5 ml-2" type="button" id="logoutBtn">Log-out</button>
            <script>
                $(document).ready(function() {
                    $("#logoutBtn").on("click", function() {
                        // Make an AJAX request to log out
                        $.ajax({
                            type: "POST",
                            url: "logout_process.php", // Point this to your server-side logout script
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    // Redirect to the login page after successful logout
                                    window.location.href = "login.php"; // Change to your login page URL
                                } else {
                                    // Handle error, e.g., show an alert
                                    alert("Logout failed. Please try again.");
                                }
                            },
                            error: function() {
                                // Handle unexpected error, e.g., show an alert
                                alert("An unexpected error occurred. Please try again.");
                            }
                        });
                    });
                });
            </script>

    </div> -->