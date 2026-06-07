<?php

require_once 'Database.php';
require_once 'CRUDInterface.php';

class Payment extends Database implements CRUDInterface
{
    public function create($data)
    {
        $conn = $this->getConnection();
        $reservationId = (int) $data['reservation_id'];
        $amount = (float) $data['amount'];
        $cardNumber = mysqli_real_escape_string($conn, $data['card_number']);
        $status = mysqli_real_escape_string($conn, $data['status']);

        $sql = "INSERT INTO payments (reservation_id, amount, card_number, status) VALUES ($reservationId, $amount, '$cardNumber', '$status')";
        return mysqli_query($conn, $sql);
    }

    public function read($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT * FROM payments WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function update($id, $data)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $amount = (float) $data['amount'];
        $status = mysqli_real_escape_string($conn, $data['status']);

        $sql = "UPDATE payments SET amount = $amount, status = '$status' WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function delete($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "DELETE FROM payments WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function sumTotal()
    {
        $conn = $this->getConnection();
        $sql = "SELECT SUM(amount) AS total FROM payments WHERE status = 'placeno'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }

    public function sumToday()
    {
        $conn = $this->getConnection();
        $sql = "SELECT SUM(amount) AS total FROM payments WHERE status = 'placeno' AND DATE(payment_date) = CURDATE()";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }

    public function sumThisWeek()
    {
        $conn = $this->getConnection();
        $sql = "SELECT SUM(amount) AS total FROM payments WHERE status = 'placeno' AND YEARWEEK(payment_date, 1) = YEARWEEK(CURDATE(), 1)";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }

    public function sumThisMonth()
    {
        $conn = $this->getConnection();
        $sql = "SELECT SUM(amount) AS total FROM payments WHERE status = 'placeno' AND YEAR(payment_date) = YEAR(CURDATE()) AND MONTH(payment_date) = MONTH(CURDATE())";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    }

}
