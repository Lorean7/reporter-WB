<?php
require_once "./DefaultRequestController.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db =   new DefaultRequestController();
        $connect =  $db->getConnection();

        $start_date = $connect->real_escape_string($_GET['start_date']);
        $end_date = $start_date;
        if (!empty($_GET['end_date'])){
            $end_date = $_GET['end_date'];
        }

        $sql = "SELECT *
                FROM Reports
                WHERE date_create BETWEEN '$start_date' AND '$end_date';";

        $result = $connect->query($sql);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        if ($data) {
            $response = [
                'status' => 'ok',
                'message' => 'Данные успешно сохранены.Пожалуйста подождите файл создается'
            ];
        } else {
            $response = [
                'status' => 'ok',
                'message' => 'Данные отсутствуют'
            ];
            throw new Exception("Ошибка выполнения запроса: " . $connect->error);
        }

        $db->closeConnection();
        echo json_encode($response, JSON_UNESCAPED_UNICODE);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Дата создания',
            'B1' => 'Номер коробки',
            'C1' => 'Количество продуктов',
            'D1' => 'Время закрытия',
            'E1' => 'Работник',
            'F1' => 'Комментарий'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
            $sheet->getStyle($cell)->getFont()->setBold(true)->setColor(new Color(Color::COLOR_WHITE));
            $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4F81BD');
        }

        $row = 2;
        foreach ($data as $record) {
            $sheet->setCellValue("A{$row}", $record['date_create']);
            $sheet->setCellValue("B{$row}", $record['box_number']);
            $sheet->setCellValue("C{$row}", $record['product_count']);
            $sheet->setCellValue("D{$row}", $record['time_close']);
            $sheet->setCellValue("E{$row}", $record['worker']);
            $sheet->setCellValue("F{$row}", $record['comment']);
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $desktopPath = getenv('USERPROFILE') . '\\Desktop\\Отчеты';
            if (!is_dir($desktopPath)) {
                mkdir($desktopPath, 0777, true);
            }
            $filename = $desktopPath . "\\Отчет-{$start_date}-{$end_date}.xlsx";
        } else {
            $desktopPath = __DIR__ . '../../Отчеты';
            if (!is_dir($desktopPath)) {
                mkdir($desktopPath, 0777, true);
            }
            $filename = $desktopPath . "/Отчет-{$start_date}-{$end_date}.xlsx";
        }

        if (file_exists($filename)) {
            unlink($filename);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
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