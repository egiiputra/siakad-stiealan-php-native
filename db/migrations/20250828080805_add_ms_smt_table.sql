-- migrate:up
CREATE TABLE `ms_smt` (
  `smt` SMALLINT UNSIGNED  NOT NULL,
  `nama` varchar(20) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `blnuts` tinyint(3) UNSIGNED NOT NULL,
  `blnuas` tinyint(3) UNSIGNED NOT NULL,
  `spp_uts` MEDIUMINT UNSIGNED,
  `spp_uas` MEDIUMINT UNSIGNED ,
  `statkrs` tinyint(1) NOT NULL DEFAULT 0
);

-- migrate:down
DROP TABLE `ms_smt`;