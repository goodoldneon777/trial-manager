CREATE TABLE `trial_ht` (
 `trial_seq` int(11) NOT NULL,
 `ht_num` varchar(6) NOT NULL,
 `tap_yr` varchar(2) NOT NULL,
 `bop_vsl` varchar(2) DEFAULT NULL,
 `degas_vsl` varchar(1) DEFAULT NULL,
 `argon_num` varchar(1) DEFAULT NULL,
 `caster_num` varchar(1) DEFAULT NULL,
 `strand_num` varchar(1) DEFAULT NULL,
 `comment` varchar(200) DEFAULT NULL,
 PRIMARY KEY (`trial_seq`,`ht_num`,`tap_yr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1