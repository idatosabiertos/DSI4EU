ALTER TABLE `events` ADD `address` TEXT NOT NULL AFTER `endDate`, ADD `phoneNumber` CHAR(255) NOT NULL AFTER `address`, ADD `emailAddress` CHAR(255) NOT NULL AFTER `phoneNumber`, ADD `price` CHAR(50) NOT NULL AFTER `emailAddress`;