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

CREATE TABLE `moradas` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `tipos_alteracao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `designacao` varchar(255) UNIQUE NOT NULL,
  `ordem` int NOT NULL DEFAULT 0
);

CREATE TABLE `utilizadores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varbinary(255) UNIQUE NOT NULL COMMENT 'Encriptado com AES_ENCRYPT (ver MYSQL_AES_KEY em config.php)',
  `password_hash` varchar(255) NOT NULL,
  `perfil_id` int NOT NULL,
  `ativo` boolean DEFAULT true,
  `last_login` datetime,
  `token_reset` varchar(255),
  `token_expira` datetime,
  `token_remember` varchar(255),
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `localizacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `edificio` varchar(255) NOT NULL,
  `piso` varchar(255) NOT NULL,
  `servico` varchar(255) NOT NULL,
  `sala` varchar(255) NOT NULL,
  `observacoes` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `nome_empresa` varchar(255) NOT NULL,
  `nif` varchar(255) UNIQUE NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `morada_id` int NOT NULL,
  `website` varchar(255),
  `pessoa_contacto` varchar(255) NOT NULL,
  `telefone_pessoa_contacto` varchar(255) UNIQUE NOT NULL,
  `tipo_id` int NOT NULL,
  `observacoes` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `documentacao_fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `fornecedor_id` int NOT NULL,
  `tipo_documento_id` int NOT NULL,
  `nome_documento` varchar(255) NOT NULL,
  `data_documento` date NOT NULL,
  `validade_documento` date,
  `ficheiro_documento` varchar(255),
  `nome_original_ficheiro` varchar(255)
);

CREATE TABLE `equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE NOT NULL,
  `designacao` varchar(255) NOT NULL,
  `categoria_id` int NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `numero_serie` varchar(255) NOT NULL,
  `fabricante` varchar(255) NOT NULL,
  `ano_fabrico` int,
  `estado_id` int NOT NULL,
  `criticidade_id` int NOT NULL,
  `observacoes` text,
  `localizacao_id` int NOT NULL,
  `observacoes_localizacao` text,
  `ativo` boolean DEFAULT true,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `documentacao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `tipo_documento_id` int NOT NULL,
  `nome_documento` varchar(255) NOT NULL,
  `data_documento` date NOT NULL,
  `validade_documento` date NOT NULL,
  `ficheiro_documento` varchar(255),
  `nome_original_ficheiro` varchar(255)
);

CREATE TABLE `acessorios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `quantidade` int NOT NULL DEFAULT 1,
  `unidade_id` int NOT NULL,
  `estado_id` int NOT NULL,
  `observacoes` text
);

CREATE TABLE `consumiveis` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `quantidade` int NOT NULL DEFAULT 1,
  `unidade_id` int NOT NULL,
  `estado_id` int,
  `observacoes` text
);

CREATE TABLE `aquisicao_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int UNIQUE NOT NULL,
  `data_aquisicao` date NOT NULL,
  `custo_aquisicao` decimal(10,2) NOT NULL,
  `tipo_entrada_id` int NOT NULL,
  `observacoes` text,
  `created_at` datetime DEFAULT (CURRENT_TIMESTAMP),
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `equipamento_fornecedor` (
  `equipamento_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `morada_id` int NOT NULL,
  `pessoa_contacto` varchar(255) NOT NULL,
  `telefone_pessoa_contacto` varchar(255) NOT NULL,
  `observacoes` text,
  PRIMARY KEY (`equipamento_id`, `fornecedor_id`)
);

CREATE TABLE `garantias_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int UNIQUE NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `observacoes` text
);

