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
    `paymentpassword` varchar(512) NOT NULL,
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