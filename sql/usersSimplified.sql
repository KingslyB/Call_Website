-- Author: Kingsly Bude
DROP TABLE IF EXISTS users;
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE EXTENSION IF NOT EXISTS pgcrypto;
CREATE SEQUENCE users_id_seq;

CREATE TABLE users(
	id INT PRIMARY KEY DEFAULT nextval('users_id_seq'),
	email VARCHAR(20) NOT NULL,
	password VARCHAR(100) NOT NULL
);
	
INSERT INTO users(email, password)
VALUES('jdoe@gmail.com', crypt('password', gen_salt('bf')));

INSERT INTO users(email, password)
VALUES('jdoe2@gmail.com', crypt('password2', gen_salt('bf')));

INSERT INTO users(email, password)
VALUES('jdoe3@gmail.com', crypt('password3', gen_salt('bf')));

INSERT INTO users(email, password)
VALUES('jdoe4@gmail.com', crypt('password4', gen_salt('bf')));