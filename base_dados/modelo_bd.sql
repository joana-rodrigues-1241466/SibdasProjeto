CREATE TABLE `estados_equipamento` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `criticidades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `categorias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_fornecedor` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_entrada` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `separadores_documentacao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_documento_equipamento` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `separador_id` int,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_documento_fornecedor` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `perfis_utilizador` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_contrato` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `periodicidades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `unidades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `estados_acessorio` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `valor` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `utilizadores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `perfil_id` int NOT NULL,
  `ativo` boolean DEFAULT true,
  `token_reset` varchar(255),
  `token_expira` datetime,
  `token_remember` varchar(255),
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `localizacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `edificio` varchar(255),
  `piso` varchar(255),
  `servico` varchar(255),
  `sala` varchar(255),
  `observacoes` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `nif` varchar(255),
  `telefone` varchar(255),
  `email` varchar(255),
  `distrito` varchar(255),
  `pais` varchar(255) DEFAULT 'Portugal',
  `website` varchar(255),
  `pessoa_contacto` varchar(255),
  `telefone_pessoa_contacto` varchar(255),
  `tipo_id` int,
  `observacoes` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `documentacao_fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fornecedor_id` int NOT NULL,
  `tipo_documento_id` int,
  `nome_documento` varchar(255),
  `data_documento` date,
  `validade_documento` date,
  `ficheiro_documento` varchar(255),
  `nome_original_ficheiro` varchar(255)
);

CREATE TABLE `equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `designacao` varchar(255) NOT NULL,
  `categoria_id` int,
  `marca` varchar(255),
  `modelo` varchar(255),
  `numero_serie` varchar(255),
  `fabricante` varchar(255),
  `ano_fabrico` int,
  `estado_id` int,
  `criticidade_id` int,
  `observacoes` text,
  `localizacao_id` int,
  `observacoes_localizacao` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `documentacao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `separador_id` int,
  `tipo_documento_id` int,
  `nome_documento` varchar(255),
  `data_documento` date,
  `validade_documento` date,
  `ficheiro_documento` varchar(255),
  `nome_original_ficheiro` varchar(255)
);

CREATE TABLE `acessorios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255),
  `referencia` varchar(255),
  `quantidade` int DEFAULT 1,
  `unidade_id` int,
  `estado_id` int,
  `observacoes` text
);

CREATE TABLE `consumiveis` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255),
  `referencia` varchar(255),
  `quantidade` int DEFAULT 1,
  `unidade_id` int,
  `estado_id` int,
  `observacoes` text
);

CREATE TABLE `aquisicao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `data_aquisicao` date,
  `custo_aquisicao` decimal(10,2),
  `moeda` varchar(255) DEFAULT 'EUR',
  `tipo_entrada_id` int,
  `observacoes` text,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `equipamento_fornecedor` (
  `equipamento_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `tipo_fornecedor_id` int,
  `pessoa_contacto` varchar(255),
  `telefone_pessoa_contacto` varchar(255),
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
  `tem_contrato` boolean DEFAULT false,
  `tipo_contrato_id` int,
  `entidade_responsavel` varchar(255),
  `periodicidade_id` int,
  `observacoes` text
);

CREATE TABLE `historico_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `utilizador_id` int,
  `tipo_alteracao` varchar(255),
  `descricao` text,
  `dados_anteriores` json,
  `dados_novos` json,
  `data_alteracao` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `conteudos_publicos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_campo` varchar(255) UNIQUE NOT NULL,
  `conteudo_campo` text,
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `mensagens_contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255),
  `email` varchar(255),
  `mensagem` text,
  `data_envio` datetime DEFAULT (CURRENT_TIMESTAMP),
  `lido` boolean DEFAULT false,
  `lido_em` datetime,
  `lido_por` int
);

CREATE UNIQUE INDEX `equipamentos_index_0` ON `equipamentos` (`numero_serie`, `fabricante`, `modelo`);

ALTER TABLE `tipos_documento_equipamento` ADD FOREIGN KEY (`separador_id`) REFERENCES `separadores_documentacao` (`id`);

ALTER TABLE `utilizadores` ADD FOREIGN KEY (`perfil_id`) REFERENCES `perfis_utilizador` (`id`);

ALTER TABLE `fornecedores` ADD FOREIGN KEY (`tipo_id`) REFERENCES `tipos_fornecedor` (`id`);

ALTER TABLE `documentacao_fornecedores` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `documentacao_fornecedores` ADD FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documento_fornecedor` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados_equipamento` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`criticidade_id`) REFERENCES `criticidades` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`localizacao_id`) REFERENCES `localizacoes` (`id`);

ALTER TABLE `documentacao_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `documentacao_equipamentos` ADD FOREIGN KEY (`separador_id`) REFERENCES `separadores_documentacao` (`id`);

ALTER TABLE `documentacao_equipamentos` ADD FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documento_equipamento` (`id`);

ALTER TABLE `acessorios` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `acessorios` ADD FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`);

ALTER TABLE `acessorios` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados_acessorio` (`id`);

ALTER TABLE `consumiveis` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `consumiveis` ADD FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`);

ALTER TABLE `consumiveis` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados_acessorio` (`id`);

ALTER TABLE `aquisicao_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `aquisicao_equipamentos` ADD FOREIGN KEY (`tipo_entrada_id`) REFERENCES `tipos_entrada` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`tipo_fornecedor_id`) REFERENCES `tipos_fornecedor` (`id`);

ALTER TABLE `garantias_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`tipo_contrato_id`) REFERENCES `tipos_contrato` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`periodicidade_id`) REFERENCES `periodicidades` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);

ALTER TABLE `mensagens_contacto` ADD FOREIGN KEY (`lido_por`) REFERENCES `utilizadores` (`id`);
