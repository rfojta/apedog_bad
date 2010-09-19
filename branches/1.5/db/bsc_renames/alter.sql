rename table bsc_strategic_action to bsc_action, bsc_operations to bsc_operation;

ALTER TABLE  `bsc_responsible` ADD  `term` INT( 10 ) NOT NULL ,
ADD INDEX (  `term` )