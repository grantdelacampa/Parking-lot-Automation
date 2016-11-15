CREATE TABLE `parking_journal` (
    `id` INT(5) NOT NULL AUTO_INCREMENT ,
    `money` DOUBLE(6) NOT NULL ,
    `user_phone_number` INT(30) NOT NULL ,
    `ts_start` TIME NOT NULL ,
    `ts_end` TIME NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
