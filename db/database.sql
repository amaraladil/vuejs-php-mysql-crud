-- Setting up the database and tables for this web application
-- Author: Amar Al-Adil
-- 
-- REQUIREMENT:
-- > change the database name to a different fitting name if required
create database vue_php_db;
use vue_php_db;

CREATE TABLE categories (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE documents (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

INSERT INTO categories(category)
VALUES
	('Personal Documents'),
	('Canadian Entity Documents'),
    ('Current Entity Documents');
    
INSERT INTO documents(category_id, name)
VALUES
	(1, 'Passport'),
	(1, 'Photo'),
    (2, 'North American Client List'),
    (2, 'Potential Clients in North America'),
    (2, 'Business Letters Support'),
    (3, 'Vendor Contracts'),
    (3, 'Lease Contracts'),
    (3, 'Technology and Intellectual Property');