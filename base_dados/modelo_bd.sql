CREATE TABLE `mensagens_contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255),
  `email` varchar(255),
  `mensagem` text,
  `data_envio` datetime
);

CREATE TABLE `conteudos_publicos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_campo` varchar(255) UNIQUE NOT NULL,
  `conteudo_campo` text
);

CREATE TABLE `localizacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `edificio` varchar(255),
  `piso` varchar(255),
  `servico` varchar(255),
  `sala` varchar(255),
  `observacoes` text
);

CREATE TABLE `fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `nif` varchar(255),
  `telefone` varchar(255),
  `email` varchar(255),
  `morada` varchar(255),
  `website` varchar(255),
  `pessoa_contacto` varchar(255),
  `telefone_pessoa_contacto` varchar(255),
  `tipo` varchar(255),
  `observacoes` text
);

CREATE TABLE `documentacao_fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fornecedor_id` int NOT NULL,
  `tipo_documento` varchar(255),
  `nome_documento` varchar(255),
  `data_documento` date,
  `validade_documento` date,
  `ficheiro_documento` varchar(255)
);

CREATE TABLE `equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `designacao` varchar(255) NOT NULL,
  `categoria` varchar(255),
  `marca` varchar(255),
  `modelo` varchar(255),
  `numero_serie` varchar(255),
  `fabricante` varchar(255),
  `ano_fabrico` int,
  `estado` varchar(255),
  `criticidade` varchar(255),
  `observacoes` text,
  `localizacao_id` int,
  `observacoes_localizacao` text
);

CREATE TABLE `documentacao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `tipo_separador` varchar(255),
  `tipo_documento` varchar(255),
  `nome_documento` varchar(255),
  `data_documento` date,
  `validade_documento` date,
  `ficheiro_documento` varchar(255)
);

CREATE TABLE `acessorios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255),
  `referencia` varchar(255),
  `quantidade` int,
  `unidade` varchar(255),
  `estado` varchar(255),
  `observacoes` text
);

CREATE TABLE `consumiveis` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255),
  `referencia` varchar(255),
  `quantidade` int,
  `unidade` varchar(255),
  `estado` varchar(255),
  `observacoes` text
);

CREATE TABLE `aquisicao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `data_aquisicao` date,
  `custo_aquisicao` decimal(10,2),
  `tipo_entrada` varchar(255),
  `observacoes` text
);

CREATE TABLE `equipamento_fornecedor` (
  `equipamento_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `tipo_fornecedor` varchar(255),
  `pessoa_contacto` varchar(255),
  `telefone_pessoa_contacto` varchar(255),
  `morada` varchar(255),
  `observacoes` text,
  PRIMARY KEY (`equipamento_id`, `fornecedor_id`)
);

CREATE TABLE `garantias_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `data_inicio` date,
  `data_fim` date,
  `observacoes` text
);

CREATE TABLE `contratos_manutencao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `tem_contrato` boolean,
  `tipo_contrato` varchar(255),
  `entidade_responsavel` varchar(255),
  `periodicidade` varchar(255),
  `observacoes` text
);

CREATE TABLE `utilizadores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `perfil` varchar(255),
  `ativo` boolean,
  `created_at` datetime
);

CREATE TABLE `historico_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `utilizador_id` int,
  `tipo_alteracao` varchar(255),
  `descricao` text,
  `data_alteracao` datetime
);

ALTER TABLE `documentacao_fornecedores` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`localizacao_id`) REFERENCES `localizacoes` (`id`);

ALTER TABLE `documentacao_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `acessorios` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `consumiveis` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `aquisicao_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `garantias_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);
