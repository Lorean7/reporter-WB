<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {

        $db = new DefaultRequestController();
        $connect = $db->getConnection();

        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

        if (empty($endDate)) {
            $endDate = $startDate;
        }

        $query = "DELETE FROM Reports WHERE date_create BETWEEN '$startDate' AND '$endDate'";

        if ($connect->query($query) === TRUE) {
            $db->closeConnection();
            $response = [
                'status' => 'success',
                'message' => 'Записи успешно удалены.'
            ];
        } else {
            $db->closeConnection();
            throw new Exception("Ошибка выполнения запроса: " . $connect->error);
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
