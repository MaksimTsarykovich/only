USE app;

CREATE TABLE users
(
    `id`       INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name`     VARCHAR(50),
    `phone`    VARCHAR(20) UNIQUE            NOT NULL,
    `email`    VARCHAR(70) UNIQUE            NOT NULL,
    `password` VARCHAR(50) UNIQUE            NOT NULL
);
