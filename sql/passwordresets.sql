--AUTHOR: Kingsly Bude
DROP TABLE IF EXISTS passwordresets;
DROP SEQUENCE  IF EXISTS  attempt_id_seq;
CREATE SEQUENCE attempt_id_seq START 10001;



CREATE TABLE passwordresets(
    attemptid INT PRIMARY KEY DEFAULT nextval('attempt_id_seq'),
    startdate TIMESTAMP NOT NULL,
    enddate TIMESTAMP  NOT NULL,
    used BOOLEAN DEFAULT false NOT NULL,
    emailaddress VARCHAR(100) NOT NULL,
    userid INT NOT NULL references users(id)

);