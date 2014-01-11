CREATE TABLE `share_edicao` ( 
	`id_edicao` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`sigla` VarChar( 4 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`nome` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`nome_pt` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`imagem` VarChar( 150 )  CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`is_spoiler` Int( 11 ) NULL,
	 PRIMARY KEY ( `id_edicao` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;

insert into `share_edicao` (`id_edicao`,`sigla`,`nome`,`is_spoiler`) values (1,'BNG', 'Born of the Gods', 1);

CREATE TABLE `share_spoiler` ( 
	`id_spoiler` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_edicao` Int( 11 ) NULL,
	`imagem` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`texto` TEXT, 
	`fonte` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci, 
	`fonte_link` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci,
	 PRIMARY KEY ( `id_spoiler` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;

insert into `rg_menu_admin` (`id_menu_admin`, `titulo`, `link`, `parent`, `ordering`, `publicado`) values ('18', 'Spoilers', 'option=spoiler', '0', '16', '1');
insert into `rg_menu_admin` (`id_menu_admin`, `titulo`, `link`, `parent`, `ordering`, `publicado`) values ('19', 'Cards', 'option=spoiler', '18', '16', '1');

insert into `rg_menu` (`id_menu`, `titulo`, `link`, `publicado`, `parent`, `ordering`) values ('7', 'Spoilers', 'option=spoiler', '1', '1', '9');

UPDATE `rg_menu` SET `link`='index.php?option=spoiler&edicao=1', `ordering`='5' WHERE `id_menu`='7';
UPDATE `rg_menu` SET `ordering`='6' WHERE `id_menu`='6';

insert into `sl_menu_admin` (`id_menu_admin`, `titulo`, `link`, `parent`, `ordering`, `publicado`) values ('18', 'Spoilers', 'option=spoiler', '0', '16', '1');
insert into `sl_menu_admin` (`id_menu_admin`, `titulo`, `link`, `parent`, `ordering`, `publicado`) values ('19', 'Cards', 'option=spoiler', '18', '16', '1');

insert into `sl_menu` (`id_menu`, `titulo`, `link`, `publicado`, `parent`, `ordering`) values ('7', 'Spoilers', 'option=spoiler', '1', '1', '9');

UPDATE `sl_menu` SET `link`='index.php?option=spoiler&edicao=1', `ordering`='5' WHERE `id_menu`='7';
UPDATE `sl_menu` SET `ordering`='6' WHERE `id_menu`='6';

alter table `share_edicao` add column `is_home` int(11) default 0;
update `share_edicao` set `is_home` = 1;

insert into `share_edicao` (`id_edicao`,`sigla`,`nome`,`is_spoiler`) values (2,'M15', 'Magic 2015', 1);

alter table `share_edicao` add column `texto` text;