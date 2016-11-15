CREATE TABLE `c2csc131_parking_automation`.`user_table`(
    `id` INT(5) NOT NULL AUTO_INCREMENT,
    `password` TEXT NOT NULL ,
    `qr_code` VARCHAR(20) NOT NULL ,
    `email` TEXT NOT NULL ,
    `full_name` TEXT NOT NULL ,
    `phone_number` INT(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
