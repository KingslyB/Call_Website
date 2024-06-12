DROP TABLE IF EXISTS tokens;

CREATE TABLE tokens(
    token CHAR(16),
    userid INT NOT NULL REFERENCES users(id)
);