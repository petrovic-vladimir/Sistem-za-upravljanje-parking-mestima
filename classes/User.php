<?php

require_once 'Database.php';
require_once 'CRUDInterface.php';

class User extends Database implements CRUDInterface
{
    public function create($data)
    {
        $conn = $this->getConnection();
        $firstName = mysqli_real_escape_string($conn, $data['first_name']);
        $lastName = mysqli_real_escape_string($conn, $data['last_name']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($conn, $data['role']);

        $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES ('$firstName', '$lastName', '$email', '$password', '$role')";
        return mysqli_query($conn, $sql);
    }

    public function read($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT * FROM users WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function update($id, $data)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $firstName = mysqli_real_escape_string($conn, $data['first_name']);
        $lastName = mysqli_real_escape_string($conn, $data['last_name']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $role = mysqli_real_escape_string($conn, $data['role']);

        $sql = "UPDATE users SET first_name = '$firstName', last_name = '$lastName', email = '$email', role = '$role' WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function delete($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "DELETE FROM users WHERE id = $id";
        return mysqli_query($conn, $sql);
    }

    public function findByEmail($email)
    {
        $conn = $this->getConnection();
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        return mysqli_query($conn, $sql);
    }

    public function login($email, $password)
    {
        $result = $this->findByEmail($email);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return false;
    }

    public function readAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users ORDER BY id ASC";
        return mysqli_query($conn, $sql);
    }

    public function countAll()
    {
        $conn = $this->getConnection();
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'korisnik'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    public function hasReservations($id)
    {
        $conn = $this->getConnection();
        $id = (int) $id;
        $sql = "SELECT COUNT(*) AS total FROM reservations WHERE user_id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] > 0;
    }
}

