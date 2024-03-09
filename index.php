<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Data Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        <?php include './css/style.css'; ?>
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="body-main">
            <div class="row flex-center min-vh-100 py-6 justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <div class="row g-3 mb-2">
                                <div class="col-auto">
                                    <h3>Get Data Transaction</h3>
                                </div>

                            </div>
                            <div class="row g-3 mb-2">
                                <div class="col-auto">
                                    <label for="startDate" class="form-label">Start Date:</label>
                                    <input type="text" class="form-control datepicker" id="startDate" placeholder="Start Date">
                                </div>
                                <div class="col-auto">
                                    <label for="endDate" class="form-label">End Date:</label>
                                    <input type="text" class="form-control datepicker" id="endDate" placeholder="End Date">
                                </div>
                                <div class="col-auto">
                                    <label for="transactionType" class="form-label">Transaction Type:</label>
                                    <select class="form-select" id="transactionType">
                                        <option value="">All</option>
                                        <option value="Deposit">Deposit</option>
                                        <option value="Receiveable">Receiveable</option>
                                        <option value="Transfer">Transfer</option>
                                        <!-- Add other transaction types as needed -->
                                    </select>
                                </div>
                            </div>

                            <!-- Modify the table definition -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="transactionTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>From Account No</th>
                                            <th>To Account No</th>
                                            <th>Cheq No</th>
                                            <th>Transaction Date</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });

            // Function to fetch and display data
            function fetchData() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var transactionType = $('#transactionType').val();

                $.ajax({
                    type: "GET",
                    url: "getData.php",
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        transactionType: transactionType
                    },
                    dataType: "json",
                    success: function(data) {
                        // Clear existing rows
                        $("#transactionTable tbody").empty();

                        // Populate table with fetched data
                        $.each(data, function(index, item) {
                            $("#transactionTable tbody").append(
                                "<tr>" +
                                "<td>" + item.id + "</td>" +
                                "<td>" + item.transaction_type + "</td>" +
                                "<td>" + item.from_account_no + "</td>" +
                                "<td>" + item.to_account_no + "</td>" +
                                "<td>" + item.cheq_no + "</td>" +
                                "<td>" + item.transaction_date + "</td>" +
                                "<td>" + item.balance + "</td>" +
                                "</tr>"
                            );
                        });
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
                    // error: function(textStatus) {
                    //     // Log the SQL command
                    //     console.log("SQL Command:", textStatus.responseText);

                    // }
                });
            }

            // Fetch data on page load
            fetchData();

            // Apply filters on input change
            $('#startDate, #endDate, #transactionType').on('change', function() {
                fetchData();
            });
        });
    </script>
</body>

</html>