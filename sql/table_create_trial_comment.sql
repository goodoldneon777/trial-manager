CREATE TABLE `trial_comment` (
 `trial_seq` int(11) NOT NULL,
 `comment_seq` int(11) NOT NULL,
 `insert_dt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
 `comment_text` varchar(1000) NOT NULL,
 PRIMARY KEY (`trial_seq`,`comment_seq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1