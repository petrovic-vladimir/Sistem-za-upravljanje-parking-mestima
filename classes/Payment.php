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
}
