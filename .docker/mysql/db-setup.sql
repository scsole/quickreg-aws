CREATE TABLE registrations (
    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender ENUM('female', 'male') NOT NULL,
    dob DATE NOT NULL,
    club VARCHAR(255),
    email_address VARCHAR(254) NOT NULL,
    medical_conditions VARCHAR(255),
    emergency_contact_name VARCHAR(255) NOT NULL,
    emergency_contact_number VARCHAR(40) NOT NULL,
    registration_timestamp DATETIME NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT uc_dame_dob UNIQUE (first_name, last_name, dob)
);

INSERT INTO `registrations` (`first_name`, `last_name`, `gender`, `dob`, `club`, `email_address`, `medical_conditions`, `emergency_contact_name`, `emergency_contact_number`, `registration_timestamp`) VALUES
('Example1', 'Person', 'female', '1999-09-19', NULL, 'example1@mail.com', NULL, 'EmergencyContact0', '000 111 2222', NOW()),
('Example2', 'Person', 'male', '1999-09-19', 'Club1', 'example2@mail.com', NULL, 'EmergencyContact0', '000 111 2222', NOW()),
('Example3', 'Person', 'female', '1999-09-19', NULL, 'example1@mail.com', NULL, 'EmergencyContact1', '000 222 2222', NOW()),
('Example4', 'Person', 'male', '1999-09-19', NULL, 'example3@mail.com', NULL, 'EmergencyContact2', '+64 00 333 2222', NOW()),
('Example5', 'Person', 'female', '1999-09-19', 'Club1', 'example4@mail.com', NULL, 'EmergencyContact1', '000 222 2222', NOW()),
('Example6', 'Person', 'male', '1999-09-19', NULL, 'example5@mail.com', NULL, 'EmergencyContact2', '+64 00 333 2222', NOW()),
('Example7', 'Person', 'female', '1999-09-19', 'Club2', 'example6@mail.com', NULL, 'EmergencyContact3', '(+64) 021 222 2222', NOW()),
('Example8', 'Person', 'male', '1999-09-19', 'Club2', 'example7@mail.com', NULL, 'EmergencyContact2', '+64 00 333 2222', NOW());