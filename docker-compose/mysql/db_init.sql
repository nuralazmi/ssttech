DROP TABLE IF EXISTS `docker_test_table`;

CREATE TABLE `docker_test_table`
(
    `id`   bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `docker_test_table` (name)
VALUES ('Test row 1'),
       ('Test row 2');
