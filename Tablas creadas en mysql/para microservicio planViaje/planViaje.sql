CREATE TABLE planViaje(
    -> id INT AUTO_INCREMENT PRIMARY KEY,
    -> ciudad VARCHAR(255) NOT NULL,
    -> vuelo VARCHAR(255) NOT NULL,
    -> hotel VARCHAR(255) NOT NULL,
    -> costo DECIMAL(10, 2) NOT NULL,
    -> usuario INT NOT NULL
    -> );