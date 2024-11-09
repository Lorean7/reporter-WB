<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db =   new DefaultRequestController();
        $connect =  $db->getConnection();

        $create_date = $connect->real_escape_string($_POST['create_date']);
        $box_number = $connect->real_escape_string($_POST['box_number']);
        $product_count = (int)$_POST['product_count'];
        $time_close = $connect->real_escape_string($_POST['time_close']);
        $worker = $connect->real_escape_string($_POST['worker']);
        $comment = $connect->real_escape_string($_POST['comment']);

        $query = "INSERT INTO Reports (date_create, box_number, product_count, time_close, worker, comment) 
      VALUES ('$create_date', '$box_number', $product_count, '$time_close', '$worker', '$comment')";

        if ($connect->query($query) === TRUE) {
            $db->closeConnection();
            $response = [
                'status' => 'ok',
                'message' => 'Данные успешно сохранены.'
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