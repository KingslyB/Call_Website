-- Author: Kingsly Bude

DROP TABLE IF EXISTS calls;
DROP SEQUENCE IF EXISTS calls_id_seq;

CREATE SEQUENCE calls_id_seq START 1;
CREATE TABLE calls(
    callId INT PRIMARY KEY DEFAULT nextval('calls_id_seq'),
    clientEmailAddress VARCHAR REFERENCES clients(emailAddress),
    associatedSalesperson INT REFERENCES users(id),
    callDate TIMESTAMP NOT NULL
);

INSERT INTO calls(clientEmailAddress, associatedSalesperson, callDate)
VALUES(
    'ClientTwo@outlook.com',
    '2',
    '2000-01-01 19:10:26'
);

INSERT INTO calls(clientEmailAddress, associatedSalesperson, callDate)
VALUES(
    'ClientFive@outlook.com',
    '2',
    '2000-01-01 19:10:26'
);


INSERT INTO calls(clientEmailAddress, associatedSalesperson, callDate)
VALUES(
    'ClientTwo@outlook.com',
    '3',
    '2000-01-01 19:10:26'
);


SELECT * FROM calls;