<?php
class DefaultRequestController
{
    private $host = 'mysql';
    private $user = 'root';
    private $pass = 'root';
    private $db = 'projectWB';

    private $connect;
    public function getConnection()
    {
        try {
            $this->connect = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
            $this->connect->set_charset("utf8");

            if (!$this->connect) { // Проверяем, успешно ли произошло подключение
                throw new Exception("Ошибка подключения: " . mysqli_connect_error());
            }

            return $this->connect;
        } catch (exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'DB LOCK'
            ];

            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function closeConnection()
    {
        if ($this->connect) {
            $this->connect->close();
        }
    }

    public function executeQuery($query)
    {
        if (!$this->connect) {
            $this->getConnection();
        }

        $result = $this->connect->query($query);

        if (!$result) {
            throw new Exception("Ошибка выполнения запроса: " . $this->connect->error);
        }

        return $result;
    }
}
