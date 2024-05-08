-- Author: Kingsly Bude
DROP TABLE IF EXISTS clients;

CREATE TABLE clients(
    emailAddress VARCHAR(255) NOT NULL UNIQUE,
    firstName VARCHAR(128), 
    lastName VARCHAR(128),
    phoneNum BIGINT,
    phoneExt INT,
    salesperson INT REFERENCES users (id),
    logoPath VARCHAR(128)
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientOne@gmail.com',
    'Jane',
    'Doe',
    2895555555,
    21,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwo@outlook.com',
    'Charles',
    'Stradtford',
    4165555555,
    989,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientThree@gmail.com',
    'Bill',
    'Fortward',
    9055555555,
    63,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientFour@outlook.com',
    'Amit',
    'Desai',
    2886112048,
    1,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientFive@outlook.com',
    'Michael',
    'Watson',
    9207410840,
    78,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientSix@outlook.com',
    'Hanan',
    'Edge',
    6311364181,
    12,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientSeven@outlook.com',
    'Samir',
    'Meyer',
    7417097424,
    3,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientEight@outlook.com',
    'Brax',
    'Howarth',
    1223451931,
    79,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientNine@outlook.com',
    'Sara',
    'Potts',
    3926441817,
    1,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTen@outlook.com',
    'Aaliyah',
    'Salas',
    1958211800,
    1,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientEleven@outlook.com',
    'Caio',
    'Brave',
    9856187347,
    35,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwelve@outlook.com',
    'Cecil',
    'Bright',
    2329373973,
    86,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientThirteen@outlook.com',
    'Lilly-Ann',
    'Malone',
    5148364580,
    22,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientFourteen@outlook.com',
    'Inaaya',
    'Webber',
    1957786930,
    999,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientFifteen@outlook.com',
    'Hywel',
    'Gibbons',
    8322980861,
    966,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientSixteen@outlook.com',
    'Ayaan',
    'Sheridan',
    8707569377,
    663,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientSeventeen@outlook.com',
    'Cian',
    'Sears',
    7739958596,
    12,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientEighteen@outlook.com',
    'Eiliyah',
    'Kaiser',
    1901718858,
    1,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientNineteen@outlook.com',
    'Hana',
    'Sharples',
    7739958596,
    3,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwenty@outlook.com',
    'Aniyah',
    'Moore',
    1901718858,
    9,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwentyone@outlook.com',
    'Carson',
    'Ayers',
    8128172203,
    45,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwentytwo@outlook.com',
    'Zackery',
    'Bouvet',
    7804205886,
    51,
    2
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwentythree@outlook.com',
    'Todd',
    'Corrigan',
    9925498549,
    50,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwentyfour@outlook.com',
    'Giovanni',
    'Shah',
    6512404921,
    49,
    3
);

INSERT INTO clients(emailAddress, firstName, lastName, phoneNum, phoneExt, salesperson)
VALUES(
    'ClientTwentyfive@outlook.com',
    'Isabelle',
    'Rodrigues',
    3247347345,
    41,
    3
);

SELECT * FROM clients;