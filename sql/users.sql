-- Author: Kingsly Bude
DROP TABLE IF EXISTS users;
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE EXTENSION IF NOT EXISTS pgcrypto;
CREATE SEQUENCE users_id_seq START 1;

CREATE TABLE users(
    id INT PRIMARY KEY DEFAULT nextval('users_id_seq'),
    emailAddress VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    firstName VARCHAR(40),
    lastName VARCHAR(40),
    enrollDate TIMESTAMP,
    lastAccess TIMESTAMP,
    phoneExt INT,
    type VARCHAR(2),
    isActive BOOLEAN
);

INSERT INTO users(emailAddress, password, firstName, lastName, enrollDate, lastAccess, phoneExt, type, isActive)
VALUES(
    'jdoe@dcmail.ca',
    crypt('password', gen_salt('bf')),
    'John',
    'Doe',
    '2014-06-22 19:10:25',
    '2014-06-22 19:10:26',
    9,
    'a',
    TRUE
);

INSERT INTO users(emailAddress, password, firstName, lastName, enrollDate, lastAccess, phoneExt, type,isActive)
VALUES(
    'TestOne@gmail.com',
    crypt('password', gen_salt('bf')),
    'ExampleOne',
    'SalespersonOne',
    '2015-06-22 19:10:25',
    '2015-06-22 19:10:26',
    32,
    's',
    TRUE
);

INSERT INTO users(emailAddress, password, firstName, lastName, enrollDate, lastAccess, phoneExt, type,isActive)
VALUES(
    'TestTwo@gmail.com',
    crypt('password', gen_salt('bf')),
    'ExampleTwo',
    'SalespersonTwo',
    '2000-06-22 19:10:25',
    '2000-06-22 19:10:26',
    32,
    's',
    FALSE
);

INSERT INTO users(emailAddress, password, firstName, lastName, enrollDate, lastAccess, phoneExt, type,isActive)
VALUES(
    'kbadmin@rogers.com',
    crypt('password', gen_salt('bf')),
    'Kingsly',
    'Bude',
    '1999-06-22 19:10:25',
    '1999-06-22 19:10:26',
    1,
    'a',
    TRUE
);


SELECT * FROM users;