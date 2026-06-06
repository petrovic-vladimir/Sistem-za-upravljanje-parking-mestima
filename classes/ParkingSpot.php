<?php

require_once 'Database.php';
require_once 'CRUDInterface.php';

class ParkingSpot extends Database implements CRUDInterface
{
    public function create($data)
    {
        $conn = $this->getConnection();
        $spotNumber = mysqli_real_escape_string($conn, $data['spot_number']);
        $status = mysqli_real_escape_string($conn, $data['status']);
        $price = (float) $data['price_per_hour'];

        $sql = "INSERT INTO parking_spots (spot_number, status, price_per_hour) VALUES ('$spotNumber', '$status', $price)";
        return mysqli_query($conn, $sql);
    }

    public function read($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT * FROM parking_spots WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function readAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM parking_spots ORDER BY id ASC";
        return mysqli_query($conn, $sql);
    }

    public function countAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM parking_spots";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function countByStatus($status)
    {
        $conn = $this->getConnection();
        $status = mysqli_real_escape_string($conn, $status);
        $sql = "SELECT COUNT(*) AS total FROM parking_spots WHERE status = '$status'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function changeStatus($id, $status)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $status = mysqli_real_escape_string($conn, $status);
        $sql = "UPDATE parking_spots SET status = '$status' WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function update($id, $data)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $spotNumber = mysqli_real_escape_string($conn, $data['spot_number']);
        $status = mysqli_real_escape_string($conn, $data['status']);
        $price = (float) $data['price_per_hour'];

        $sql = "UPDATE parking_spots SET spot_number = '$spotNumber', status = '$status', price_per_hour = $price WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function delete($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "DELETE FROM parking_spots WHERE id = $id";
        return mysqli_query($conn, $sql);
    }
}
