-- migrate:up
CREATE TABLE `ms_akun` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `password` CHAR(60) NOT NULL,
  `level` VARCHAR(10) NOT NULL DEFAULT 'USR',
  `prodi` VARCHAR(5) DEFAULT NULL,
  `status` BOOLEAN NOT NULL DEFAULT FALSE
);

-- migrate:down
DROP TABLE `ms_akun`;

