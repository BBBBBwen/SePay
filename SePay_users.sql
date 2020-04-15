DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `payments`;

CREATE TABLE `users`
(
    `id`       int(11)       NOT NULL AUTO_INCREMENT,
    `username` varchar(512)  NOT NULL,
    `password` varchar(512)  NOT NULL,
    `email`    varchar(512)  NOT NULL,
    `balance`  double(20, 2) NOT NULL,
    `avatar`   varchar(512)  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `payments`
(
    `id`             int(11)       NOT NULL AUTO_INCREMENT,
    `user_id`        varchar(255)  NOT NULL,
    `payment_id`     varchar(255)  NOT NULL,
    `description`    varchar(255)  NOT NULL,
    `amount`         double(20, 2) NOT NULL,
    `currency`       varchar(255)  NOT NULL,
    `payment_status` varchar(255)  NOT NULL,
    `captured_at`    datetime      NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1