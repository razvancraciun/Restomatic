CREATE TABLE `Restomatic`.`users` ( 
    `email` VARCHAR(50) NOT NULL , 
    `name` VARCHAR(100) NOT NULL , 
    `password` VARCHAR(100) NOT NULL , 
    `role` VARCHAR(30) NOT NULL , 
    `id` INT AUTO_INCREMENT , 
    PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = InnoDB;


CREATE TABLE `Restomatic`.`restaurants` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `owner` INT,
    `name` VARCHAR(30) NOT NULL, 
    `theme` VARCHAR(30) NOT NULL,
    `description` VARCHAR(512),
    `times` VARCHAR(128),
    `address` VARCHAR(128),
    `logo` VARCHAR(128),
    `menu` VARCHAR(128)

    FOREIGN KEY(owner) REFERENCES users(id) 
)