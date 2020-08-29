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
