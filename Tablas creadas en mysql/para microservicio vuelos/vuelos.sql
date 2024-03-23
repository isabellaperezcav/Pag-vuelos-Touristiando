CREATE TABLE vuelos(
    -> id INT PRIMARY KEY AUTO_INCREMENT,
    -> ciudadOrigen VARCHAR(100),
    -> ciudadDestino VARCHAR(100),
    -> capacidad int,
    -> costo decimal(10,2)
    -> );