CREATE DATABASE mydatabase;
USE mydatabase;

CREATE TABLE role (
    role_id         INT             NOT NULL    AUTO_INCREMENT      PRIMARY KEY,
    role_name       VARCHAR(50)     NOT NULL    UNIQUE
);

CREATE TABLE users (
    user_id     INT             AUTO_INCREMENT  PRIMARY KEY,
    username    VARCHAR(50)     NOT NULL        UNIQUE,
    `password`  VARCHAR(255)    NOT NULL,
    role_id     INT,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE user_attempt (
    user_id         INT,
    last_attempt    DATETIME        NOT NULL,
    attempts        INT             NOT NULL,
    blocked         BOOLEAN         NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE bombe 
(
    noBombe     INT         NOT NULL    AUTO_INCREMENT  PRIMARY KEY,
    lance       BOOLEAN     NOT NULL,
    temps       DATETIME    NOT NULL
);


INSERT INTO `role`(`role_name`)
VALUES ('Admin'), ('Standard');

INSERT INTO `users`(`username`, `password`, `role_id`) 
VALUES ('user_standard','cegep123', 1),('user_super','cegep123', 2),('president', 'Cegep123', 1), ('worker', 'Cegep', 2), ('population', 'Cegep', 2);

INSERT INTO `user_attempt`
VALUES (1, NOW(), 0, 0), (2, NOW(), 0, 0), (3, NOW(), 0, 0), (4, NOW(), 0, 0), (5, NOW(), 0, 0);

INSERT INTO `bombe`(`lance`, `temps`)
VALUES (0, NOW());