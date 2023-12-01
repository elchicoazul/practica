-- Creación de la tabla de Usuario
CREATE TABLE User (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  role varchar(255) NOT NULL,
  password VARCHAR(255),
  dni_ruc VARCHAR(255) NOT NULL,
  gold_law DECIMAL(10,2),
  tailings_law DECIMAL(10,2),
  fine_gold_to_deliver DECIMAL(10,2),
  pine_silver_to_deliver DECIMAL(10,2),
  gold_discount DECIMAL(10,2),
  silver_discount DECIMAL(10,2),
  -- comentario
  /*date_creation date,
  date_update date,
  user_creation int,
  user_update int,*/
);

-- Creación de la tabla de Servicio
CREATE TABLE Service (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL
);

-- Creación de la tabla de Configuración
CREATE TABLE Configuration (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  value DECIMAL(10,2) NOT NULL,
);

-- Creación de la tabla de Guía de Ingreso
CREATE TABLE IngressGuideTemp (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  gross_weight DECIMAL(10, 2),
  tare_weight DECIMAL(10, 2),
  sample_weight DECIMAL(10, 2),
  wet_weight DECIMAL(10, 2),
  moisture_percentage DECIMAL(5, 2),
  dry_weight DECIMAL(10, 2),
  FOREIGN KEY (user_id) REFERENCES User(id)
);
CREATE TABLE IngressGuide (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  gross_weight DECIMAL(10, 2),
  tare_weight DECIMAL(10, 2),
  sample_weight DECIMAL(10, 2),
  wet_weight DECIMAL(10, 2),
  moisture_percentage DECIMAL(5, 2),
  dry_weight DECIMAL(10, 2),
  FOREIGN KEY (user_id) REFERENCES User(id)
);


-- Creación de la tabla de Liquidación
CREATE TABLE Liquidation (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  reception_id INT NOT NULL,
  date DATETIME NOT NULL,
  FOREIGN KEY (client_id) REFERENCES User(id)
  -- Aquí se deben agregar campos adicionales según la negociación y su respectivo tipo de dato.
);

-- Creación de la tabla de Detalle de Liquidación
CREATE TABLE LiquidationDetail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  liquidation_id INT NOT NULL,
  element VARCHAR(255) NOT NULL,
  office_law DECIMAL(10,2) NOT NULL,
  client_law DECIMAL(10,2) NOT NULL,
  difference DECIMAL(10,2) NOT NULL,
  final_law DECIMAL(10,2) NOT NULL,
  net_kg DECIMAL(10,2) NOT NULL,
  general_law_result DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (liquidation_id) REFERENCES Liquidation(id)
);

-- Creación de la tabla de Producto
CREATE TABLE Product (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  stock varchar(255) Not NULL
  
  -- Aquí se deben agregar atributos para kárdex si son necesarios.
);

-- Creación de la tabla de Programación
CREATE TABLE Scheduling (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  product_id INT NOT NULL,
  service_id INT NOT NULL,
  cash_advance DECIMAL(10,2),
  debt DECIMAL(10,2),
  FOREIGN KEY (client_id) REFERENCES User(id),
  FOREIGN KEY (product_id) REFERENCES Product(id),
  FOREIGN KEY (service_id) REFERENCES Service(id)
);

-- Creación de la tabla de Saldo de Cuentas
CREATE TABLE AccountBalance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  liquidation_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (client_id) REFERENCES User(id),
  FOREIGN KEY (liquidation_id) REFERENCES Liquidation(id)
);

-- Creación de la tabla de Detalle de Transacción
CREATE TABLE TransactionDetail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_balance_id INT NOT NULL,
  service_id INT NOT NULL,
  product_id INT NOT NULL,
  scheduling_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (account_balance_id) REFERENCES AccountBalance(id),
  FOREIGN KEY (service_id) REFERENCES Service(id),
  FOREIGN KEY (product_id) REFERENCES Product(id),
  FOREIGN KEY (scheduling_id) REFERENCES Scheduling(id)
);
