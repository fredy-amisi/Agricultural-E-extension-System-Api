-- Alter the resources table to add user_id column
ALTER TABLE `resources` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `id`;

-- Add foreign key constraint to user_id column
ALTER TABLE `resources`
ADD CONSTRAINT `fk_user_id`
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
ON DELETE CASCADE ON UPDATE CASCADE;
