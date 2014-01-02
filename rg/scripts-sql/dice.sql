CREATE TABLE IF NOT EXISTS `dhs_formato` (
  `id_formato` int(11) NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id_formato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dhs_liga` (
  `id_liga` int(11) NOT NULL auto_increment,
  `id_formato` int(11) NOT NULL ,
  `nome` varchar(150) NOT NULL default '',
  `texto` text,
  PRIMARY KEY  (`id_liga`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dhs_evento` (
  `id_evento` int(11) NOT NULL auto_increment,
  `id_formato` int(11) default NULL,
  `id_liga` int(11) default NULL,
  `tipo` int(11) default NULL,
  `titulo` varchar(150) NOT NULL default '',
  `imagem` varchar(150),
  `texto_anuncio` text,
  `texto_report` text,
  `premiacao` text,
  `data` date,
  `hora` varchar(3),
  `publicado` smallint(6) default NULL,
  PRIMARY KEY  (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dhs_ranking` (
  `id_ranking` int(11) NOT NULL auto_increment,
  `id_liga` int(11) default NULL,
  `id_evento` int(11) default NULL,
  `rodada` int(11),
  `data` date,
  `titulo` varchar(150) NOT NULL default '',
  `texto_report` text,
  `texto_ranking` text,
  `publicado` smallint(6) default NULL,
  PRIMARY KEY  (`id_ranking`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dhs_destaque` (
  `id_destaque` int(11) NOT NULL auto_increment,
  `imagem` varchar(30),
  `ordem` int(11),
  `publicado` smallint(6) default NULL,
  PRIMARY KEY  (`id_destaque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dhs_publicacao` (
  `id_publicacao` int(11) NOT NULL auto_increment,
  `titulo` varchar(150) NOT NULL default '',
  `data` date,
  `imagem` varchar(150),
  `texto` text,
  `publicado` smallint(6) default NULL,
  PRIMARY KEY  (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
