	CREATE TABLE `resources` ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `resource_name` varchar(255) NOT NULL, 
        `description` text NOT NULL, 
        `resource_image` varchar(255) NOT NULL, 
        PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci