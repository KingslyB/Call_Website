DROP TABLE IF EXISTS passwordresets;

CREATE TABLE passwordresets(
    startdate TIMESTAMP NOT NULL,
    enddate TIMESTAMP  NOT NULL,
    used BOOLEAN DEFAULT false NOT NULL,
    emailaddress VARCHAR NOT NULL references users(emailaddress)

);