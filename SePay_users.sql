use sepay;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `currency`;

CREATE TABLE `users`
(
    `id`       int(11)       NOT NULL AUTO_INCREMENT,
    `username` varchar(512)  NOT NULL,
    `password` varchar(512)  NOT NULL,
    `email`    varchar(512)  NOT NULL,
    `avatar`   varchar(512)  NOT NULL,
    `user_level`    int(3)   NOT NULL,
    `payment_password` varchar(512) NOT NULL,
    `reg_date` datetime      NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `payments`
(
    `id`             int(11)       NOT NULL AUTO_INCREMENT,
    `user_id`        varchar(255)  NOT NULL,
    `transfer_id`    varchar(255)  DEFAULT null,
    `payment_id`     varchar(255)  NOT NULL,
    `description`    varchar(255)  NOT NULL,
    `amount`         double(20, 2) NOT NULL,
    `currency`       varchar(255)  NOT NULL,
    `payment_status` varchar(255)  NOT NULL,
    `captured_at`    datetime      NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `currency`
(
    `user_id`        varchar(255)  NOT NULL,
    `AUD`         double(20, 2) DEFAULT 0.0,
    `EUR`         double(20, 2) DEFAULT 0.0,
    `USD`         double(20, 2) DEFAULT 0.0,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO users (username, password,email,payment_password,avatar,user_level) VALUES('Administration', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin@admin.com','F8bcSEQEP3JTmethDATDs0WtTAeVNT+1xEAbKrdsNFnyaIGAyOcOI8XyedQ+HREWf9gTBatuaiWszONbHawdSaiZkrA6FWKPbRgo4UciH1ncLeQ2AoKmOGne6mUqyjQWAQxbT7fJn2mWihxquYN7t39QM5uloI0pP6Aj0J1T0dbw/HWUiX9fm3i9E0Q6IGAMDSvF/PNuJbZbYFUwdPvqhdUrU6aFUYlLmOTYP26RRl4abzEzTPlzaTYPbW/p67R3ol7zqkd2qgpJCrzk1zckVNotjzmbf2UKDuQZiBxHJqlOG8BJ29SaIX/dfhq2JFSU/0CHY1vw88CZe0Q9e3v+tQ==','user.png',0);
INSERT INTO currency (user_id) VALUES(1);