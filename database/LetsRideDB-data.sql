/* Customers */
INSERT INTO customer (customer_id, first_name, last_name, email, phone_number, password, balance, picture, address_id) VALUES
(1, 'Rider', 'Bot1', 'r1@r.com', '1111111111', 'pass', 100, NULL, NULL),
(2, 'Rider', 'Bot2', 'r2@r.com', '2222222222', 'pass', 100, NULL, NULL),
(3, 'Rider', 'Bot3', 'r3@r.com', '3333333333', 'pass', 100, NULL, NULL),
(4, 'Rider', 'Bot4', 'r4@r.com', '4444444444', 'pass', 100, NULL, NULL),
(5, 'Rider', 'Bot5', 'r5@r.com', '5555555555', 'pass', 100, NULL, NULL);

/* Vehicles */
INSERT INTO vehicle (vehicle_id, license_plate, make, model, year, color) VALUES
(1, '5UMH719', 'Honda', 'Accord ', 2013, 'Black'),
(2, '6MBV006', 'Toyota', 'Prius', 2014, 'Silver'),
(3, '5AOJ230', 'Honda', 'Civic', 2010, 'Gray'),
(4, '4SAM123', 'Hyundai', 'Tuscon', 2012, 'Orange'),
(5, '2CMK720', 'Toyota', 'Camry', 2008, 'Red');

/* Drivers */
INSERT INTO driver (driver_id, first_name, last_name, email, phone_number, password, balance, picture, address_id, vehicle_id) VALUES
(1, 'Driver', 'Bot1', 'd1@d.com', '1111111110', 'pass', 100, NULL, NULL, 1),
(2, 'Driver', 'Bot2', 'd2@d.com', '2222222220', 'pass', 100, NULL, NULL, 2),
(3, 'Driver', 'Bot3', 'd3@d.com', '3333333330', 'pass', 100, NULL, NULL, 3),
(4, 'Driver', 'Bot4', 'd4@d.com', '4444444440', 'pass', 100, NULL, NULL, 4),
(5, 'Driver', 'Bot5', 'd5@d.com', '5555555550', 'pass', 100, NULL, NULL, 5);




