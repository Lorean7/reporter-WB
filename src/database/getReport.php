<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db =   new DefaultRequestController();
        $connect =  $db->getConnection();

        $id = $connect->real_escape_string($_GET['id']);

        $query = "SELECT * FROM Reports WHERE id = '$id'";

        $result = $connect->query($query);

        if ($connect->query($query)) {
            $db->closeConnection();
            $response = [
                'status' => 'success',
                'message' => 'Запись получена',
                'report' => $result->fetch_assoc()
            ];
        } else {
            $db->closeConnection();
            throw new Exception("Ошибка выполнения запроса: " . $connect->error);
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }catch (exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'error data'
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}