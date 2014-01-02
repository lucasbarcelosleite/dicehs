-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_conteudo" -----------------------------
DROP TABLE IF EXISTS `sl_conteudo` CASCADE;

CREATE TABLE `sl_conteudo` ( 
	`id_conteudo` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_conteudo_categoria` Int( 11 ) NULL, 
	`titulo` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`texto` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`chave` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 11 ) NULL, 
	`link` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`limit_char` Int( 11 ) NULL, 
	`tem_video` Int( 11 ) NULL,
	 PRIMARY KEY ( `id_conteudo` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 5;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_conteudo_categoria" -------------------
DROP TABLE IF EXISTS `sl_conteudo_categoria` CASCADE;

CREATE TABLE `sl_conteudo_categoria` ( 
	`id_conteudo_categoria` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`nome` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`ordering` Int( 11 ) NULL, 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 11 ) NULL,
	 PRIMARY KEY ( `id_conteudo_categoria` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_conteudo_midia" -----------------------
DROP TABLE IF EXISTS `sl_conteudo_midia` CASCADE;

CREATE TABLE `sl_conteudo_midia` ( 
	`id_conteudo_midia` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_conteudo` Int( 11 ) NOT NULL DEFAULT '0', 
	`tipo` VarChar( 10 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`arquivo` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`descricao` VarChar( 250 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 11 ) NULL, 
	`is_arquivo_main` Int( 11 ) NULL, 
	`width` Int( 11 ) NULL, 
	`height` Int( 11 ) NULL, 
	`is_original` Int( 11 ) NULL,
	 PRIMARY KEY ( `id_conteudo_midia` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_destaque" -----------------------------
DROP TABLE IF EXISTS `sl_destaque` CASCADE;

CREATE TABLE `sl_destaque` ( 
	`id_destaque` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`titulo` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`imagem` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`data` Date NULL, 
	`publicado` Int( 11 ) NULL, 
	`url` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`ordering` Int( 11 ) NOT NULL DEFAULT '0', 
	`subtitulo` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	 PRIMARY KEY ( `id_destaque` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_lang" ---------------------------------
DROP TABLE IF EXISTS `sl_lang` CASCADE;

CREATE TABLE `sl_lang` ( 
	`id_lang` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`nome` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`sigla` VarChar( 10 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`imagem` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_lang` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_menu" ---------------------------------
DROP TABLE IF EXISTS `sl_menu` CASCADE;

CREATE TABLE `sl_menu` ( 
	`id_menu` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`titulo` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`link` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Int( 1 ) NULL DEFAULT '0', 
	`parent` Int( 11 ) NULL DEFAULT '0', 
	`id_conteudo` Int( 11 ) NULL, 
	`ordering` Int( 11 ) NULL DEFAULT '0', 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 11 ) NULL, 
	`introducao` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_menu` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 7;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_menu_admin" ---------------------------
DROP TABLE IF EXISTS `sl_menu_admin` CASCADE;

CREATE TABLE `sl_menu_admin` ( 
	`id_menu_admin` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`titulo` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`subtitulo` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`link` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`icone` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`is_painel` Int( 11 ) NULL DEFAULT '0', 
	`parent` Int( 11 ) NULL DEFAULT '0', 
	`ordering` Int( 11 ) NULL DEFAULT '0', 
	`publicado` Int( 1 ) NULL,
	 PRIMARY KEY ( `id_menu_admin` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 16;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_modulo" -------------------------------
DROP TABLE IF EXISTS `sl_modulo` CASCADE;

CREATE TABLE `sl_modulo` ( 
	`id_modulo` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`titulo` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`posicao` VarChar( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`ordering` Int( 11 ) NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`arquivo` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_modulo` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 4;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_modulo_menu" --------------------------
DROP TABLE IF EXISTS `sl_modulo_menu` CASCADE;

CREATE TABLE `sl_modulo_menu` ( 
	`id_modulo_menu` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_modulo` Int( 11 ) NOT NULL DEFAULT '0', 
	`id_menu` Int( 11 ) NOT NULL DEFAULT '0',
	 PRIMARY KEY ( `id_modulo_menu` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 4;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_seo_menu" -----------------------------
DROP TABLE IF EXISTS `sl_seo_menu` CASCADE;

CREATE TABLE `sl_seo_menu` ( 
	`id_seo_menu` Int( 11 ) UNSIGNED AUTO_INCREMENT NOT NULL, 
	`id_menu` Int( 11 ) NULL, 
	`page_title` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`meta_description` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`meta_keywords` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`url_add` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_seo_menu` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_seo_url" ------------------------------
DROP TABLE IF EXISTS `sl_seo_url` CASCADE;

CREATE TABLE `sl_seo_url` ( 
	`id_seo_url` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`url_old` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`url_new` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`is_ativa` Smallint( 6 ) NULL DEFAULT '1', 
	`is_automatica` Smallint( 6 ) NULL DEFAULT '1', 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 255 ) NULL DEFAULT '1', 
	`page_title` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	 PRIMARY KEY ( `id_seo_url` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_templates_menu" -----------------------
DROP TABLE IF EXISTS `sl_templates_menu` CASCADE;

CREATE TABLE `sl_templates_menu` ( 
	`template` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`menuid` Int( 11 ) NOT NULL DEFAULT '0', 
	`id_lang` Int( 11 ) NOT NULL DEFAULT '0',
	 PRIMARY KEY ( `template`,`menuid`,`id_lang` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_texto_layout" -------------------------
DROP TABLE IF EXISTS `sl_texto_layout` CASCADE;

CREATE TABLE `sl_texto_layout` ( 
	`id_texto_layout` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`texto` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`chave` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`id_main` Int( 11 ) NULL, 
	`id_lang` Int( 11 ) NULL DEFAULT '1',
	 PRIMARY KEY ( `id_texto_layout` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_usuario" ------------------------------
DROP TABLE IF EXISTS `sl_usuario` CASCADE;

CREATE TABLE `sl_usuario` ( 
	`id_usuario` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`nome` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`login` VarChar( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`senha` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`email` VarChar( 80 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`session_id` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`ultimo_login` Timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
	`ultimo_acesso` Timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	 PRIMARY KEY ( `id_usuario` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_usuario_grupo" ------------------------
DROP TABLE IF EXISTS `sl_usuario_grupo` CASCADE;

CREATE TABLE `sl_usuario_grupo` ( 
	`id_usuario_grupo` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`nome` VarChar( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`ordering` Int( 11 ) NULL DEFAULT '0',
	 PRIMARY KEY ( `id_usuario_grupo` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_usuario_grupo_menu_admin" -------------
DROP TABLE IF EXISTS `sl_usuario_grupo_menu_admin` CASCADE;

CREATE TABLE `sl_usuario_grupo_menu_admin` ( 
	`id_usuario_grupo_menu_admin` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_usuario_grupo` Int( 11 ) NOT NULL DEFAULT '0', 
	`id_menu_admin` Int( 11 ) NOT NULL DEFAULT '0',
	 PRIMARY KEY ( `id_usuario_grupo_menu_admin` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_usuario_usuario_grupo" ----------------
DROP TABLE IF EXISTS `sl_usuario_usuario_grupo` CASCADE;

CREATE TABLE `sl_usuario_usuario_grupo` ( 
	`id_usuario_usuario_grupo` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_usuario` Int( 11 ) NULL, 
	`id_usuario_grupo` Int( 11 ) NULL,
	 PRIMARY KEY ( `id_usuario_usuario_grupo` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 2;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_destaque" -----------------------------
DROP TABLE IF EXISTS `sl_destaque` CASCADE;

CREATE TABLE `sl_destaque` ( 
	`id_destaque` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`imagem` VarChar( 30 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`ordering` Int( 11 ) NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`url` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`titulo` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`modelo` Int( 255 ) NULL,
	 PRIMARY KEY ( `id_destaque` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 6;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_evento" -------------------------------
DROP TABLE IF EXISTS `sl_evento` CASCADE;

CREATE TABLE `sl_evento` ( 
	`id_evento` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_formato` Int( 11 ) NULL, 
	`id_liga` Int( 11 ) NULL, 
	`tipo` Int( 11 ) NULL, 
	`titulo` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`imagem` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`texto_anuncio` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`texto_report` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`premiacao` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`data` Date NULL, 
	`hora` VarChar( 5 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`chamada` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`id_ranking` Int( 255 ) NULL, 
	`dia_hora_permanente` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_evento` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 10;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_formato" ------------------------------
DROP TABLE IF EXISTS `sl_formato` CASCADE;

CREATE TABLE `sl_formato` ( 
	`id_formato` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`nome` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	 PRIMARY KEY ( `id_formato` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 10;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_liga" ---------------------------------
DROP TABLE IF EXISTS `sl_liga` CASCADE;

CREATE TABLE `sl_liga` ( 
	`id_liga` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_formato` Int( 11 ) NOT NULL, 
	`nome` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`texto` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Int( 255 ) NULL, 
	`texto_premiacao` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_liga` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 3;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_publicacao" ---------------------------
DROP TABLE IF EXISTS `sl_publicacao` CASCADE;

CREATE TABLE `sl_publicacao` ( 
	`id_publicacao` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`titulo` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, 
	`data` Date NULL, 
	`imagem` VarChar( 150 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`texto` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`chamada` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
	 PRIMARY KEY ( `id_publicacao` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 7;
-- ---------------------------------------------------------


-- CREATE TABLE "sl_ranking" ------------------------------
DROP TABLE IF EXISTS `sl_ranking` CASCADE;

CREATE TABLE `sl_ranking` ( 
	`id_ranking` Int( 11 ) AUTO_INCREMENT NOT NULL, 
	`id_liga` Int( 11 ) NULL, 
	`rodada` Int( 11 ) NULL, 
	`data` Date NULL, 
	`texto_report` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`texto_ranking` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`publicado` Smallint( 6 ) NULL, 
	`chamada` Text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, 
	`imagem` VarChar( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
	 PRIMARY KEY ( `id_ranking` )
 )
CHARACTER SET = latin1
COLLATE = latin1_swedish_ci
ENGINE = InnoDB
AUTO_INCREMENT = 6;
-- ---------------------------------------------------------


-- Dump data of "sl_conteudo" -----------------------------
INSERT INTO `sl_conteudo`(`id_conteudo`,`id_conteudo_categoria`,`titulo`,`texto`,`publicado`,`chave`,`id_main`,`id_lang`,`link`,`limit_char`,`tem_video`) VALUES ( '1', NULL, 'Quem Somos', '<p>
	Teste</p>
', '1', NULL, NULL, NULL, NULL, NULL, NULL );
INSERT INTO `sl_conteudo`(`id_conteudo`,`id_conteudo_categoria`,`titulo`,`texto`,`publicado`,`chave`,`id_main`,`id_lang`,`link`,`limit_char`,`tem_video`) VALUES ( '2', NULL, 'Endereço da Dice (Rodapé)', '<p>
	Rua Aquidaban, 714, Loja 13<br />
	Rio Grande - RS<br />
	CEP: 96200-480<br />
	Tel: (53) 3201-2469</p>
', '1', 'endereco_dice', '1', '1', NULL, NULL, NULL );
INSERT INTO `sl_conteudo`(`id_conteudo`,`id_conteudo_categoria`,`titulo`,`texto`,`publicado`,`chave`,`id_main`,`id_lang`,`link`,`limit_char`,`tem_video`) VALUES ( '3', NULL, 'Endereço da Dice (Eventos)', '<p>Rua Aquidaban, 714, Loja 13 - Rio Grande - RS</p>
', '1', 'endereco_eventos', NULL, NULL, NULL, NULL, NULL );
INSERT INTO `sl_conteudo`(`id_conteudo`,`id_conteudo_categoria`,`titulo`,`texto`,`publicado`,`chave`,`id_main`,`id_lang`,`link`,`limit_char`,`tem_video`) VALUES ( '4', NULL, 'Contato', '<p>
	Entre em Contato</p>
', '1', NULL, NULL, NULL, NULL, NULL, NULL );;
-- ---------------------------------------------------------


-- Dump data of "sl_conteudo_categoria" -------------------
INSERT INTO `sl_conteudo_categoria`(`id_conteudo_categoria`,`nome`,`ordering`,`id_main`,`id_lang`) VALUES ( '1', 'Páginas de Texto', '2', '3', '1' );;
-- ---------------------------------------------------------


-- Dump data of "sl_conteudo_midia" -----------------------
-- ---------------------------------------------------------


-- Dump data of "sl_destaque" -----------------------------
-- ---------------------------------------------------------


-- Dump data of "sl_lang" ---------------------------------
INSERT INTO `sl_lang`(`id_lang`,`nome`,`sigla`,`imagem`) VALUES ( '1', 'Português (Brasil)', 'pt-br', 'br.png' );;
-- ---------------------------------------------------------


-- Dump data of "sl_menu" ---------------------------------
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '1', 'Página Inicial', 'index.php?option=home', '1', '0', NULL, '1', '1', '1', NULL );
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '2', 'Quem Somos', 'index.php?option=conteudo&id=1', '1', '1', '1', '1', '1', '1', NULL );
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '3', 'Artigos e Notícias', 'index.php?option=publicacao', '1', '1', NULL, '2', '1', '1', NULL );
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '4', 'Eventos', 'index.php?option=evento', '1', '1', NULL, '3', '1', '1', NULL );
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '5', 'Ligas e Rankings', 'index.php?option=liga', '1', '1', NULL, '4', '1', '1', NULL );
INSERT INTO `sl_menu`(`id_menu`,`titulo`,`link`,`publicado`,`parent`,`id_conteudo`,`ordering`,`id_main`,`id_lang`,`introducao`) VALUES ( '6', 'Contato', 'index.php?option=conteudo&id=4', '1', '1', '4', '5', '1', '1', NULL );;
-- ---------------------------------------------------------


-- Dump data of "sl_menu_admin" ---------------------------
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '1', 'Início', NULL, 'option=control_panel', '', '0', '0', '0', '0' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '2', 'Usuários', NULL, 'option=usuario', 'system_users.png', '1', '13', '1', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '3', 'Blocos de Texto', NULL, 'option=conteudo&classe=', 'accessories_text_editor.png', '1', '13', '3', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '4', 'Alterar Senha', NULL, 'option=usuario&task=alterarSenha', 'accessories_text_editor.png', '1', '13', '2', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '5', 'Cadastros Básicos', NULL, 'option=usuario', NULL, '0', '0', '2', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '7', 'Formatos', NULL, 'option=formato', NULL, '0', '5', '2', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '8', 'Liga / Temporada', NULL, 'option=liga', NULL, '0', '5', '3', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '9', 'Artigos / Notícias', NULL, 'option=publicacao', NULL, '0', '14', '1', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '10', 'Destaques da Home', NULL, 'option=destaque', NULL, '0', '14', '2', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '11', 'Eventos', NULL, 'option=evento', NULL, '0', '14', '3', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '12', 'Ranking', NULL, 'option=ranking', NULL, '0', '14', '4', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '13', 'Sistema', NULL, 'option=control_panel', NULL, '0', '0', '1', '1' );
INSERT INTO `sl_menu_admin`(`id_menu_admin`,`titulo`,`subtitulo`,`link`,`icone`,`is_painel`,`parent`,`ordering`,`publicado`) VALUES ( '14', 'Publicações', NULL, 'option=control_panel', NULL, '0', '0', '3', '1' );;
-- ---------------------------------------------------------


-- Dump data of "sl_modulo" -------------------------------
INSERT INTO `sl_modulo`(`id_modulo`,`titulo`,`posicao`,`ordering`,`publicado`,`arquivo`) VALUES ( '1', 'Menu', 'menu', '1', '1', 'menu.php' );
INSERT INTO `sl_modulo`(`id_modulo`,`titulo`,`posicao`,`ordering`,`publicado`,`arquivo`) VALUES ( '2', 'Conteúdo', 'conteudo', '1', '1', 'conteudo.php' );
INSERT INTO `sl_modulo`(`id_modulo`,`titulo`,`posicao`,`ordering`,`publicado`,`arquivo`) VALUES ( '3', 'Migalha', 'migalha', '1', '1', 'migalha.php' );;
-- ---------------------------------------------------------


-- Dump data of "sl_modulo_menu" --------------------------
INSERT INTO `sl_modulo_menu`(`id_modulo_menu`,`id_modulo`,`id_menu`) VALUES ( '1', '1', '0' );
INSERT INTO `sl_modulo_menu`(`id_modulo_menu`,`id_modulo`,`id_menu`) VALUES ( '2', '2', '0' );
INSERT INTO `sl_modulo_menu`(`id_modulo_menu`,`id_modulo`,`id_menu`) VALUES ( '3', '3', '0' );;
-- ---------------------------------------------------------


-- Dump data of "sl_seo_menu" -----------------------------
-- ---------------------------------------------------------


-- Dump data of "sl_templates_menu" -----------------------
INSERT INTO `sl_templates_menu`(`template`,`menuid`,`id_lang`) VALUES ( '_principal', '0', '0' );;
-- ---------------------------------------------------------


-- Dump data of "sl_texto_layout" -------------------------
-- ---------------------------------------------------------


-- Dump data of "sl_usuario" ------------------------------
INSERT INTO `sl_usuario`(`id_usuario`,`nome`,`login`,`senha`,`email`,`session_id`,`ultimo_login`,`ultimo_acesso`) VALUES ( '1', 'Administrador do Sistema', 'admin', '202cb962ac59075b964b07152d234b70', 'email@email.com', '8456a2d7911f7d767d2a9ba2247d8bb2', '2013-11-28 02:26:23', '2013-11-28 02:40:51' );;
-- ---------------------------------------------------------


-- Dump data of "sl_usuario_grupo" ------------------------
INSERT INTO `sl_usuario_grupo`(`id_usuario_grupo`,`nome`,`ordering`) VALUES ( '1', 'Administrador', '1' );;
-- ---------------------------------------------------------


-- Dump data of "sl_usuario_grupo_menu_admin" -------------
-- ---------------------------------------------------------


-- Dump data of "sl_usuario_usuario_grupo" ----------------
INSERT INTO `sl_usuario_usuario_grupo`(`id_usuario_usuario_grupo`,`id_usuario`,`id_usuario_grupo`) VALUES ( '1', '1', '1' );;
-- ---------------------------------------------------------


-- Dump data of "sl_destaque" -----------------------------
INSERT INTO `sl_destaque`(`id_destaque`,`imagem`,`ordering`,`publicado`,`url`,`titulo`,`modelo`) VALUES ( '1', '5292167cb96f5.jpg', '3', '1', 'http://www.google.com', 'Pré-Release Born of the Gods', '3' );
INSERT INTO `sl_destaque`(`id_destaque`,`imagem`,`ordering`,`publicado`,`url`,`titulo`,`modelo`) VALUES ( '2', '5292173b98468.jpg', '5', '1', 'http://www.google.com', 'Draft de Lançamento de Theros', '1' );
INSERT INTO `sl_destaque`(`id_destaque`,`imagem`,`ordering`,`publicado`,`url`,`titulo`,`modelo`) VALUES ( '3', '5292168714c65.jpg', '4', '1', 'http://www.google.com', 'Torneio de Fim de Ano Dice HS', '2' );;
-- ---------------------------------------------------------


-- Dump data of "sl_evento" -------------------------------
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '2', '5', NULL, '1', 'Mesão de Commander', '5292344b271fe.jpg', '<p>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna&nbsp;</p>
', '<p>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna&nbsp;</p>
', '<p>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna&nbsp;</p>
', '2013-11-25', '20:00', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna ', NULL, NULL );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '3', '1', NULL, '1', 'GP Trip Buenos Aires', '5296651ba63b6.jpg', '<div>
	Inscri&ccedil;&atilde;o: R$ 40,00.</div>
<div>
	Formato: Padr&atilde;o, com rodadas em su&iacute;&ccedil;o e corte para Top 8.</div>
<div>
	&nbsp;</div>
<div>
	As passagens ser&atilde;o emitidas ao final do torneio. Em fun&ccedil;&atilde;o disso, todos os jogadores devem planejar antecipadamente suas datas de viagem.</div>
<div>
	&nbsp;</div>
<div>
	Data do Gran Prix</div>
<div>
	March 14-16, 2014</div>
<div>
	Buenos Aires</div>
<div>
	Argentina</div>
<div>
	STANDART</div>
', NULL, '<div>
	Premia&ccedil;&atilde;o em boosters para os 16 melhores colocados na etapa classificat&oacute;ria (Su&iacute;&ccedil;o), baseada no n&uacute;mero de jogadores. O vencedor do Top 8 receber&aacute; uma passagem para o GP Buenos Aires 2014 (acima de 50 inscritos, o segundo colocado tamb&eacute;m receber&aacute; uma passagem para este GP).</div>
<div>
	&nbsp;</div>
', '2013-12-01', '20:00', '1', 'Venha participar de mais um torneio GP Trip e conquistar uma passagem para o Grand Prix Buenos Aires 2014!', NULL, NULL );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '4', NULL, '1', '2', 'FNM Dice HS', '5292343fafe23.jpg', NULL, NULL, NULL, NULL, NULL, '1', 'Toda Sexta-Feira, as 20h, FNM T2 na Dice Hobby Store!', NULL, 'Sexta as 20h' );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '5', '1', NULL, '2', 'T2 de Domingo', '529235249a2c3.jpg', NULL, NULL, NULL, NULL, NULL, '1', 'Cansado de ver Faustão? Venha jogar um T2 maroto no domingo conosco', NULL, 'Sábado as 17h (ou quando fechar 8)' );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '6', '5', NULL, '2', 'Mesão de Commander de Quarta', '5292346680a39.jpg', NULL, NULL, NULL, NULL, NULL, '1', 'Venha jogar um Commander as quartas-feiras', NULL, 'Quartas-feiras as 20h' );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '7', '3', NULL, '1', 'Pré-Lançamento Born of the Gods', '52923475d8546.jpg', '<p>
	Lan&ccedil;amento da nova edi&ccedil;&atilde;o Born of the Gods</p>
', NULL, '<p>
	Lan&ccedil;amento da nova edi&ccedil;&atilde;o Born of the Gods</p>
', '2013-11-20', '10:00', '1', 'Lançamento da nova edição Born of the Gods, segundo bloco de Theros!', NULL, NULL );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '8', NULL, '1', '1', 'Evento de Encerramento da Temporada', '529235849208c.jpg', '<p>
	Venha jogar conosco o Evento de Encerramento da Temporada 2013 da Temporada FNM 2013</p>
', '<p>
	Venha jogar conosco o Evento de Encerramento da Temporada 2013 da Temporada FNM 2013</p>
', '<p>
	Venha jogar conosco o Evento de Encerramento da Temporada 2013 da Temporada FNM 2013</p>
', '2013-12-01', '14:00', '1', 'Venha jogar conosco o Evento de Encerramento da Temporada 2013 da Temporada FNM 2013', NULL, NULL );
INSERT INTO `sl_evento`(`id_evento`,`id_formato`,`id_liga`,`tipo`,`titulo`,`imagem`,`texto_anuncio`,`texto_report`,`premiacao`,`data`,`hora`,`publicado`,`chamada`,`id_ranking`,`dia_hora_permanente`) VALUES ( '9', '4', NULL, '1', 'Draft da Virada de Ano', '5296763e9090d.jpg', '<p>
	Composi&ccedil;&atilde;o de Boosters: 3 Theros</p>
<p>
	Formato do Torneio: Su&iacute;&ccedil;o com corte para Top 4</p>
', NULL, '<p>
	Cartas promo para todos os jogadores</p>
<p>
	Top4 com premia&ccedil;&atilde;o de acordo com o numero de boosters.</p>
', '2013-11-30', '14:00', '1', 'Venha aproveitar o feriadão da Virada de Ano fazendo um Draft de Theros com os melhores do mundo.', NULL, NULL );;
-- ---------------------------------------------------------


-- Dump data of "sl_formato" ------------------------------
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '1', 'Standard (T2)' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '2', 'Standard For Fun' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '3', 'Selado' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '4', 'Draft' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '5', 'Commander' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '6', 'Pauper' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '7', 'Modern' );
INSERT INTO `sl_formato`(`id_formato`,`nome`) VALUES ( '8', 'Legacy' );;
-- ---------------------------------------------------------


-- Dump data of "sl_liga" ---------------------------------
INSERT INTO `sl_liga`(`id_liga`,`id_formato`,`nome`,`texto`,`publicado`,`texto_premiacao`) VALUES ( '1', '1', 'FNM Temporada 2013', '<p>
	A temporada ser&aacute; composta de 1293 rodadas, inciiando-se em 292 e terminando em 211209. Nesta temporada, os pontos ser&atilde;o distribuidos conforme a pontua&ccedil;ao abaixo:</p>
<p>
	1o lugar = 10 pontos</p>
<p>
	2o lugar = 5 pontos</p>
<p>
	3o lugar = 2 pontos</p>
<p>
	O ranking se refere apenas a campeonatos FNM disputados na Dice Hobby Store de Rio Grande.</p>
', '1', '<p>
	1 - 3: premia&ccedil;&atilde;o do primeiro ao terceiro</p>
<p>
	4 - 8: premia&ccedil;&atilde;o do quarto ao oitavo</p>
<p>
	Os classificados ter&atilde;o lorem impsum sit amet dolor no campeonato lorem impsum sit amet dolor.</p>
' );
INSERT INTO `sl_liga`(`id_liga`,`id_formato`,`nome`,`texto`,`publicado`,`texto_premiacao`) VALUES ( '2', '5', 'Liga Commander', NULL, '0', NULL );;
-- ---------------------------------------------------------


-- Dump data of "sl_publicacao" ---------------------------
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '1', 'Dúvidas e Regras de Magic', '2013-11-20', '528c34239390e.jpg', '<p>
	Este artigo ir&aacute; sanar as principais d&uacute;vidas dos jogadores em rela&ccedil;&atilde;o a regras e etc</p>
', '1', 'Este artigo irá sanar as principais dúvidas dos jogadores em relação a regras e etc' );
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '2', 'Lista de Banidas de Commander', '2013-11-20', '528c345492aba.jpg', '<div>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam imperdiet urna vitae laoreet molestie. Duis sed molestie risus. Donec consectetur orci nisi, blandit ultrices mauris tristique in. Mauris non tempor tortor. Suspendisse vehicula libero at tortor accumsan, in condimentum mauris euismod. Praesent at egestas mauris. Sed quis adipiscing sem. Morbi molestie non nibh non ultricies. Pellentesque lobortis vulputate suscipit. Ut cursus justo orci, non consectetur erat ultricies vitae.</div>
<div>
	&nbsp;</div>
<div>
	Donec laoreet dignissim lectus, a euismod eros malesuada in. Sed sed convallis est. Phasellus sit amet tempor est, et pretium ipsum. Pellentesque sit amet dignissim ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean viverra dictum tincidunt. Aliquam erat volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur auctor est in molestie tempus. Morbi elementum non eros vel laoreet.</div>
<div>
	&nbsp;</div>
<div>
	Vestibulum at arcu ut elit tincidunt dapibus malesuada id purus. Cras sem nunc, dignissim eget orci eu, tincidunt ornare risus. Aenean in molestie leo. Nulla dictum fringilla ipsum non dictum. Proin varius orci quis hendrerit sagittis. Maecenas id augue sed ipsum volutpat sagittis. Sed dignissim mi non elit facilisis, eget bibendum nibh blandit. Aenean tincidunt condimentum turpis, eu sagittis nisl aliquam non.</div>
<div>
	&nbsp;</div>
<div>
	Aliquam ornare felis id leo auctor condimentum. Vivamus at erat sit amet nisl tempus suscipit et id augue. Aenean nisl augue, sollicitudin sed fringilla id, imperdiet eu sapien. Praesent quis purus sagittis, condimentum mi nec, molestie nunc. Nunc commodo lectus a varius egestas. Nullam facilisis et massa non pretium. Nam fermentum molestie mauris, in tincidunt massa pharetra in. In aliquam leo mauris. Mauris euismod sodales ante, vitae suscipit eros pellentesque sit amet.</div>
<div>
	&nbsp;</div>
<div>
	Donec auctor sagittis orci non varius. Aliquam porta mi quis fringilla pharetra. Nulla aliquet nisl ligula, non volutpat lectus rhoncus vestibulum. Donec euismod metus id augue bibendum, at blandit tellus dignissim. Phasellus venenatis id orci vitae faucibus. Curabitur risus ante, facilisis nec cursus eget, consectetur nec nulla. Nunc velit velit, fermentum et aliquam eget, dictum sed turpis. Nullam eu magna nibh.</div>
', '1', 'Lista de banidas de Commander foi atualizada, e temos novidades importantes para todos!' );
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '3', 'Novas Mecânicas de Born of the Gods', '2013-11-25', '528c348583422.jpg', '<p>
	Foram reveladas as novas mec&acirc;nicas presentes na edi&ccedil;&atilde;o Born of the Gods, e elas prometem abalar o Magic!</p>
', '1', 'Foram reveladas as novas mecânicas presentes na edição Born of the Gods' );
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '4', 'Lorem Impsum Sit Amet Dolor', '2013-11-24', '529239fded72a.jpg', '<p>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna a</p>
', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt' );
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '5', 'Lorem ipsum dolor sit amet', '2013-11-24', '52923a1c056a4.jpg', '<p>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna a</p>
', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
' );
INSERT INTO `sl_publicacao`(`id_publicacao`,`titulo`,`data`,`imagem`,`texto`,`publicado`,`chamada`) VALUES ( '6', 'Lorem ipsum dolor sit amet', '2013-11-24', '52923a34a6f50.jpg', NULL, '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt' );;
-- ---------------------------------------------------------


-- Dump data of "sl_ranking" ------------------------------
INSERT INTO `sl_ranking`(`id_ranking`,`id_liga`,`rodada`,`data`,`texto_report`,`texto_ranking`,`publicado`,`chamada`,`imagem`) VALUES ( '1', '1', '2', '2013-11-12', '<p>
	Report do campeonato</p>
', '<p>
	Ranking!</p>
', '1', 'Mais um campeonato vencido pelo lorem impsum sit amet dolor. Quem irá parar este deck?', '528c123b8f7f7.jpg' );
INSERT INTO `sl_ranking`(`id_ranking`,`id_liga`,`rodada`,`data`,`texto_report`,`texto_ranking`,`publicado`,`chamada`,`imagem`) VALUES ( '2', '1', '3', '2013-11-16', '<p>
	Report</p>
', '<p>
	Ranking</p>
', '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna', '528c12459f9b0.jpg' );
INSERT INTO `sl_ranking`(`id_ranking`,`id_liga`,`rodada`,`data`,`texto_report`,`texto_ranking`,`publicado`,`chamada`,`imagem`) VALUES ( '3', '1', '5', '2013-11-20', '<p>
	Nesse final de semana rolou a pen&uacute;ltima rodada da 1&ordf; temporada do Standard 4 Fun em S&atilde;o Leopoldo. Mais uma vez o destaque ficou para o grande n&uacute;mero de jogadores, dando 5 rodadas de torneio.&nbsp;</p>
<p>
	Em 4&ordm; lugar, jogando de Mono Black Midrange ficou o Roberto Ramos (Robertinho). Ele foi o melhor jogador com 10 pontos.&nbsp;</p>
<p>
	Na 3&ordf; coloca&ccedil;&atilde;o tivemos o Felipe Moreira que jogou de Mono Black Devotion. Com essa coloca&ccedil;&atilde;o o Felipe voltou a assumir a 3&ordf; coloca&ccedil;&atilde;o do ranking.&nbsp;</p>
<p>
	O 2&ordm; lugar ficou com o Gustavo Ribas (Diab&atilde;o) jogando de Boros Control, que agora est&aacute; bem pr&oacute;ximo do atual l&iacute;der do ranking Daniel Krug.&nbsp;</p>
<p>
	A disputa pelo t&iacute;tulo vai ficar para o &uacute;ltimo torneio. O campe&atilde;o da semana foi o Adriano Pereira (Foca), que tamb&eacute;m jogou de Mono Black Devotion e fez 13 pontos, terminando invicto. Muito obrigado a todos que prestigiaram o evento.</p>
', '<table border="0" cellpadding="0" cellspacing="0" style="width:584px;" width="438">
	<colgroup>
		<col />
		<col />
		<col />
		<col />
		<col />
	</colgroup>
	<tbody>
		<tr height="18">
			<td height="18" style="height:25px;width:61px;">
				Posi&ccedil;&atilde;o</td>
			<td style="width:268px;">
				Jogador</td>
			<td style="width:68px;">
				PONTOS</td>
			<td style="width:73px;">
				FNM&#39;s</td>
			<td style="width:113px;">
				M&eacute;dia de pts.</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				1</td>
			<td style="width:268px;">
				Leon Soares Puccinelli</td>
			<td style="width:68px;">
				268</td>
			<td style="width:73px;">
				20</td>
			<td style="width:113px;">
				13,7</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				2</td>
			<td style="width:268px;">
				Joao Felipe Ferreira Pereira (Kalled)</td>
			<td style="width:68px;">
				234</td>
			<td style="width:73px;">
				21</td>
			<td style="width:113px;">
				11,7</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				3</td>
			<td style="width:268px;">
				Cledir San Martin</td>
			<td style="width:68px;">
				205</td>
			<td style="width:73px;">
				16</td>
			<td style="width:113px;">
				12,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				4</td>
			<td style="width:268px;">
				Claudio Malta (Pingo)</td>
			<td style="width:68px;">
				163</td>
			<td style="width:73px;">
				13</td>
			<td style="width:113px;">
				12,6</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				5</td>
			<td style="width:268px;">
				Rodrigo Alves (Cobra)</td>
			<td style="width:68px;">
				159</td>
			<td style="width:73px;">
				18</td>
			<td style="width:113px;">
				8,8</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				6</td>
			<td style="width:268px;">
				Marcio Antonio Silveira (Boca)</td>
			<td style="width:68px;">
				137</td>
			<td style="width:73px;">
				16</td>
			<td style="width:113px;">
				7,9</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				7</td>
			<td style="width:268px;">
				Renato Santos Jr. (Deby)</td>
			<td style="width:68px;">
				119</td>
			<td style="width:73px;">
				16</td>
			<td style="width:113px;">
				7,9</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				8</td>
			<td style="width:268px;">
				Cristian R.costa (Fuinha)</td>
			<td style="width:68px;">
				116</td>
			<td style="width:73px;">
				14</td>
			<td style="width:113px;">
				8,9</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				9</td>
			<td style="width:268px;">
				Dione Bernardotti</td>
			<td style="width:68px;">
				110</td>
			<td style="width:73px;">
				13</td>
			<td style="width:113px;">
				7,9</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				10</td>
			<td style="width:268px;">
				Eduardo Souza (Duda)</td>
			<td style="width:68px;">
				101</td>
			<td style="width:73px;">
				9</td>
			<td style="width:113px;">
				11,9</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				11</td>
			<td style="width:268px;">
				Thales N&oacute;brega (Cincinatti)</td>
			<td style="width:68px;">
				99</td>
			<td style="width:73px;">
				8</td>
			<td style="width:113px;">
				12,4</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				12</td>
			<td style="width:268px;">
				Leandro Marques (Mirim)</td>
			<td style="width:68px;">
				94</td>
			<td style="width:73px;">
				8</td>
			<td style="width:113px;">
				11,8</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				13</td>
			<td style="width:268px;">
				Marcelo Pereira</td>
			<td style="width:68px;">
				45</td>
			<td style="width:73px;">
				9</td>
			<td style="width:113px;">
				5,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				14</td>
			<td style="width:268px;">
				Angelo Bonamigo</td>
			<td style="width:68px;">
				41</td>
			<td style="width:73px;">
				10</td>
			<td style="width:113px;">
				4,6</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				15</td>
			<td style="width:268px;">
				Gilberto Bielenki (Doctor)</td>
			<td style="width:68px;">
				35</td>
			<td style="width:73px;">
				5</td>
			<td style="width:113px;">
				7,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				16</td>
			<td style="width:268px;">
				Marcelo Borges (Neg&atilde;o)</td>
			<td style="width:68px;">
				33</td>
			<td style="width:73px;">
				5</td>
			<td style="width:113px;">
				6,6</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				17</td>
			<td style="width:268px;">
				Guilherme Reis</td>
			<td style="width:68px;">
				29</td>
			<td style="width:73px;">
				10</td>
			<td style="width:113px;">
				3,2</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				18</td>
			<td style="width:268px;">
				Maico Rigatti</td>
			<td style="width:68px;">
				20</td>
			<td style="width:73px;">
				6</td>
			<td style="width:113px;">
				3,2</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				19</td>
			<td>
				Rodrigo Rodrigues (Presuntinho)</td>
			<td>
				19</td>
			<td style="width:73px;">
				3</td>
			<td style="width:113px;">
				6,3</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				20</td>
			<td style="width:268px;">
				Benhur da Silva</td>
			<td style="width:68px;">
				16</td>
			<td style="width:73px;">
				5</td>
			<td style="width:113px;">
				3,8</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				21</td>
			<td style="width:268px;">
				Renan Dol&aacute;cio</td>
			<td style="width:68px;">
				15</td>
			<td style="width:73px;">
				1</td>
			<td style="width:113px;">
				15,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				22</td>
			<td style="width:268px;">
				Luiz Fernando Rodrigues</td>
			<td style="width:68px;">
				12</td>
			<td style="width:73px;">
				2</td>
			<td style="width:113px;">
				6,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				23</td>
			<td style="width:268px;">
				Marco Aurelio</td>
			<td style="width:68px;">
				12</td>
			<td style="width:73px;">
				2</td>
			<td style="width:113px;">
				6,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				23</td>
			<td style="width:268px;">
				Thiago Teixeira</td>
			<td style="width:68px;">
				8</td>
			<td style="width:73px;">
				5</td>
			<td style="width:113px;">
				1,6</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				24</td>
			<td style="width:268px;">
				Mauricio Avila</td>
			<td style="width:68px;">
				7</td>
			<td style="width:73px;">
				2</td>
			<td style="width:113px;">
				3,5</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				25</td>
			<td style="width:268px;">
				Marcelo Paiva</td>
			<td style="width:68px;">
				7</td>
			<td style="width:73px;">
				4</td>
			<td style="width:113px;">
				1,8</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				26</td>
			<td style="width:268px;">
				Matheus da Silva</td>
			<td style="width:68px;">
				2</td>
			<td style="width:73px;">
				1</td>
			<td style="width:113px;">
				2,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				27</td>
			<td style="width:268px;">
				Fernando Valente</td>
			<td style="width:68px;">
				0</td>
			<td style="width:73px;">
				1</td>
			<td style="width:113px;">
				0,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				28</td>
			<td style="width:268px;">
				Rodrigo Santana</td>
			<td style="width:68px;">
				0</td>
			<td style="width:73px;">
				2</td>
			<td style="width:113px;">
				0,0</td>
		</tr>
		<tr height="14">
			<td height="14" style="height:19px;width:61px;">
				29</td>
			<td style="width:268px;">
				Rodrigo Santos</td>
			<td style="width:68px;">
				0</td>
			<td style="width:73px;">
				1</td>
			<td style="width:113px;">
				0,0</td>
		</tr>
	</tbody>
</table>
<p>
	&nbsp;</p>
', '1', 'Neste campeonato, o campeão foi o famoso deck lorem impsum sit amet dolor. Parabéns ao Sit Amet Dolor!', '528c12509269f.jpg' );
INSERT INTO `sl_ranking`(`id_ranking`,`id_liga`,`rodada`,`data`,`texto_report`,`texto_ranking`,`publicado`,`chamada`,`imagem`) VALUES ( '4', '1', '4', '2013-11-17', NULL, NULL, '1', 'Desta vez, o campeonato foi vencido pelo lorem impsum sit amet dolor. Novidades no metagame?', '528c13607565b.jpg' );
INSERT INTO `sl_ranking`(`id_ranking`,`id_liga`,`rodada`,`data`,`texto_report`,`texto_ranking`,`publicado`,`chamada`,`imagem`) VALUES ( '6', '2', '1', '2013-11-28', NULL, NULL, '1', NULL, '5296997488d2a.jpg' );;
-- ---------------------------------------------------------


-- CREATE INDEX "id_conteudo_categoria" --------------------
CREATE INDEX `sl_id_conteudo_categoria` USING BTREE ON `sl_conteudo`( `id_conteudo_categoria` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_conteudo`( `id_lang` );
CREATE INDEX `sl_id_main` USING BTREE ON `sl_conteudo`( `id_main` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_conteudo_categoria`( `id_lang` );
CREATE INDEX `sl_id_main` USING BTREE ON `sl_conteudo_categoria`( `id_main` );
CREATE INDEX `sl_id_conteudo` USING BTREE ON `sl_conteudo_midia`( `id_conteudo` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_conteudo_midia`( `id_lang` );
CREATE INDEX `sl_id_main` USING BTREE ON `sl_conteudo_midia`( `id_main` );
CREATE INDEX `sl_id_conteudo` USING BTREE ON `sl_menu`( `id_conteudo` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_menu`( `id_lang` );
CREATE INDEX `sl_id_main` USING BTREE ON `sl_menu`( `id_main` );
CREATE INDEX `sl_id_menu` USING BTREE ON `sl_modulo_menu`( `id_menu` );
CREATE INDEX `sl_id_modulo` USING BTREE ON `sl_modulo_menu`( `id_modulo` );
CREATE INDEX `sl_id_menu` USING BTREE ON `sl_seo_menu`( `id_menu` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_seo_url`( `id_lang` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_templates_menu`( `id_lang` );
CREATE INDEX `sl_id_lang` USING BTREE ON `sl_texto_layout`( `id_lang` );
CREATE INDEX `sl_id_menu_admin` USING BTREE ON `sl_usuario_grupo_menu_admin`( `id_menu_admin` );
CREATE INDEX `sl_id_usuario_grupo` USING BTREE ON `sl_usuario_grupo_menu_admin`( `id_usuario_grupo` );
CREATE INDEX `sl_id_usuario` USING BTREE ON `sl_usuario_usuario_grupo`( `id_usuario` );
CREATE INDEX `sl_id_usuario_grupo` USING BTREE ON `sl_usuario_usuario_grupo`( `id_usuario_grupo` );
CREATE UNIQUE INDEX `sl_new_url` USING BTREE ON `sl_seo_url`( `url_new` );
-- ---------------------------------------------------------

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


