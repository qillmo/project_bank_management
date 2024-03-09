<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['date'], $_POST['cheq_no'], $_POST['from_account_no'], $_POST['to_account_no'], $_POST['balance'])) {
        $dateFromForm = $_POST['date'];
        $dateObject = DateTime::createFromFormat('d/m/Y', $dateFromForm);
        $dateFormatted = $dateObject->format('Y-m-d');
        
        $cheqNo = $_POST['cheq_no'];
        $fromAccountNo = $_POST['from_account_no'];
        $toAccountNo = $_POST['to_account_no'];
        $balance = $_POST['balance'];

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=transaction_db", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO transaction (transaction_type, from_account_no, to_account_no, cheq_no, transaction_date, balance, created_date, updated_date) 
                                   VALUES ('transfer', :fromAccountNo, :toAccountNo, :cheqNo, :date, :balance, NOW(), NOW())");

            // Bind parameters
            $stmt->bindParam(':fromAccountNo', $fromAccountNo);
            $stmt->bindParam(':toAccountNo', $toAccountNo);
            $stmt->bindParam(':cheqNo', $cheqNo);
            $stmt->bindParam(':date', $dateFormatted);
            $stmt->bindParam(':balance', $balance);

            // Execute the query
            $stmt->execute();

            // Close the database connection
            $pdo = null;

            // Send a JSON response indicating success
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            // Send a JSON response indicating failure with the error message and the SQL statement
            echo json_encode(['status' => 'error', 'message' => 'Error adding transaction. ' . $e->getMessage(), 'sql' => $stmt->queryString]);
        }
    } else {
        // Send a JSON response indicating failure if required fields are not set
        echo json_encode(['status' => 'error', 'message' => 'Invalid request. Required fields are not set.']);
    }
} else {
    // Send a JSON response indicating failure for an invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
