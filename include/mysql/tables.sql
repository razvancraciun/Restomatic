CREATE TABLE `Restomatic`.`users` ( 
    `email` VARCHAR(50) NOT NULL , 
    `name` VARCHAR(100) NOT NULL , 
    `password` VARCHAR(100) NOT NULL , 
    `role` VARCHAR(30) NOT NULL , 
    `id` INT AUTO_INCREMENT , 
    PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = InnoDB;