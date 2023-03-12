CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT "",
  `email` varchar(60) NOT NULL DEFAULT "",
  `password` varchar(250) NOT NULL DEFAULT "",
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `alternative` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT "",
  `previous_company` varchar(255) NOT NULL DEFAULT "",
  `phone_number` varchar(25) NOT NULL DEFAULT "",
  `email` varchar(60) NOT NULL DEFAULT "",
  `current_job_position` varchar(255) NOT NULL DEFAULT "",
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `criteria` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT "",
  `description` text NOT NULL DEFAULT "",
  `weight` double NOT NULL DEFAULT 0,
  `type` tinyint(2) COMMENT '1 (benefit) , 2 (cost)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `sub_criteria` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `criteria_id` int(11),
  `name` varchar(255) NOT NULL DEFAULT "",
  `point` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `alternative_value` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `alternative_id` int(11),
  `period_id` int(11),
  `period_name` varchar(255) NOT NULL DEFAULT "",
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `alternative_value_detail` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `alternative_value_id` int(11),
  `criteria_id` int(11),
  `criteria_name` varchar(255) NOT NULL DEFAULT "",
  `weight_criteria` double NOT NULL DEFAULT 0,
  `sub_criteria_id` int(11),
  `sub_criteria_name` varchar(255) NOT NULL DEFAULT "",
  `point_sub_criteria` double NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

CREATE TABLE `period` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT "",
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
);

ALTER TABLE `alternative_value_detail` ADD FOREIGN KEY (`alternative_value_id`) REFERENCES `alternative_value` (`id`);

ALTER TABLE `alternative_value` ADD FOREIGN KEY (`period_id`) REFERENCES `period` (`id`);

ALTER TABLE `sub_criteria` ADD FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`);

ALTER TABLE `alternative_value` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `alternative_value_detail` ADD FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`);

ALTER TABLE `alternative_value_detail` ADD FOREIGN KEY (`sub_criteria_id`) REFERENCES `sub_criteria` (`id`);

ALTER TABLE `alternative_value` ADD FOREIGN KEY (`alternative_id`) REFERENCES `alternative` (`id`);

INSERT INTO users (name, email, password, created_at, updated_at, deleted_at) VALUES ('Admin', 'admin@admin.com', '$2y$10$AMWjHF02ANmQMnyp2CNM9OT0BtSp8qvECx3tdRVrBmRhEwy71RroS', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, null);

