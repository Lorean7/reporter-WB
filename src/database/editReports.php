<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db =   new DefaultRequestController();
        $connect =  $db->getConnection();

        $id = $_POST['id'];
        $date_create = $_POST['date_create'];
        $box_number = $_POST['box_number'];
        $product_count = $_POST['product_count'];
        $time_close = $_POST['time_close'];
        $worker = $_POST['worker'];
        $comment = $_POST['comment'];

        $updateQuery = "UPDATE Reports 
                SET date_create = '$date_create',
                    box_number = '$box_number',
                    product_count = '$product_count',
                    time_close = '$time_close',
                    worker = '$worker',
                    comment = '$comment'
                    WHERE id = '$id'";

        if ($connect->query($updateQuery)) {
            $db->closeConnection();
            $response = [
                'status' => 'success',
                'message' => 'Перезаписано',
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
            'message' => 'error data' . $e->getMessage(),
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}