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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> <!-- Add this line -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake/build/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake/build/pdfmake.min.js"></script>

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
                                    <h3>Transferable Report</h3>
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
                                    <button id="reportBtn" class="btn btn-primary d-block w-100 mt-3" type="button">Report</button>
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

            function generatePDF() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var transactionType = 'Transfer';

                // Fetch data from the server
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
                        // Define the content for the PDF
                        var pdfContent = {
                            content: [],
                            styles: {
                                header: {
                                    fontSize: 18,
                                    bold: true,
                                    margin: [0, 0, 0, 10]
                                },
                                subheader: {
                                    fontSize: 14,
                                    bold: true,
                                    margin: [0, 10, 0, 5]
                                },
                                pageNumber: {
                                    fontSize: 12,
                                    margin: [0, 10, 0, 10],
                                    alignment: 'center'
                                },
                                totalRow: {
                                    fontSize: 12,
                                    bold: true,
                                    margin: [0, 10, 0, 10],
                                    alignment: 'right'
                                }
                            }
                        };

                        var totalBalance = 0;

                        // Add content for each page
                        for (var i = 0; i < data.length; i += 2) {
                            var pageData = data.slice(i, i + 2);

                            // Calculate total balance for the page
                            var pageTotalBalance = pageData.reduce(function(total, item) {
                                return total + parseFloat(item.balance);
                            }, 0);

                            totalBalance += pageTotalBalance;

                            pdfContent.content.push({
                                columns: [{
                                        text: startDate + ' - ' + endDate,
                                        style: 'leftColumn'
                                    },
                                    {
                                        text: 'Report',
                                        style: 'centerColumn',
                                        alignment: 'center'
                                    },
                                    {
                                        text: 'Transfer',
                                        style: 'rightColumn',
                                        alignment: 'right'
                                    }
                                ]
                            }, {
                                table: {
                                    headerRows: 1,
                                    widths: ['auto', 'auto', 'auto', 'auto', 'auto', 'auto', 'auto'],
                                    body: [
                                        ['ID', 'Type', 'From Account No', 'To Account No', 'Cheq No', 'Transaction Date', 'Balance'],
                                        // Iterate over pageData and add rows
                                        ...pageData.map(item => [item.id, item.transaction_type, item.from_account_no, item.to_account_no, item.cheq_no, moment(item.transaction_date).format('DD-MM-YYYY'), item.balance])
                                    ]
                                }
                            });

                            // Add total row for the page
                            pdfContent.content.push({
                                text: 'Total Balance for Page ' + ((i / 2) + 1) + ': ' + pageTotalBalance.toFixed(2),
                                style: 'totalRow'
                            });

                            // Add page number
                            pdfContent.content.push({
                                text: 'Page ' + ((i / 2) + 1),
                                style: 'pageNumber'
                            });

                            // Add a page break if there are more pages
                            if (i + 2 < data.length) {
                                pdfContent.content.push({
                                    text: '',
                                    pageBreak: 'after'
                                });
                            }
                        }

                        // Add total row for the entire document
                        pdfContent.content.push({
                            text: 'Total: ' + totalBalance.toFixed(2),
                            style: 'totalRow'
                        });

                        // Generate the PDF
                        pdfMake.createPdf(pdfContent).download('transaction_report.pdf');
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
                });
            }

            // Attach click event to the report button
            $('#reportBtn').on('click', function() {
                generatePDF();
            });

            // Function to fetch and display data
            function fetchData() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var transactionType = 'Transfer';

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

                        $.each(data, function(index, item) {
                            // Convert transaction_date to dd-mm-yyyy format
                            var formattedDate = moment(item.transaction_date).format('DD-MM-YYYY');

                            $("#transactionTable tbody").append(
                                "<tr>" +
                                "<td>" + item.id + "</td>" +
                                "<td>" + item.transaction_type + "</td>" +
                                "<td>" + item.from_account_no + "</td>" +
                                "<td>" + item.to_account_no + "</td>" +
                                "<td>" + item.cheq_no + "</td>" +
                                "<td>" + formattedDate + "</td>" + // Use the formatted date here
                                "<td>" + item.balance + "</td>" +
                                "</tr>"
                            );
                        });
                    },
                    error: function() {
                        console.error("Error fetching data.");
                    }
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