rename table bsc_strategic_action to bsc_action, bsc_operations to bsc_operation;

ALTER TABLE  `bsc_responsible` ADD  `term` INT( 10 ) NOT NULL ,
ADD INDEX (  `term` );

-- for importing from excel purposes
ALTER TABLE  `bsc_strategy` ADD  `csf_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
ADD INDEX (  `csf_name` );

ALTER TABLE  `bsc_operation` ADD  `when_txt` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_bin NULL
