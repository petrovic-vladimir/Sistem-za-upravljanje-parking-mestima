<?php

require_once 'Database.php';
require_once 'CRUDInterface.php';

class Reservation extends Database implements CRUDInterface
{
    public function create($data)
    {
        $conn = $this->getConnection();
        $userId = (int) $data['user_id'];
        $parkingSpotId = (int) $data['parking_spot_id'];
        $startTime = mysqli_real_escape_string($conn, $data['start_time']);
        $endTime = mysqli_real_escape_string($conn, $data['end_time']);
        $status = mysqli_real_escape_string($conn, $data['status']);

        $sql = "INSERT INTO reservations (user_id, parking_spot_id, start_time, end_time, status) VALUES ($userId, $parkingSpotId, '$startTime', '$endTime', '$status')";
        return mysqli_query($conn, $sql);
    }

    public function getLastId()
    {
        $conn = $this->getConnection();
        return mysqli_insert_id($conn);
    }

    public function read($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT * FROM reservations WHERE id = $id";
        return mysqli_query($conn, $sql);
    }


    public function readWithDetails($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT reservations.*, parking_spots.spot_number, parking_spots.price_per_hour FROM reservations INNER JOIN parking_spots ON reservations.parking_spot_id = parking_spots.id WHERE reservations.id = $id";
        return mysqli_query($conn, $sql);
    }

    public function readAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT reservations.*, users.first_name, users.last_name, parking_spots.spot_number FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN parking_spots ON reservations.parking_spot_id = parking_spots.id ORDER BY reservations.id DESC";
        return mysqli_query($conn, $sql);
    }

    public function update($id, $data)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $startTime = mysqli_real_escape_string($conn, $data['start_time']);
        $endTime = mysqli_real_escape_string($conn, $data['end_time']);
        $status = mysqli_real_escape_string($conn, $data['status']);

        $sql = "UPDATE reservations SET start_time = '$startTime', end_time = '$endTime', status = '$status' WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function delete($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "DELETE FROM reservations WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function countAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM reservations";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function readLatest($limit = 5)
    {
        $conn = $this->getConnection();
        $limit = (int) $limit;
        $sql = "SELECT reservations.*, users.first_name, users.last_name, parking_spots.spot_number FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN parking_spots ON reservations.parking_spot_id = parking_spots.id ORDER BY reservations.id DESC LIMIT $limit";
        return mysqli_query($conn, $sql);
    }
}
