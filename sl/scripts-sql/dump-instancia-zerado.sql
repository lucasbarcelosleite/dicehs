SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `cms_conteudo` (
  `id_conteudo` int(11) NOT NULL auto_increment,
  `id_conteudo_categoria` int(11) default NULL,
  `titulo` varchar(150) NOT NULL default '',
  `texto` text,
  `publicado` smallint(6) default NULL,
  `chave` varchar(50) default NULL,
  `id_main` int(11) default NULL,
  `id_lang` int(11) default NULL,
  `link` varchar(255) default NULL,
  `limit_char` int(11) default NULL,
  `tem_video` int(11) default NULL,
  PRIMARY KEY  (`id_conteudo`),
  KEY `id_conteudo_categoria` (`id_conteudo_categoria`),
  KEY `id_main` (`id_main`),
  KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_conteudo_categoria` (
  `id_conteudo_categoria` int(11) NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL default '',
  `ordering` int(11) default NULL,
  `id_main` int(11) default NULL,
  `id_lang` int(11) default NULL,
  PRIMARY KEY  (`id_conteudo_categoria`),
  KEY `id_lang` (`id_lang`),
  KEY `id_main` (`id_main`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO `cms_conteudo_categoria` (`id_conteudo_categoria`, `nome`, `ordering`, `id_main`, `id_lang`) VALUES (1, 'Páginas de Texto', 2, 3, 1);

CREATE TABLE IF NOT EXISTS `cms_conteudo_midia` (
  `id_conteudo_midia` int(11) NOT NULL auto_increment,
  `id_conteudo` int(11) NOT NULL default '0',
  `tipo` varchar(10) NOT NULL default '',
  `arquivo` varchar(50) NOT NULL default '',
  `descricao` varchar(250) default NULL,
  `id_main` int(11) default NULL,
  `id_lang` int(11) default NULL,
  `is_arquivo_main` int(11) default NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  `is_original` int(11) default NULL,
  PRIMARY KEY  (`id_conteudo_midia`),
  KEY `id_conteudo` (`id_conteudo`),
  KEY `id_main` (`id_main`),
  KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_destaque` (
  `id_destaque` int(11) NOT NULL auto_increment,
  `titulo` varchar(50) default NULL,
  `imagem` varchar(50) default NULL,
  `data` date default NULL,
  `publicado` int(11) default NULL,
  `url` varchar(255) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `subtitulo` text NOT NULL,
  PRIMARY KEY  (`id_destaque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_lang` (
  `id_lang` int(11) NOT NULL auto_increment,
  `nome` varchar(255) default NULL,
  `sigla` varchar(10) default NULL,
  `imagem` varchar(255) default NULL,
  PRIMARY KEY  (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `cms_lang` (`id_lang`, `nome`, `sigla`, `imagem`) VALUES
(1, 'Português (Brasil)', 'pt-br', 'br.png');

CREATE TABLE IF NOT EXISTS `cms_menu` (
  `id_menu` int(11) NOT NULL auto_increment,
  `titulo` varchar(255) NOT NULL default '',
  `link` varchar(255) default NULL,
  `publicado` int(1) default '0',
  `parent` int(11) default '0',
  `id_conteudo` int(11) default NULL,
  `ordering` int(11) default '0',
  `id_main` int(11) default NULL,
  `id_lang` int(11) default NULL,
  `introducao` text,
  PRIMARY KEY  (`id_menu`),
  KEY `id_main` (`id_main`),
  KEY `id_lang` (`id_lang`),
  KEY `id_conteudo` (`id_conteudo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `cms_menu` (`id_menu`, `titulo`, `link`, `publicado`, `parent`, `id_conteudo`, `ordering`, `id_main`, `id_lang`, `introducao`) VALUES
(1, 'Página Inicial', 'index.php?option=html&arq=home', 1, 0, NULL, 1, 1, 1, NULL);

CREATE TABLE IF NOT EXISTS `cms_menu_admin` (
  `id_menu_admin` int(11) NOT NULL auto_increment,
  `titulo` varchar(255) default NULL,
  `subtitulo` varchar(255) default NULL,
  `link` varchar(255) default NULL,
  `icone` varchar(255) default NULL,
  `is_painel` int(11) default '0',
  `parent` int(11) default '0',
  `ordering` int(11) default '0',
  `publicado` int(1) default NULL,
  PRIMARY KEY  (`id_menu_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `cms_menu_admin` (`id_menu_admin`, `titulo`, `subtitulo`, `link`, `icone`, `is_painel`, `parent`, `ordering`, `publicado`) VALUES
(1, 'Início', NULL, 'option=control_panel', '', 0, 0, 0, 0),
(2, 'Usuários', NULL, 'option=usuario', 'system_users.png', 1, 0, 1, 1),
(3, 'Blocos de Texto e Títulos', NULL, 'option=conteudo&classe=', 'accessories_text_editor.png', 1, 0, 3, 1),
(4, 'Alterar Senha', NULL, 'option=usuario&task=alterarSenha', 'accessories_text_editor.png', 1, 0, 2, 1);

CREATE TABLE IF NOT EXISTS `cms_modulo` (
  `id_modulo` int(11) NOT NULL auto_increment,
  `titulo` varchar(50) NOT NULL default '',
  `posicao` varchar(20) NOT NULL default '',
  `ordering` int(11) default NULL,
  `publicado` smallint(6) default NULL,
  `arquivo` varchar(50) default NULL,
  PRIMARY KEY  (`id_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `cms_modulo` (`id_modulo`, `titulo`, `posicao`, `ordering`, `publicado`, `arquivo`) VALUES
(1, 'Menu', 'menu', 1, 1, 'menu.php'),
(2, 'Conteúdo', 'conteudo', 1, 1, 'conteudo.php'),
(3, 'Migalha', 'migalha', 1, 1, 'migalha.php');

CREATE TABLE IF NOT EXISTS `cms_modulo_menu` (
  `id_modulo_menu` int(11) NOT NULL auto_increment,
  `id_modulo` int(11) NOT NULL default '0',
  `id_menu` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_modulo_menu`),
  KEY `id_modulo` (`id_modulo`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `cms_modulo_menu` (`id_modulo_menu`, `id_modulo`, `id_menu`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0);

CREATE TABLE IF NOT EXISTS `cms_seo_menu` (
  `id_seo_menu` int(11) unsigned NOT NULL auto_increment,
  `id_menu` int(11) default NULL,
  `page_title` varchar(100) default NULL,
  `meta_description` varchar(255) default NULL,
  `meta_keywords` varchar(255) default NULL,
  `url_add` varchar(100) default NULL,
  PRIMARY KEY  (`id_seo_menu`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_seo_url` (
  `id_seo_url` int(11) NOT NULL auto_increment,
  `url_old` varchar(255) NOT NULL default '',
  `url_new` varchar(255) NOT NULL default '',
  `is_ativa` smallint(6) default '1',
  `is_automatica` smallint(6) default '1',
  `id_main` int(11) default NULL,
  `id_lang` int(255) default '1',
  `page_title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_seo_url`),
  UNIQUE KEY `new_url` (`url_new`),
  KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `id_lang` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`,`id_lang`),
  KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cms_templates_menu` (`template`, `menuid`, `id_lang`) VALUES ('_principal', 0, 0);

CREATE TABLE IF NOT EXISTS `cms_texto_layout` (
  `id_texto_layout` int(11) NOT NULL auto_increment,
  `texto` text,
  `chave` varchar(100) default NULL,
  `id_main` int(11) default NULL,
  `id_lang` int(11) default '1',
  PRIMARY KEY  (`id_texto_layout`),
  KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_usuario` (
  `id_usuario` int(11) NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL default '',
  `login` varchar(50) NOT NULL default '',
  `senha` varchar(100) NOT NULL default '',
  `email` varchar(80) NOT NULL default '',
  `session_id` varchar(255) default NULL,
  `ultimo_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ultimo_acesso` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `cms_usuario` (`id_usuario`, `nome`, `login`, `senha`, `email`, `session_id`, `ultimo_login`, `ultimo_acesso`) VALUES
(1, 'Administrador do Sistema', 'admin', '202cb962ac59075b964b07152d234b70', 'email@email.com', 'hrvcn2qa23c3h1mfvdnds91bd6', '2012-09-30 22:50:54', '2012-09-30 22:51:11');

CREATE TABLE IF NOT EXISTS `cms_usuario_grupo` (
  `id_usuario_grupo` int(11) NOT NULL auto_increment,
  `nome` varchar(100) default NULL,
  `ordering` int(11) default '0',
  PRIMARY KEY  (`id_usuario_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `cms_usuario_grupo` (`id_usuario_grupo`, `nome`, `ordering`) VALUES (1, 'Administrador', 1);

CREATE TABLE IF NOT EXISTS `cms_usuario_grupo_menu_admin` (
  `id_usuario_grupo_menu_admin` int(11) NOT NULL auto_increment,
  `id_usuario_grupo` int(11) NOT NULL default '0',
  `id_menu_admin` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_usuario_grupo_menu_admin`),
  KEY `id_usuario_grupo` (`id_usuario_grupo`),
  KEY `id_menu_admin` (`id_menu_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cms_usuario_usuario_grupo` (
  `id_usuario_usuario_grupo` int(11) NOT NULL auto_increment,
  `id_usuario` int(11) default NULL,
  `id_usuario_grupo` int(11) default NULL,
  PRIMARY KEY  (`id_usuario_usuario_grupo`),
  KEY `id_usuario_grupo` (`id_usuario_grupo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `cms_usuario_usuario_grupo` (`id_usuario_usuario_grupo`, `id_usuario`, `id_usuario_grupo`) VALUES (1, 1, 1);