CREATE TABLE `contratos_manutencao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int UNIQUE NOT NULL,
  `tipo_contrato_id` int NOT NULL,
  `entidade_responsavel` varchar(255) NOT NULL,
  `periodicidade_id` int NOT NULL,
  `observacoes` text
);

CREATE TABLE `historico_equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `utilizador_id` int,
  `tipo_alteracao_id` int NOT NULL,
  `descricao` text,
  `dados_anteriores` json,
  `dados_novos` json,
  `data_alteracao` datetime NOT NULL DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `conteudos_publicos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_campo` varchar(255) UNIQUE NOT NULL,
  `conteudo_campo` text NOT NULL,
  `updated_at` datetime DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `mensagens_contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT (CURRENT_TIMESTAMP),
  `lido` boolean DEFAULT false,
  `lido_em` datetime,
  `lido_por` int
);

CREATE UNIQUE INDEX `equipamentos_index_0` ON `equipamentos` (`numero_serie`, `fabricante`, `modelo`);

ALTER TABLE `estados_equipamento` COMMENT = 'Valores: Ativo, Em manutenção, Em calibração, Inativo, Em quarentena, Abatido';

ALTER TABLE `criticidades` COMMENT = 'Valores: Baixa, Média, Alta, Suporte de vida';

ALTER TABLE `categorias` COMMENT = 'Valores: Monitorização, Suporte de vida, Terapia, Diagnóstico, Laboratório, Esterilização, Reabilitação';

ALTER TABLE `tipos_fornecedor` COMMENT = 'Valores: Fabricante, Distribuidor ou Fornecedor comercial, Empresa de assistência técnica, Fornecedor de consumíveis ou acessórios';

ALTER TABLE `tipos_entrada` COMMENT = 'Valores: Compra, Doação, Aluguer, Empréstimo';

ALTER TABLE `separadores_documentacao` COMMENT = 'Grupos de documentação: Identificação, Aquisição, Garantia, Contrato';

ALTER TABLE `tipos_documento_equipamento` COMMENT = 'Cada tipo pertence a um separador. Ex: Manual de Serviço → Identificação; Fatura → Aquisição';

ALTER TABLE `tipos_documento_fornecedor` COMMENT = 'Valores: Certificado ISO, Licença de distribuição, Certificado de acreditação técnica, Declaração de autorização de representação, Contrato geral de prestação de serviços, Alvará ou licença de atividade';

ALTER TABLE `perfis_utilizador` COMMENT = 'Valores: Administrador, Técnico, Profissional de Saúde';

ALTER TABLE `tipos_contrato` COMMENT = 'Valores: Manutenção preventiva, Manutenção corretiva, Manutenção preventiva e corretiva';

ALTER TABLE `periodicidades` COMMENT = 'Valores: Mensal, Trimestral, Semestral, Anual, Não aplicável';

ALTER TABLE `unidades` COMMENT = 'Valores: unid, cx, pack, par, rolo, frasco, saco, kit, L, mL, m, cm';

ALTER TABLE `estados_acessorio` COMMENT = 'Valores: Novo, Em uso, Danificado, Em falta, Abatido';

ALTER TABLE `moradas` COMMENT = 'Distritos e regiões de Portugal. Ex: Lisboa, Porto, Aveiro, Região Autónoma da Madeira';

ALTER TABLE `tipos_alteracao` COMMENT = 'Preenchido automaticamente pelo sistema. Valores: Criação, Edição, Eliminação';

ALTER TABLE `equipamentos` COMMENT = 'O índice único (numero_serie, fabricante, modelo) garante que o mesmo número de série não é duplicado para o mesmo fabricante e modelo';

ALTER TABLE `documentacao_equipamentos` COMMENT = 'separador_id removido: redundante — tipos_documento_equipamento já tem separador_id, o que tornaria separador_id aqui uma dependência transitiva (viola 3NF)';

ALTER TABLE `aquisicao_equipamentos` COMMENT = 'Relação 1-para-1 com equipamentos (UNIQUE em equipamento_id). Moeda removida: EUR implícito no contexto PT';

ALTER TABLE `equipamento_fornecedor` COMMENT = 'Tabela de associação N:N entre equipamentos e fornecedores. morada_id, pessoa_contacto e telefone_pessoa_contacto são atributos da relação — podem variar consoante o equipamento. tipo_id não consta aqui porque o tipo é uma característica da empresa fornecedora, não da relação com o equipamento';

ALTER TABLE `garantias_equipamentos` COMMENT = 'Relação 1-para-1 com equipamentos. Ausência de garantia representada por data_inicio e data_fim a NULL';

ALTER TABLE `contratos_manutencao` COMMENT = 'Relação 1-para-1 com equipamentos. Ausência de contrato representada por tipo_contrato_id a NULL';

ALTER TABLE `historico_equipamentos` COMMENT = 'Registo automático de auditoria. tipo_alteracao_id substitui tipo_alteracao varchar — valor controlado por lookup evita inconsistências (3NF). dados_anteriores e dados_novos em JSON permitem registar qualquer alteração sem alterar o schema';

ALTER TABLE `conteudos_publicos` COMMENT = 'Armazena os textos editáveis da área pública (home, sobre, funcionalidades, contactos, rodapé). nome_campo identifica univocamente cada campo editável';

ALTER TABLE `tipos_documento_equipamento` ADD FOREIGN KEY (`separador_id`) REFERENCES `separadores_documentacao` (`id`);

ALTER TABLE `utilizadores` ADD FOREIGN KEY (`perfil_id`) REFERENCES `perfis_utilizador` (`id`);

ALTER TABLE `fornecedores` ADD FOREIGN KEY (`morada_id`) REFERENCES `moradas` (`id`);

ALTER TABLE `fornecedores` ADD FOREIGN KEY (`tipo_id`) REFERENCES `tipos_fornecedor` (`id`);

ALTER TABLE `documentacao_fornecedores` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `documentacao_fornecedores` ADD FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documento_fornecedor` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados_equipamento` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`criticidade_id`) REFERENCES `criticidades` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`localizacao_id`) REFERENCES `localizacoes` (`id`);

ALTER TABLE `documentacao_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

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

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`morada_id`) REFERENCES `moradas` (`id`);

ALTER TABLE `garantias_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`tipo_contrato_id`) REFERENCES `tipos_contrato` (`id`);

ALTER TABLE `contratos_manutencao` ADD FOREIGN KEY (`periodicidade_id`) REFERENCES `periodicidades` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`);

ALTER TABLE `historico_equipamentos` ADD FOREIGN KEY (`tipo_alteracao_id`) REFERENCES `tipos_alteracao` (`id`);

ALTER TABLE `mensagens_contacto` ADD FOREIGN KEY (`lido_por`) REFERENCES `utilizadores` (`id`);
