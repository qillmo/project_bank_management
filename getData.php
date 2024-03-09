<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=transaction_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Build the SQL query based on filters
    $sql = "SELECT * FROM transaction WHERE 1";
    if (isset($_GET['startDate']) && $_GET['startDate'] !== '') {
        $dateFromForm = $_GET['startDate'];
        $dateObject = DateTime::createFromFormat('d-m-Y', $dateFromForm);
        $dateFormatted = $dateObject ? $dateObject->format('Y-m-d') : null;
        if ($dateFormatted) {
            $sql .= " AND transaction_date >= :startDate";
        }
    }
    if (isset($_GET['endDate']) && $_GET['endDate'] !== '') {
        $dateToForm = $_GET['endDate'];
        $dateToObject = DateTime::createFromFormat('d-m-Y', $dateToForm);
        $dateToFormatted = $dateToObject ? $dateToObject->format('Y-m-d') : null;
        if ($dateToFormatted) {
            $sql .= " AND transaction_date <= :endDate";
        }
    }
    if (isset($_GET['transactionType']) && $_GET['transactionType'] !== '') {
        $sql .= " AND transaction_type = :transactionType";
    }

    //echo "$sql".$dateFormatted.$dateToFormatted;
    
    // Fetch data from the transaction table
    $stmt = $pdo->prepare($sql);

    // Bind parameters if they are set
    if (isset($_GET['startDate']) && $_GET['startDate'] !== '') {
        $stmt->bindParam(':startDate', $dateFormatted, PDO::PARAM_STR);
    }
    if (isset($_GET['endDate']) && $_GET['endDate'] !== '') {
        $stmt->bindParam(':endDate', $dateToFormatted, PDO::PARAM_STR);
    }
    if (isset($_GET['transactionType']) && $_GET['transactionType'] !== '') {
        $stmt->bindParam(':transactionType', $_GET['transactionType'], PDO::PARAM_STR);
    }

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $pdo = null;

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Log the error to the console
    error_log('Error: ' . $e->getMessage());

    // Send a JSON response indicating failure
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error fetching data.']);
}
?>
