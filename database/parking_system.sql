CREATE DATABASE IF NOT EXISTS parking_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE parking_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('korisnik', 'admin') NOT NULL DEFAULT 'korisnik',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE parking_spots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    spot_number VARCHAR(10) NOT NULL UNIQUE,
    status ENUM('slobodno', 'zauzeto') NOT NULL DEFAULT 'slobodno',
    price_per_hour DECIMAL(10,2) NOT NULL DEFAULT 100.00
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    parking_spot_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status ENUM('aktivna', 'zavrsena', 'otkazana') NOT NULL DEFAULT 'aktivna',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (parking_spot_id) REFERENCES parking_spots(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    card_number VARCHAR(30) NOT NULL,
    status ENUM('placeno', 'neuspesno') NOT NULL DEFAULT 'placeno',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);

INSERT INTO parking_spots (spot_number, status, price_per_hour) VALUES
('P01', 'slobodno', 100.00),
('P02', 'slobodno', 100.00),
('P03', 'zauzeto', 100.00),
('P04', 'slobodno', 100.00),
('P05', 'slobodno', 100.00),
('P06', 'zauzeto', 100.00),
('P07', 'slobodno', 100.00),
('P08', 'slobodno', 100.00),
('P09', 'zauzeto', 100.00),
('P10', 'slobodno', 100.00),
('P11', 'slobodno', 100.00),
('P12', 'zauzeto', 100.00),
('P13', 'slobodno', 100.00),
('P14', 'slobodno', 100.00),
('P15', 'slobodno', 100.00),
('P16', 'slobodno', 100.00),
('P17', 'zauzeto', 100.00),
('P18', 'slobodno', 100.00),
('P19', 'zauzeto', 100.00),
('P20', 'slobodno', 100.00),
('P21', 'zauzeto', 100.00),
('P22', 'slobodno', 100.00),
('P23', 'slobodno', 100.00),
('P24', 'zauzeto', 100.00);
