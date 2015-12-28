/*
MySQL Data Transfer
Source Host: localhost
Source Database: thru
Target Host: localhost
Target Database: thru
Date: 10/11/2011 14:02:33
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for categoria
-- ----------------------------
CREATE TABLE `categoria` (
  `id_categoria` int(4) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(45) NOT NULL,
  `excluido` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for comocomprar
-- ----------------------------
CREATE TABLE `comocomprar` (
  `id` int(1) NOT NULL,
  `link` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contato
-- ----------------------------
CREATE TABLE `contato` (
  `usuario` varchar(40) NOT NULL,
  `dt_nasc` char(10) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` text,
  `news` binary(1) NOT NULL DEFAULT '0',
  `completo` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for contatos
-- ----------------------------
CREATE TABLE `contatos` (
  `id_msg` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `mensagem` text,
  `respondida` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_msg`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for endereco
-- ----------------------------
CREATE TABLE `endereco` (
  `id_endereco` int(4) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(40) DEFAULT NULL,
  `cidade` varchar(80) DEFAULT NULL,
  `rua` varchar(80) DEFAULT NULL,
  `bairro` varchar(80) DEFAULT NULL,
  `numero` int(10) DEFAULT NULL,
  `complemento` varchar(80) DEFAULT NULL,
  `latitude` int(20) DEFAULT NULL,
  `longitude` int(20) DEFAULT NULL,
  `completo` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_endereco`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for galeria
-- ----------------------------
CREATE TABLE `galeria` (
  `id_foto` int(4) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(80) NOT NULL,
  `galeria` varchar(80) DEFAULT NULL,
  `excluido` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_foto`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for galerias
-- ----------------------------
CREATE TABLE `galerias` (
  `id_galeria` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `excluido` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_galeria`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ingredientes
-- ----------------------------
CREATE TABLE `ingredientes` (
  `opcional` binary(1) NOT NULL DEFAULT '0',
  `qtd_padrao` int(2) NOT NULL DEFAULT '1',
  `qtd_min` int(2) NOT NULL DEFAULT '0',
  `qtd_max` int(2) NOT NULL DEFAULT '1',
  `id_ingrediente` int(4) NOT NULL,
  `id_produto` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for lista_ingredientes
-- ----------------------------
CREATE TABLE `lista_ingredientes` (
  `id_ingrediente` int(4) NOT NULL AUTO_INCREMENT,
  `nome_ingrediente` varchar(80) NOT NULL,
  PRIMARY KEY (`id_ingrediente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
CREATE TABLE `menus` (
  `id_menu` int(1) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `titulo` text,
  `conteudo` text,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for novidades
-- ----------------------------
CREATE TABLE `novidades` (
  `id_noticia` int(4) NOT NULL AUTO_INCREMENT,
  `texto` text,
  `excluido` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_noticia`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pedido
-- ----------------------------
CREATE TABLE `pedido` (
  `id_pedido` int(4) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `data` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cliente` varchar(45) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for produto
-- ----------------------------
CREATE TABLE `produto` (
  `id_produto` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `preco` varchar(45) NOT NULL DEFAULT '0',
  `promocao` binary(1) NOT NULL DEFAULT '0',
  `excluido` binary(1) NOT NULL DEFAULT '0',
  `categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for resetpass
-- ----------------------------
CREATE TABLE `resetpass` (
  `id_reset` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  PRIMARY KEY (`id_reset`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
CREATE TABLE `usuario` (
  `idusuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `tipo` enum('cliente','administrador') DEFAULT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `completo` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `categoria` VALUES ('1', 'Diversos', '0');
INSERT INTO `comocomprar` VALUES ('1', 'http://www.youtube.com/watch?v=zy1F13krvd0&feature=related');
INSERT INTO `contato` VALUES ('10', '11/11/1991', '159176654', 'MAILLL', '0', '0');
INSERT INTO `contato` VALUES ('111', '12/12/1111', '234', 'AL', '0', '0');
INSERT INTO `contato` VALUES ('159159159', '12/12/1111', '234', 'AL', '0', '0');
INSERT INTO `contato` VALUES ('1234555', null, null, null, '0', '0');
INSERT INTO `contato` VALUES ('moda', null, null, null, '0', '0');
INSERT INTO `contato` VALUES ('1', '11/22', '213', 'sd', '0', '1');
INSERT INTO `contato` VALUES ('123', '11/1', '234', 'maillalala', '0', '1');
INSERT INTO `contato` VALUES ('1515151515', null, null, null, '0', '0');
INSERT INTO `contato` VALUES ('123123123', null, null, null, '0', '0');
INSERT INTO `contatos` VALUES ('1', 'nome', '12413', 'mail@aa.cc', 'sldkdflkasdlakdlskdl', '1');
INSERT INTO `contatos` VALUES ('2', 'dsjfo', '231', 'm@ss', 'dosvs', '1');
INSERT INTO `contatos` VALUES ('3', 'dfgvsdfs', '45646', 'sdf@cc.cc', 'gsdfdfa', '0');
INSERT INTO `contatos` VALUES ('4', 'fxgfs', '546', 'a@cc.x', 'fdgfdg', '0');
INSERT INTO `contatos` VALUES ('5', 'nomemem', '12344', 'mail@user.com', 'essa Ã© a mensagem de teste de formulario :*', '0');
INSERT INTO `endereco` VALUES ('8', '111', null, null, null, null, null, null, null, '0');
INSERT INTO `endereco` VALUES ('9', '159159159', null, null, null, null, null, null, null, '0');
INSERT INTO `endereco` VALUES ('10', '10', 'ruazinha', null, 'bairro z', '1', 'nao tem', '0', '0', '1');
INSERT INTO `endereco` VALUES ('11', '1234555', null, null, null, null, null, null, null, '0');
INSERT INTO `endereco` VALUES ('12', 'moda', null, null, null, null, null, null, null, '0');
INSERT INTO `endereco` VALUES ('13', '1', 'cidadeee', 'sdfsdfds', 'sdfsdfsd', '12', '', '0', '0', '1');
INSERT INTO `endereco` VALUES ('14', '1515151515', null, null, null, null, null, null, null, '0');
INSERT INTO `endereco` VALUES ('15', '123123123', null, null, null, null, null, null, null, '0');
INSERT INTO `galeria` VALUES ('9', 'Cachorro?', 'wolf', '0');
INSERT INTO `galeria` VALUES ('10', 'Coca', 'coke', '0');
INSERT INTO `galeria` VALUES ('11', 'DK', 'donkey', '0');
INSERT INTO `galerias` VALUES ('1', 'wolf', '0');
INSERT INTO `galerias` VALUES ('2', 'donkey', '0');
INSERT INTO `galerias` VALUES ('10', 'coke', '0');
INSERT INTO `galerias` VALUES ('11', 'autobots', '1');
INSERT INTO `menus` VALUES ('1', 'sobrenos', 'Sobre NÃ³s', 'Esse Ã© o novo texto do menu Sobre NÃ³s!');
INSERT INTO `novidades` VALUES ('1', 'Esse é um texto de teste do menu novidades (:', '0');
INSERT INTO `novidades` VALUES ('2', 'teste de criação de novidade', '0');
INSERT INTO `produto` VALUES ('25', 'Xis Polenta', '1000', '1', '0', 'Xis');
INSERT INTO `produto` VALUES ('26', 'Que Cachorro', '450', '1', '0', 'Xis');
INSERT INTO `usuario` VALUES ('2', 'admin', 'administrador', 'admin', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `usuario` VALUES ('3', 'Uni', 'cliente', '123', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `usuario` VALUES ('4', 'nom', 'cliente', 'nom', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `usuario` VALUES ('5', 'nono', 'cliente', '12344', 'd10906c3dac1172d4f60bd41f224ae75', '0');
INSERT INTO `usuario` VALUES ('6', 'novo', 'cliente', '111', '698d51a19d8a121ce581499d7b701668', '0');
INSERT INTO `usuario` VALUES ('7', 'Willian', 'cliente', '159159159', '140f6969d5213fd0ece03148e62e461e', '0');
INSERT INTO `usuario` VALUES ('8', 'teste', 'cliente', '10', 'd3d9446802a44259755d38e6d163e820', '0');
INSERT INTO `usuario` VALUES ('9', 'TesteNii', 'cliente', '1234555', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `usuario` VALUES ('10', 'foca', 'cliente', 'moda', '202cb962ac59075b964b07152d234b70', '0');
INSERT INTO `usuario` VALUES ('11', 'uno', 'cliente', '1', 'c4ca4238a0b923820dcc509a6f75849b', '0');
INSERT INTO `usuario` VALUES ('12', '', 'cliente', '2111212', 'd41d8cd98f00b204e9800998ecf8427e', '0');
INSERT INTO `usuario` VALUES ('13', 'Ramon', 'cliente', '1515151515', '3fd543fb4ca26994f93d8e77269fb34b', '0');
INSERT INTO `usuario` VALUES ('14', 'testecadastro', 'cliente', '123123123', 'f5bb0c8de146c67b44babbf4e6584cc0', '0');
