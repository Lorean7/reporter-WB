<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Параметры дат
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

try {
    if (empty($startDate)) {
        throw new Exception("Не указана начальная дата.");
    }

    if (empty($endDate)) {
        $endDate = $startDate;
    }

    $db = new DefaultRequestController();
    $connect = $db->getConnection();

    $totalQuery = "SELECT COUNT(*) AS total FROM Reports WHERE date_create BETWEEN '$startDate' AND '$endDate'";
    $result = $db->executeQuery($totalQuery);
    $total = $result->fetch_assoc()['total'];

    $query = "SELECT * FROM Reports WHERE date_create BETWEEN '$startDate' AND '$endDate' LIMIT $limit OFFSET $offset";
    $result = $db->executeQuery($query);

    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }

    $db->closeConnection();

    echo json_encode([
        'data' => $reports,
        'total' => $total,
        'limit' => $limit,
        'page' => $page
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
