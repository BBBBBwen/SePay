use sepay;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `currency`;
DROP TABLE IF EXISTS `friends`;
DROP TABLE IF EXISTS `friend_request`;
DROP TABLE IF EXISTS `chat`;

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

CREATE TABLE `friends`
(
    `user_id`        varchar(255)  NOT NULL,
    `friend_id`        varchar(255)  NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `friend_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `chat`
(
    `send_id`        varchar(255)  NOT NULL,
    `receive_id`       varchar(255)  NOT NULL,
    `content`        varchar(255)  NOT NULL,
    `time`        datetime      NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

INSERT INTO users (username, password,email,payment_password,avatar,user_level) VALUES('Administration', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin@admin.com','123456','user.png',0);
INSERT INTO currency (user_id) VALUES(1);