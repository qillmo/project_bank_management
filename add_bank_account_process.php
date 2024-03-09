<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['account_number'], $_POST['bank_name'], $_POST['account_type'])) {
        // Retrieve form data
        $accountNumber = $_POST['account_number'];
        $bankName = $_POST['bank_name'];
        $accountType = $_POST['account_type'];

        try {
            $pdo = new PDO("mysql:host=localhost;dbname=transaction_db", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO account (account_no, bank_name, account_type, status, created_date, updated_date) VALUES (:accountNo, :bankName, :accountType, 1, NOW(), NOW())");

            $stmt->bindParam(':accountNo', $accountNumber);
            $stmt->bindParam(':bankName', $bankName);
            $stmt->bindParam(':accountType', $accountType);
            $stmt->execute();

            // Close the database connection
            $pdo = null;

            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error adding account. ' . $e->getMessage(), 'sql' => $stmt->queryString]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request. Required fields are not set.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
