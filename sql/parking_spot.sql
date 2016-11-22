CREATE TABLE `c2csc131_parking_automation`.`parking_spot` (
    `id` INT(5) NOT NULL AUTO_INCREMENT ,
    `area` TINYINT(4) NOT NULL ,
    `spot` INT(5) NOT NULL ,
    `is_taken` BOOLEAN NOT NULL ,
    `qr_code` VARCHAR(20) NOT NULL ,
    `floor` SMALLINT(5) NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
