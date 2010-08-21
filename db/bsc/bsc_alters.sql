ALTER TABLE  `bsc_operations` CHANGE  `status`  `status` INT( 1 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `bsc_operations` ADD  `last_change` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE  `bsc_responsible` ADD  `email` VARCHAR( 48 ) NOT NULL;
alter table `users` add constraint unique_login UNIQUE (login);
ALTER TABLE  `bsc_strategy` ADD  `term` INT NOT NULL;
alter table `bsc_strategy` add constraint foreign key strategy_term (term) references terms(id);


CREATE TABLE  `apedog_cz`.`bsc_responsible_term` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`responsible` INT NOT NULL ,
`term` INT NOT NULL,
foreign key (responsible) references bsc_responsible(id),
foreign key (term) references terms(id)
) ENGINE = MYISAM ;
