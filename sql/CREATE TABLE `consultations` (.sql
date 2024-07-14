CREATE TABLE `consultations` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `consultation_name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `consultation_file` VARCHAR(255) NOT NULL,
    `user_id` INT(20) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
