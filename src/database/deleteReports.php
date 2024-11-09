<?php
require_once "./DefaultRequestController.php";

header('Content-Type: application/json; charset=utf-8');

try {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if ($id === null) {
        throw new Exception("ID не указан или некорректен.");
    }

    $db = new DefaultRequestController();
    $connect = $db->getConnection();

    // Формируем запрос на удаление отчета
    $query = "DELETE FROM Reports WHERE id = $id";
    $result = $db->executeQuery($query);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => "Отчет с ID $id был удален."
        ], JSON_UNESCAPED_UNICODE);
    } else {
        throw new Exception("Ошибка при удалении отчета.");
    }

    $db->closeConnection();

} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
