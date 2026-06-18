SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- ESTADOS EQUIPAMENTO
-- ============================================================

INSERT IGNORE INTO estados_equipamento (designacao, ordem) VALUES
('Ativo', 1),
('Em manutenção', 2),
('Em calibração', 3),
('Em quarentena', 4),
('Inativo', 5),
('Abatido', 6);

-- ============================================================
-- CRITICIDADES
-- ============================================================

INSERT INTO criticidades (designacao, ordem) VALUES
('Baixa', 1),
('Média', 2),
('Alta', 3),
('Suporte de vida', 4);

-- ============================================================
-- CATEGORIAS
-- ============================================================

INSERT INTO categorias (designacao, ordem) VALUES
('Monitorização', 1),
('Suporte de vida', 2),
('Diagnóstico', 3),
('Terapia', 4),
('Laboratório', 5),
('Esterilização', 6),
('Reabilitação', 7);

-- ============================================================
-- TIPOS FORNECEDOR
-- ============================================================

INSERT INTO tipos_fornecedor (designacao, ordem) VALUES
('Fabricante', 1),
('Distribuidor ou Fornecedor comercial', 2),
('Empresa de assistência técnica', 3),
('Fornecedor de consumíveis ou acessórios', 4);

-- ============================================================
-- TIPOS ENTRADA
-- ============================================================

INSERT INTO tipos_entrada (designacao, ordem) VALUES
('Compra', 1),
('Aluguer', 2),
('Doação', 3),
('Empréstimo', 4);

-- ============================================================
-- SEPARADORES DOCUMENTAÇÃO
-- ============================================================

INSERT INTO separadores_documentacao (designacao, ordem) VALUES
('Identificação', 1),
('Aquisição',     2),
('Garantia',      3),
('Contrato',      4);

-- ============================================================
-- TIPOS DOCUMENTO EQUIPAMENTO
-- ============================================================

INSERT INTO tipos_documento_equipamento (separador_id, designacao, ordem) VALUES
((SELECT id FROM separadores_documentacao WHERE designacao='Identificação'), 'Manual de Serviço',          1),
((SELECT id FROM separadores_documentacao WHERE designacao='Identificação'), 'Manual de Utilização',    2),
((SELECT id FROM separadores_documentacao WHERE designacao='Identificação'), 'Declaração de Conformidade', 3),
((SELECT id FROM separadores_documentacao WHERE designacao='Aquisição'),     'Fatura',                  4),
((SELECT id FROM separadores_documentacao WHERE designacao='Aquisição'),     'Contrato de Aquisição',   5),
((SELECT id FROM separadores_documentacao WHERE designacao='Aquisição'),     'Contrato de Aluguer',     6),
((SELECT id FROM separadores_documentacao WHERE designacao='Aquisição'),     'Contrato de Empréstimo',  7),
((SELECT id FROM separadores_documentacao WHERE designacao='Aquisição'),     'Termo de Doação',         8),
((SELECT id FROM separadores_documentacao WHERE designacao='Garantia'),      'Certificado de Garantia', 9),
((SELECT id FROM separadores_documentacao WHERE designacao='Contrato'),      'Contrato de Manutenção',  10),
((SELECT id FROM separadores_documentacao WHERE designacao='Contrato'),      'Relatório de Manutenção', 11),
((SELECT id FROM separadores_documentacao WHERE designacao='Contrato'),    'Certificado de Calibração', 12),
((SELECT id FROM separadores_documentacao WHERE designacao='Contrato'),    'Relatório de Calibração', 13);

-- ============================================================
-- TIPOS DOCUMENTO FORNECEDOR
-- ============================================================

INSERT INTO tipos_documento_fornecedor (designacao, ordem) VALUES
('Certificado ISO', 1),
('Licença de distribuição', 2),
('Certificado de acreditação técnica', 3),
('Declaração de autorização de representação', 4),
('Contrato geral de prestação de serviços', 5),
('Alvará ou licença de atividade', 6);

-- ============================================================
-- PERFIS UTILIZADOR
-- ============================================================

INSERT INTO perfis_utilizador (designacao, ordem) VALUES
('Administrador', 1),
('Técnico', 2),
('Profissional de Saúde', 3);

-- ============================================================
-- TIPOS CONTRATO
-- ============================================================

INSERT INTO tipos_contrato (designacao, ordem) VALUES
('Manutenção preventiva', 1),
('Manutenção corretiva', 2),
('Manutenção preventiva e corretiva', 3);

-- ============================================================
-- PERIODICIDADES
-- ============================================================

INSERT INTO periodicidades (designacao, ordem) VALUES
('Mensal', 1),
('Trimestral', 2),
('Semestral', 3),
('Anual', 4);

-- ============================================================
-- UNIDADES
-- ============================================================

INSERT IGNORE INTO unidades (designacao, ordem) VALUES
('unid',   1),
('cx',     2),
('kit',    3),
('par',    4),
('rolo',   5),
('frasco', 6),
('saco',   7),
('L',      8),
('mL',     9),
('m',      10),
('cm',     11),
('pack',     12);

-- ============================================================
-- ESTADOS ACESSÓRIO
-- ============================================================

INSERT IGNORE INTO estados_acessorio (designacao, valor, ordem) VALUES
('Novo', 'novo', 1),
('Em uso', 'em-uso', 2),
('Danificado', 'danificado', 3),
('Em falta', 'em-falta', 4),
('Abatido', 'abatido', 5);

-- ============================================================
-- MORADAS
-- ============================================================

INSERT INTO moradas (designacao, ordem) VALUES
('Aveiro, Portugal', 1),
('Beja, Portugal', 2),
('Braga, Portugal', 3),
('Bragança, Portugal', 4),
('Castelo Branco, Portugal', 5),
('Coimbra, Portugal', 6),
('Évora, Portugal', 7),
('Faro, Portugal', 8),
('Guarda, Portugal', 9),
('Leiria, Portugal', 10),
('Lisboa, Portugal', 11),
('Portalegre, Portugal', 12),
('Porto, Portugal', 13),
('Santarém, Portugal', 14),
('Setúbal, Portugal', 15),
('Viana do Castelo, Portugal', 16),
('Vila Real, Portugal', 17),
('Viseu, Portugal', 18),
('Região Autónoma dos Açores, Portugal', 19),
('Região Autónoma da Madeira, Portugal', 20);

-- ============================================================
-- TIPOS DE ALTERAÇÃO
-- ============================================================

INSERT INTO tipos_alteracao (designacao, ordem) VALUES
('Criação', 1),
('Edição', 2),
('Eliminação', 3),
('Reativação', 4);

-- ============================================================
-- UTILIZADORES
-- ============================================================

INSERT INTO utilizadores (nome, email, password_hash, perfil_id, ativo) VALUES
(
    'Administrador Principal',
    AES_ENCRYPT('admin@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
    '$2b$10$Izb1ii2RIUgUYpcTXndLqOZGP/puiQP.4VO.MKKti5jEOgy4NWynG',
    (SELECT id FROM perfis_utilizador WHERE designacao='Administrador'),
    TRUE
),
(
    'Administrador Secundário',
    AES_ENCRYPT('admin2@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Administrador'),
    TRUE
),
(
    'Administrador Terciário',
    AES_ENCRYPT('admin3@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Administrador'),
    TRUE
),
(
    'Ana Silva',
    AES_ENCRYPT('ana.silva@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
    '$2b$10$0bJ4VuAZoTxY4HKmzpqSNu6NRAG3B3Flaq/4anxUQeVuafSI/C28G',
    (SELECT id FROM perfis_utilizador WHERE designacao='Técnico'),
    TRUE
),
(
    'João Costa',
    AES_ENCRYPT('joao.costa@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Técnico'),
    TRUE
),
(
    'Maria Santos',
    AES_ENCRYPT('maria.santos@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Técnico'),
    TRUE
),
(
    'Rui Ferreira',
    AES_ENCRYPT('rui.ferreira@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
    '$2b$10$atTWxXwbjNrXbvuw..G3fe2IWR8cNA/Gz/NnPjEx2BEcjfTDn20Z.',
    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
),
(
    'Catarina Lopes',
    AES_ENCRYPT('catarina.lopes@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
),
(
    'Pedro Marques',
    AES_ENCRYPT('pedro.marques@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
),
(
    'Sofia Rodrigues',
    AES_ENCRYPT('sofia.rodrigues@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
),
(
    'Miguel Oliveira',
    AES_ENCRYPT('miguel.oliveira@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
),
(
    'Inês Carvalho',
    AES_ENCRYPT('ines.carvalho@medivault.pt', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'),
'$2b$10$kE02SpMgK3VEueUN14yLv.ml95gdAdJap8KTBjhkVqgTlox88IbGK',    (SELECT id FROM perfis_utilizador WHERE designacao='Profissional de Saúde'),
    TRUE
);

-- ============================================================
-- LOCALIZAÇÕES (12)
-- ============================================================

INSERT INTO localizacoes (codigo, edificio, piso, servico, sala, observacoes, ativo) VALUES
('LOC001','Edifício Principal','Piso 2','Unidade de Cuidados Intensivos','Sala 2.10','Área destinada à monitorização contínua de doentes críticos.',TRUE),
('LOC002','Edifício Principal','Piso 2','Unidade de Cuidados Intensivos','Sala 2.11','Localização associada a equipamentos de suporte ventilatório.',TRUE),
('LOC003','Edifício B','Piso 0','Serviço de Medicina','Gabinete 0.04','Localização utilizada para equipamentos de apoio à terapêutica intravenosa.',TRUE),
('LOC004','Edifício Principal','Piso 1','Urgência','Sala 1.02','Localização destinada a equipamentos de resposta rápida.',TRUE),
('LOC005','Edifício Principal','Piso 1','Radiologia','Sala RX-03','Área destinada a equipamentos de diagnóstico por imagem.',TRUE),
('LOC006','Edifício Cirúrgico','Piso 0','Bloco Operatório Central','Sala BO-02','Sala equipada para intervenções cirúrgicas programadas.',TRUE),
('LOC007','Edifício Principal','Piso 3','Cardiologia','Sala 3.08','Área dedicada a exames e monitorização cardíaca.',TRUE),
('LOC008','Edifício Técnico','Piso 0','Central de Esterilização e Desinfeção','Sala EST-01','Zona destinada à esterilização de material clínico.',TRUE),
('LOC009','Edifício Principal','Piso 2','Pediatria','Sala PED-04','Área dedicada ao acompanhamento e tratamento pediátrico.',TRUE),
('LOC010','Edifício Principal','Piso 3','Neurologia','Sala NRL-02','Serviço especializado em doenças neurológicas.',TRUE),
('LOC011','Edifício Técnico','Piso 1','Patologia Clínica','Sala LAB-05','Área destinada à realização de análises clínicas e laboratoriais.',TRUE),
('LOC012','Edifício Principal','Piso 4','Medicina Física e Reabilitação','Sala REAB-01','Espaço destinado a equipamentos de fisioterapia e reabilitação.',TRUE);

-- ============================================================
-- FORNECEDORES (9)
-- ============================================================

INSERT INTO fornecedores (codigo, nome_empresa, nif, telefone, email, morada_id, website, pessoa_contacto, telefone_pessoa_contacto, tipo_id, observacoes, ativo) VALUES
('FOR001','Philips Healthcare','501234567','+351 930 193 126','contacto@philipshealthcare.pt',(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'www.philips.com','Catarina Silva','+351 910 000 000',(SELECT id FROM tipos_fornecedor WHERE designacao='Fabricante'),'Fornecedor associado a equipamentos de monitorização.',TRUE),
('FOR002','Dräger','502345678','+351 930 327 344','contacto@draegermedical.pt',(SELECT id FROM moradas WHERE designacao='Porto, Portugal'),'www.draeger.com','Miguel Santos','+351 920 000 000',(SELECT id FROM tipos_fornecedor WHERE designacao='Fabricante'),'Fabricante associado a equipamentos de suporte ventilatório.',TRUE),
('FOR003','MedSupply Portugal','503456789','+351 930 248 308','contacto@medsupply.pt',(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'www.medsupply.com','Carla Ferreira','+351 930 000 000',(SELECT id FROM tipos_fornecedor WHERE designacao='Distribuidor ou Fornecedor comercial'),'Distribuidor comercial de equipamentos e consumíveis.',TRUE),
('FOR004','TecnoMed Assistência','504567890','+351 930 656 375','contacto@tecnomed.pt',(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'www.tecnomed.com','João Almeida','+351 940 000 000',(SELECT id FROM tipos_fornecedor WHERE designacao='Empresa de assistência técnica'),'Empresa responsável por manutenção preventiva e corretiva.',TRUE),
('FOR005','Siemens Healthineers','505678901','+351 930 111 222','contacto@siemenshealthineers.pt',(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'www.siemens-healthineers.com','Ricardo Moreira','+351 910 111 222',(SELECT id FROM tipos_fornecedor WHERE designacao='Fabricante'),'Fornecedor de equipamentos de diagnóstico e imagiologia.',TRUE),
('FOR006','GE HealthCare','506789012','+351 930 222 333','contacto@gehealthcare.pt',(SELECT id FROM moradas WHERE designacao='Região Autónoma da Madeira, Portugal'),'www.gehealthcare.com','Ana Ribeiro','+351 910 222 333',(SELECT id FROM tipos_fornecedor WHERE designacao='Fabricante'),'Fornecedor de equipamentos de monitorização e diagnóstico.',TRUE),
('FOR007','B. Braun Medical','507890123','+351 930 333 444','contacto@bbraun.pt',(SELECT id FROM moradas WHERE designacao='Faro, Portugal'),'www.bbraun.pt','Pedro Costa','+351 910 333 444',(SELECT id FROM tipos_fornecedor WHERE designacao='Fornecedor de consumíveis ou acessórios'),'Fornecedor de consumíveis hospitalares e acessórios.',TRUE),
('FOR008','Medtronic Portugal','508901234','+351 930 444 555','contacto@medtronic.pt',(SELECT id FROM moradas WHERE designacao='Braga, Portugal'),'www.medtronic.com','Sofia Martins','+351 910 444 555',(SELECT id FROM tipos_fornecedor WHERE designacao='Distribuidor ou Fornecedor comercial'),'Distribuidor de equipamentos médicos e dispositivos implantáveis.',TRUE),
('FOR009','Roche Diagnostics','509012345','+351 930 555 666','contacto@roche.pt',(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'www.roche.pt','Tiago Oliveira','+351 910 555 666',(SELECT id FROM tipos_fornecedor WHERE designacao='Fornecedor de consumíveis ou acessórios'),'Fornecedor de reagentes e consumíveis laboratoriais.',TRUE);

-- ============================================================
-- DOCUMENTAÇÃO DOS FORNECEDORES
-- ============================================================

INSERT INTO documentacao_fornecedores (fornecedor_id, tipo_documento_id, nome_documento, data_documento, validade_documento, ficheiro_documento, nome_original_ficheiro) VALUES
((SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Certificado ISO'),'Certificado ISO 13485 Philips Healthcare','2024-01-15','2027-01-15','certificado_iso_FOR001.pdf','certificado_iso_FOR001.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR002'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Certificado ISO'),'Certificado ISO 13485 Dräger','2023-03-10','2026-03-10','certificado_iso_FOR002.pdf','certificado_iso_FOR002.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Licença de distribuição'),'Licença de Distribuição de Dispositivos Médicos MedSupply','2023-06-01','2026-06-01','licenca_distribuicao_FOR003.pdf','licenca_distribuicao_FOR003.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Certificado de acreditação técnica'),'Certificado de Acreditação Técnica TecnoMed','2024-02-20','2027-02-20','certificado_acreditacao_FOR004.pdf','certificado_acreditacao_FOR004.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR005'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Certificado ISO'),'Certificado ISO 13485 Siemens Healthineers','2024-04-05','2027-04-05','certificado_iso_FOR005.pdf','certificado_iso_FOR005.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR006'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Declaração de autorização de representação'),'Declaração de Autorização de Representação GE HealthCare','2023-09-12','2026-09-12','declaracao_representacao_FOR006.pdf','declaracao_representacao_FOR006.pdf'),
((SELECT id FROM fornecedores WHERE codigo='FOR009'),(SELECT id FROM tipos_documento_fornecedor WHERE designacao='Certificado ISO'),'Certificado ISO 9001 Roche Diagnostics','2024-05-22','2027-05-22','certificado_iso_FOR009.pdf','certificado_iso_FOR009.pdf');
-- FOR007 e FOR008: sem documentação (temDocFornecedor = "nao")

-- ============================================================
-- EQUIPAMENTOS (30)
-- ============================================================

INSERT INTO equipamentos (codigo, designacao, categoria_id, marca, modelo, numero_serie, fabricante, ano_fabrico, estado_id, criticidade_id, observacoes, localizacao_id, observacoes_localizacao, ativo) VALUES
('EQ001','Monitor multiparamétrico de sinais vitais',(SELECT id FROM categorias WHERE designacao='Monitorização'),'Philips','IntelliVue MX450','PH-MX450-2021-001','Philips Healthcare',2024,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento utilizado para monitorização contínua de sinais vitais em doentes críticos.',(SELECT id FROM localizacoes WHERE codigo='LOC001'),'',TRUE),
('EQ002','Ventilador pulmonar',(SELECT id FROM categorias WHERE designacao='Suporte de vida'),'Dräger','Evita V600','DR-EV600-2020-014','Dräger Medical',2020,(SELECT id FROM estados_equipamento WHERE designacao='Em manutenção'),(SELECT id FROM criticidades WHERE designacao='Suporte de vida'),'Equipamento em manutenção preventiva programada. Utilizado em UCI para suporte ventilatório invasivo.',(SELECT id FROM localizacoes WHERE codigo='LOC002'),'Equipamento afeto permanentemente à sala 2.11 da UCI.',TRUE),
('EQ003','Bomba de infusão',(SELECT id FROM categorias WHERE designacao='Terapia'),'B. Braun','Infusomat Space','BB-INF-2019-033','B. Braun Medical',2019,(SELECT id FROM estados_equipamento WHERE designacao='Em calibração'),(SELECT id FROM criticidades WHERE designacao='Média'),'Utilizada para administração controlada de terapêutica intravenosa. Em processo de calibração anual.',(SELECT id FROM localizacoes WHERE codigo='LOC003'),'',TRUE),
('EQ004','Desfibrilhador',(SELECT id FROM categorias WHERE designacao='Suporte de vida'),'Zoll','R Series','ZL-RS-2022-007','Zoll Medical',2022,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Suporte de vida'),'Equipamento essencial para resposta rápida em situações de paragem cardiorrespiratória.',(SELECT id FROM localizacoes WHERE codigo='LOC004'),'Equipamento de acesso imediato na sala de emergência da Urgência.',TRUE),
('EQ005','Ecógrafo',(SELECT id FROM categorias WHERE designacao='Diagnóstico'),'Siemens','Acuson Redwood','SM-RDW-2023-021','Siemens Healthineers',2023,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento utilizado para realização de exames ecográficos em diferentes especialidades clínicas.',(SELECT id FROM localizacoes WHERE codigo='LOC005'),'Equipamento instalado na sala de imagiologia.',TRUE),
('EQ006','Analisador Bioquímico',(SELECT id FROM categorias WHERE designacao='Laboratório'),'Roche','Cobas Pure','RC-CBP-2024-014','Roche Diagnostics',2024,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento destinado à realização de análises bioquímicas laboratoriais.',(SELECT id FROM localizacoes WHERE codigo='LOC011'),'Instalado na área principal do laboratório clínico.',TRUE),
('EQ007','Autoclave',(SELECT id FROM categorias WHERE designacao='Esterilização'),'Getinge','HS66','GT-HS66-2021-009','Getinge',2021,(SELECT id FROM estados_equipamento WHERE designacao='Em manutenção'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento utilizado para esterilização de instrumentos cirúrgicos e material clínico.',(SELECT id FROM localizacoes WHERE codigo='LOC008'),'Equipamento instalado na Central de Esterilização.',TRUE),
('EQ008','Ultrassom Terapêutico',(SELECT id FROM categorias WHERE designacao='Reabilitação'),'BTL','BTL-5820S','BTL-US-2023-011','BTL Industries',2023,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento utilizado em tratamentos de fisioterapia e reabilitação músculo-esquelética.',(SELECT id FROM localizacoes WHERE codigo='LOC012'),'Equipamento utilizado no serviço de Medicina Física e Reabilitação.',TRUE),
('EQ009','Monitor Multiparamétrico',(SELECT id FROM categorias WHERE designacao='Monitorização'),'GE HealthCare','CARESCAPE B450','GE-B450-2022-019','GE HealthCare',2022,(SELECT id FROM estados_equipamento WHERE designacao='Em calibração'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento temporariamente retirado de serviço para calibração anual.',(SELECT id FROM localizacoes WHERE codigo='LOC001'),'Monitor instalado na Unidade de Cuidados Intensivos.',TRUE),
('EQ010','Bomba Infusora',(SELECT id FROM categorias WHERE designacao='Terapia'),'B. Braun','Perfusor Space','BB-PS-2021-028','B. Braun Medical',2021,(SELECT id FROM estados_equipamento WHERE designacao='Em quarentena'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento temporariamente em quarentena para avaliação técnica.',(SELECT id FROM localizacoes WHERE codigo='LOC003'),'Equipamento afeto ao Serviço de Medicina.',TRUE),
('EQ011','Eletrocardiógrafo',(SELECT id FROM categorias WHERE designacao='Diagnóstico'),'Philips','PageWriter TC35','PH-TC35-2020-017','Philips Healthcare',2020,(SELECT id FROM estados_equipamento WHERE designacao='Inativo'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento atualmente sem utilização devido à aquisição de modelos mais recentes.',(SELECT id FROM localizacoes WHERE codigo='LOC007'),'Equipamento armazenado na Cardiologia como reserva.',TRUE),
('EQ012','Ventilador Mecânico',(SELECT id FROM categorias WHERE designacao='Suporte de vida'),'Dräger','Evita V600','DR-EV600-2023-012','Dräger',2023,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Suporte de vida'),'Ventilador mecânico utilizado para suporte respiratório invasivo e não invasivo em doentes críticos.',(SELECT id FROM localizacoes WHERE codigo='LOC002'),'Equipamento instalado na Unidade de Cuidados Intensivos.',TRUE),
('EQ013','Centrífuga Laboratorial',(SELECT id FROM categorias WHERE designacao='Laboratório'),'Eppendorf','5702','EP-5702-2016-013','Eppendorf',2016,(SELECT id FROM estados_equipamento WHERE designacao='Abatido'),(SELECT id FROM criticidades WHERE designacao='Baixa'),'Equipamento abatido devido ao desgaste e à aquisição de equipamento mais recente.',(SELECT id FROM localizacoes WHERE codigo='LOC011'),'Equipamento armazenado em área de equipamentos abatidos.',TRUE),
('EQ014','Monitor de Sinais Vitais',(SELECT id FROM categorias WHERE designacao='Monitorização'),'Philips','IntelliVue MX550','PH-MX550-2022-014','Philips Healthcare',2022,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Monitor utilizado para monitorização contínua de parâmetros vitais.',(SELECT id FROM localizacoes WHERE codigo='LOC009'),'Equipamento afeto ao serviço de Pediatria.',TRUE),
('EQ015','Passadeira de Reabilitação',(SELECT id FROM categorias WHERE designacao='Reabilitação'),'Biodex','Gait Trainer 3','BD-GT3-2022-015','Biodex Medical Systems',2022,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Baixa'),'Equipamento utilizado em programas de reeducação da marcha e fisioterapia.',(SELECT id FROM localizacoes WHERE codigo='LOC012'),'Equipamento instalado na área principal de fisioterapia.',TRUE),
('EQ016','Ecógrafo',(SELECT id FROM categorias WHERE designacao='Diagnóstico'),'Siemens','ACUSON Redwood','SM-RW-2024-016','Siemens Healthineers',2024,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Ecógrafo utilizado para exames de diagnóstico em diversas especialidades clínicas.',(SELECT id FROM localizacoes WHERE codigo='LOC005'),'Equipamento afeto ao serviço de Radiologia.',TRUE),
('EQ017','Analisador Hematológico',(SELECT id FROM categorias WHERE designacao='Laboratório'),'Sysmex','XN-550','SY-XN550-2024-017','Sysmex Corporation',2024,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento utilizado para análises hematológicas de rotina e urgência.',(SELECT id FROM localizacoes WHERE codigo='LOC011'),'Equipamento instalado no Laboratório Clínico.',TRUE),
('EQ018','Bomba de Seringa',(SELECT id FROM categorias WHERE designacao='Terapia'),'B. Braun','Perfusor Compact Plus','BB-PCP-2023-018','B. Braun Medical',2023,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento utilizado na administração precisa de medicamentos e terapêuticas intravenosas.',(SELECT id FROM localizacoes WHERE codigo='LOC003'),'Equipamento disponível para terapêutica intravenosa.',TRUE),
('EQ019','Termodesinfetadora',(SELECT id FROM categorias WHERE designacao='Esterilização'),'Getinge','WD15 Claro','GT-WD15-2019-019','Getinge',2019,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento destinado à lavagem e desinfeção de instrumentos clínicos.',(SELECT id FROM localizacoes WHERE codigo='LOC008'),'Equipamento instalado na Central de Esterilização.',TRUE),
('EQ020','Incubadora Neonatal',(SELECT id FROM categorias WHERE designacao='Suporte de vida'),'Dräger','Isolette 8000 Plus','DR-ISO-2023-020','Dräger',2023,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Suporte de vida'),'Equipamento utilizado para cuidados intensivos neonatais.',(SELECT id FROM localizacoes WHERE codigo='LOC009'),'Equipamento afeto à área pediátrica e neonatal.',TRUE),
('EQ021','Monitor Multiparamétrico',(SELECT id FROM categorias WHERE designacao='Monitorização'),'GE HealthCare','CARESCAPE B450','GE-B450-2021-021','GE HealthCare',2021,(SELECT id FROM estados_equipamento WHERE designacao='Em manutenção'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento temporariamente indisponível para manutenção corretiva.',(SELECT id FROM localizacoes WHERE codigo='LOC001'),'Equipamento afeto à Unidade de Cuidados Intensivos.',TRUE),
('EQ022','Eletrocardiógrafo',(SELECT id FROM categorias WHERE designacao='Diagnóstico'),'Philips','PageWriter TC35','PH-TC35-2022-022','Philips Healthcare',2022,(SELECT id FROM estados_equipamento WHERE designacao='Em calibração'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento temporariamente indisponível por se encontrar em processo de calibração.',(SELECT id FROM localizacoes WHERE codigo='LOC010'),'Equipamento afeto ao serviço de Cardiologia.',TRUE),
('EQ023','Cicloergómetro de Reabilitação',(SELECT id FROM categorias WHERE designacao='Reabilitação'),'Ergoline','Ergoselect 200','ER-200-2018-023','Ergoline GmbH',2018,(SELECT id FROM estados_equipamento WHERE designacao='Inativo'),(SELECT id FROM criticidades WHERE designacao='Baixa'),'Equipamento temporariamente sem utilização devido à renovação da área de reabilitação.',(SELECT id FROM localizacoes WHERE codigo='LOC012'),'Equipamento armazenado temporariamente durante remodelação da sala.',TRUE),
('EQ024','Bomba Volumétrica',(SELECT id FROM categorias WHERE designacao='Terapia'),'B. Braun','Infusomat Space','BB-INF-2020-024','B. Braun Medical',2020,(SELECT id FROM estados_equipamento WHERE designacao='Em quarentena'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Equipamento temporariamente isolado para avaliação técnica após ocorrência de alarme recorrente.',(SELECT id FROM localizacoes WHERE codigo='LOC003'),'Equipamento removido temporariamente do serviço para avaliação.',TRUE),
('EQ025','Analisador Bioquímico',(SELECT id FROM categorias WHERE designacao='Laboratório'),'Roche','cobas c 311','RC-C311-2024-025','Roche Diagnostics',2024,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Média'),'Equipamento utilizado para análises bioquímicas de rotina.',(SELECT id FROM localizacoes WHERE codigo='LOC011'),'Equipamento instalado no Laboratório Clínico.',TRUE),
('EQ026','Holter Cardíaco',(SELECT id FROM categorias WHERE designacao='Monitorização'),'GE HealthCare','SEER 1000','GE-SEER-2015-026','GE HealthCare',2015,(SELECT id FROM estados_equipamento WHERE designacao='Abatido'),(SELECT id FROM criticidades WHERE designacao='Baixa'),'Equipamento retirado definitivamente de serviço devido à obsolescência tecnológica.',(SELECT id FROM localizacoes WHERE codigo='LOC007'),'Equipamento armazenado em área de equipamentos abatidos.',TRUE),
('EQ027','Ecógrafo Portátil',(SELECT id FROM categorias WHERE designacao='Diagnóstico'),'Philips','Lumify','PH-LUM-2025-027','Philips Healthcare',2025,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Média'),'Ecógrafo portátil utilizado para avaliações rápidas à cabeceira do doente.',(SELECT id FROM localizacoes WHERE codigo='LOC004'),'Equipamento móvel utilizado em vários serviços.',TRUE),
('EQ028','Ventilador de Transporte',(SELECT id FROM categorias WHERE designacao='Suporte de vida'),'Dräger','Oxylog 3000 Plus','DR-OXY-2019-028','Dräger',2019,(SELECT id FROM estados_equipamento WHERE designacao='Inativo'),(SELECT id FROM criticidades WHERE designacao='Suporte de vida'),'Equipamento de reserva atualmente fora de utilização por falta de necessidade operacional.',(SELECT id FROM localizacoes WHERE codigo='LOC006'),'Equipamento armazenado como unidade de reserva.',TRUE),
('EQ029','Passadeira de Reabilitação',(SELECT id FROM categorias WHERE designacao='Reabilitação'),'Biodex','Gait Trainer 3','BD-GT3-2022-029','Biodex Medical Systems',2022,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Baixa'),'Equipamento utilizado em programas de reabilitação motora e treino de marcha.',(SELECT id FROM localizacoes WHERE codigo='LOC012'),'Equipamento utilizado diariamente em sessões de fisioterapia.',TRUE),
('EQ030','Monitor de Sinais Vitais',(SELECT id FROM categorias WHERE designacao='Monitorização'),'Philips','IntelliVue MX550','PH-MX550-2025-030','Philips Healthcare',2025,(SELECT id FROM estados_equipamento WHERE designacao='Ativo'),(SELECT id FROM criticidades WHERE designacao='Alta'),'Monitor multiparamétrico destinado à monitorização contínua de sinais vitais.',(SELECT id FROM localizacoes WHERE codigo='LOC001'),'Equipamento instalado na Unidade de Cuidados Intensivos.',TRUE);

-- ============================================================
-- AQUISIÇÃO DOS EQUIPAMENTOS
-- ============================================================

INSERT INTO aquisicao_equipamentos (equipamento_id, data_aquisicao, custo_aquisicao, tipo_entrada_id, observacoes) VALUES
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'2025-03-12',8500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'2021-09-08',23500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição realizada no âmbito do reforço de meios de suporte ventilatório da UCI.'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'2020-01-21',3200.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'2022-06-15',12400.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para reforço da resposta de emergência na Urgência.'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'2024-04-10',28500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição realizada para reforço da capacidade de diagnóstico por imagem.'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'2024-02-20',36500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento adquirido para modernização do laboratório clínico.'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'2021-05-12',32000.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição realizada para reforço da capacidade de esterilização hospitalar.'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),'2023-02-15',4200.00,(SELECT id FROM tipos_entrada WHERE designacao='Doação'),'Equipamento recebido através de doação para reforço do serviço de reabilitação.'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'2022-09-08',5200.00,(SELECT id FROM tipos_entrada WHERE designacao='Aluguer'),'Equipamento obtido através de contrato de aluguer operacional.'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'2021-07-22',2800.00,(SELECT id FROM tipos_entrada WHERE designacao='Empréstimo'),'Equipamento cedido temporariamente por parceiro institucional.'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'2020-02-10',3900.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para reforço da capacidade diagnóstica do serviço.'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'2023-01-12',36500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para reforço da capacidade da Unidade de Cuidados Intensivos.'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),'2016-04-05',2800.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento adquirido para o laboratório clínico.'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),'2022-06-20',6800.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento adquirido para reforço da monitorização clínica.'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),'2022-10-10',18500.00,(SELECT id FROM tipos_entrada WHERE designacao='Aluguer'),'Equipamento obtido através de contrato de aluguer operacional.'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),'2024-02-20',48500.00,(SELECT id FROM tipos_entrada WHERE designacao='Doação'),'Equipamento recebido através de doação institucional.'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'2024-03-18',29500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição destinada à modernização do laboratório clínico.'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),'2023-07-18',2450.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição destinada ao Serviço de Medicina.'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),'2019-05-20',18500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para a Central de Esterilização.'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),'2023-05-05',28750.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para a unidade neonatal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),'2021-03-25',7200.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição destinada à monitorização contínua de doentes.'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'2022-06-20',4200.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento destinado à realização de eletrocardiogramas.'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),'2018-04-20',6200.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento adquirido para programas de reabilitação cardiovascular.'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),'2020-02-20',3900.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento destinado à administração controlada de terapêutica intravenosa.'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),'2024-08-01',0.00,(SELECT id FROM tipos_entrada WHERE designacao='Empréstimo'),'Equipamento cedido temporariamente ao hospital.'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),'2015-03-20',2800.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Equipamento destinado ao serviço de Cardiologia.'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),'2025-02-01',450.00,(SELECT id FROM tipos_entrada WHERE designacao='Aluguer'),'Equipamento alugado para reforço da capacidade de diagnóstico.'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),'2019-05-10',9800.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para utilização em transporte intra-hospitalar e ambulâncias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),'2022-04-20',18500.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição destinada ao serviço de Medicina Física e Reabilitação.'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'2025-03-01',8450.00,(SELECT id FROM tipos_entrada WHERE designacao='Compra'),'Aquisição para renovação tecnológica da Unidade de Cuidados Intensivos.');

-- ============================================================
-- GARANTIAS DOS EQUIPAMENTOS
-- ============================================================

INSERT INTO garantias_equipamentos (equipamento_id, data_inicio, data_fim, observacoes) VALUES
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'2025-03-12','2028-03-12','Garantia comercial do fabricante.'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'2021-09-08','2024-09-08','Garantia de 3 anos do fabricante. Expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'2020-01-21','2023-01-21','Garantia expirada. Sem renovação.'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'2022-06-15','2025-06-15','Garantia comercial de 3 anos. Expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'2024-04-10','2027-04-10','Garantia comercial de 3 anos fornecida pelo fabricante.'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'2024-02-20','2027-02-20','Garantia comercial de 3 anos.'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'2021-05-12','2024-05-12','Garantia comercial expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),'2023-02-15','2026-02-15','Garantia de 3 anos fornecida pelo distribuidor.'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'2022-09-08','2025-09-08','Garantia associada ao contrato de aluguer.'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'2021-07-22','2024-07-22','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'2020-02-10','2023-02-10','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'2023-01-12','2026-01-12','Garantia comercial de 3 anos.'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),'2016-04-05','2019-04-05','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),'2023-06-20','2026-06-25','Garantia a expirar nos próximos dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),'2022-10-10','2026-06-28','Garantia a expirar nos próximos 30 dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),'2024-02-20','2028-02-20','Garantia válida.'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'2024-03-18','2027-03-18','Garantia válida.'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),'2023-07-18','2026-06-30','Garantia a expirar nos próximos 30 dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),'2019-05-20','2022-05-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),'2023-05-05','2026-07-05','Garantia a expirar nos próximos 30 dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),'2021-03-25','2024-03-25','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'2022-06-20','2025-06-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),'2018-04-20','2021-04-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),'2020-02-20','2023-02-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),'2024-08-01','2026-07-12','Garantia a expirar nos próximos 30 dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),'2015-03-20','2018-03-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),'2025-02-01','2028-02-01','Garantia ativa.'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),'2019-05-10','2022-05-10','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),'2022-04-20','2025-04-20','Garantia expirada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'2025-03-01','2029-03-01','Garantia válida.');

-- ============================================================
-- CONTRATOS DE MANUTENÇÃO
-- ============================================================

INSERT INTO contratos_manutencao (equipamento_id, tipo_contrato_id, entidade_responsavel, periodicidade_id, observacoes) VALUES
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Philips Healthcare',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Garantia ativa e contrato de manutenção preventiva associado.'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva e corretiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Contrato de manutenção semestral ativo com TecnoMed Assistência.'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção corretiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Contrato de manutenção corretiva anual ativo com TecnoMed Assistência.'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Contrato de manutenção preventiva anual ativo com a TecnoMed Assistência.'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Contrato de manutenção preventiva semestral ativo.'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Trimestral'),'Equipamento temporariamente em manutenção preventiva programada.'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'GE HealthCare',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento em processo de calibração periódica obrigatória.'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção corretiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Mensal'),'Equipamento em avaliação técnica antes de regressar ao serviço.'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Contrato de manutenção preventiva semestral ativo.'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Philips Healthcare',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento com garantia prestes a expirar.'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Biodex Medical Systems',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento com calibração a expirar nos próximos 30 dias.'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'MedSupply Portugal',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Contrato de manutenção preventiva semestral ativo.'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'B. Braun Medical',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Contrato de manutenção preventiva ativo.'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Contrato de manutenção preventiva ativo.'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Dräger',(SELECT id FROM periodicidades WHERE designacao='Semestral'),'Equipamento crítico da unidade neonatal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção corretiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento em manutenção corretiva devido a falha no módulo de ECG.'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento atualmente em processo de calibração anual obrigatória.'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção corretiva'),'TecnoMed Assistência',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Contrato ativo. Equipamento em quarentena para análise de ocorrência técnica.'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Roche Diagnostics',(SELECT id FROM periodicidades WHERE designacao='Trimestral'),'Equipamento cedido através de contrato de empréstimo com manutenção incluída.'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Philips Healthcare',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento alugado com manutenção incluída no contrato.'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_contrato WHERE designacao='Manutenção preventiva'),'Philips Healthcare',(SELECT id FROM periodicidades WHERE designacao='Anual'),'Equipamento novo com manutenção preventiva anual ativa.');
-- EQ003, EQ008, EQ011, EQ013, EQ016, EQ023, EQ026, EQ028, EQ029: sem contrato de manutenção

-- ============================================================
-- EQUIPAMENTO_FORNECEDOR (associações N:N)
-- ============================================================

INSERT INTO equipamento_fornecedor (equipamento_id, fornecedor_id, morada_id, pessoa_contacto, telefone_pessoa_contacto, observacoes) VALUES
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor associado a equipamentos de monitorização.'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM fornecedores WHERE codigo='FOR002'),(SELECT id FROM moradas WHERE designacao='Porto, Portugal'),'Miguel Santos','+351 920 000 000','Fabricante do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 940 000 000','Responsável pela manutenção preventiva e corretiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),(SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'Carla Ferreira','+351 930 000 000','Distribuidor do equipamento e consumíveis associados.'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 931 000 000','Responsável pela manutenção corretiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 126 193','Fornecedor original do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM fornecedores WHERE codigo='FOR005'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'Ricardo Moreira','+351 910 111 222','Fornecedor principal do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 960 000 000','Responsável pela manutenção preventiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM fornecedores WHERE codigo='FOR009'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Tiago Oliveira','+351 910 555 666','Fornecedor principal do equipamento e reagentes.'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 000 400','Responsável pela manutenção preventiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'Carla Ferreira','+351 930 000 000','Fornecedor responsável pela entrega do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 000 400','Responsável pela manutenção preventiva e corretiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),(SELECT id FROM fornecedores WHERE codigo='FOR008'),(SELECT id FROM moradas WHERE designacao='Braga, Portugal'),'Sofia Martins','+351 910 444 555','Fornecedor responsável pela entrega do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM fornecedores WHERE codigo='FOR006'),(SELECT id FROM moradas WHERE designacao='Região Autónoma da Madeira, Portugal'),'Ana Ribeiro','+351 910 222 333','Fornecedor principal do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM fornecedores WHERE codigo='FOR007'),(SELECT id FROM moradas WHERE designacao='Faro, Portugal'),'Pedro Costa','+351 910 333 444','Fornecedor responsável pelos consumíveis associados.'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 000 400','Responsável pela avaliação técnica.'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor original do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM fornecedores WHERE codigo='FOR002'),(SELECT id FROM moradas WHERE designacao='Porto, Portugal'),'Miguel Santos','+351 920 000 000','Fornecedor principal do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 000 400','Responsável pela manutenção preventiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'Carla Ferreira','+351 930 000 000','Fornecedor original do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor principal do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM fornecedores WHERE codigo='FOR008'),(SELECT id FROM moradas WHERE designacao='Braga, Portugal'),'Sofia Martins','+351 910 444 555','Fornecedor principal do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM fornecedores WHERE codigo='FOR005'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'Ricardo Moreira','+351 910 111 222','Fornecedor do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM fornecedores WHERE codigo='FOR009'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Tiago Oliveira','+351 910 555 666','Fornecedor dos reagentes laboratoriais.'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'Carla Ferreira','+351 930 000 000','Fornecedor responsável pela entrega e instalação.'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM fornecedores WHERE codigo='FOR007'),(SELECT id FROM moradas WHERE designacao='Faro, Portugal'),'Pedro Costa','+351 910 333 444','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM fornecedores WHERE codigo='FOR003'),(SELECT id FROM moradas WHERE designacao='Aveiro, Portugal'),'Carla Ferreira','+351 930 000 000','Fornecedor responsável pela instalação.'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 000 400','Responsável pela manutenção.'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM fornecedores WHERE codigo='FOR002'),(SELECT id FROM moradas WHERE designacao='Porto, Portugal'),'Miguel Santos','+351 920 000 000','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM fornecedores WHERE codigo='FOR006'),(SELECT id FROM moradas WHERE designacao='Região Autónoma da Madeira, Portugal'),'Ana Ribeiro','+351 910 222 333','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 656 375','Responsável pela manutenção corretiva.'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 656 375','Responsável pela calibração.'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM fornecedores WHERE codigo='FOR008'),(SELECT id FROM moradas WHERE designacao='Braga, Portugal'),'Sofia Martins','+351 910 444 555','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM fornecedores WHERE codigo='FOR007'),(SELECT id FROM moradas WHERE designacao='Faro, Portugal'),'Pedro Costa','+351 910 333 444','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 656 375','Responsável pela avaliação técnica.'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM fornecedores WHERE codigo='FOR009'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Tiago Oliveira','+351 910 555 666','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM fornecedores WHERE codigo='FOR006'),(SELECT id FROM moradas WHERE designacao='Região Autónoma da Madeira, Portugal'),'Ana Ribeiro','+351 910 222 333','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM fornecedores WHERE codigo='FOR002'),(SELECT id FROM moradas WHERE designacao='Porto, Portugal'),'Miguel Santos','+351 920 000 000','Fornecedor original do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM fornecedores WHERE codigo='FOR008'),(SELECT id FROM moradas WHERE designacao='Braga, Portugal'),'Sofia Martins','+351 910 444 555','Fornecedor do equipamento.'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM fornecedores WHERE codigo='FOR001'),(SELECT id FROM moradas WHERE designacao='Lisboa, Portugal'),'Catarina Silva','+351 910 000 000','Fornecedor principal.'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM fornecedores WHERE codigo='FOR004'),(SELECT id FROM moradas WHERE designacao='Coimbra, Portugal'),'João Almeida','+351 930 656 375','Responsável pelo suporte técnico.');

-- ============================================================
-- DOCUMENTAÇÃO DOS EQUIPAMENTOS
-- ============================================================

INSERT INTO documentacao_equipamentos (equipamento_id, tipo_documento_id, nome_documento, data_documento, validade_documento, ficheiro_documento, nome_original_ficheiro) VALUES
-- EQ001
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual IntelliVue MX450','2025-03-10','2030-03-10','manual_servico_EQ001.pdf','manual_servico_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização MX450','2025-03-10','2030-03-10','manual_utilizacao_EQ001.pdf','manual_utilizacao_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade MX450','2025-03-10','2030-03-10','declaracao_conformidade_EQ001.pdf','declaracao_conformidade_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Philips 2025','2025-03-12',NULL,'fatura_EQ001.pdf','fatura_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Certificado de Garantia Philips','2025-03-12','2028-03-12','certificado_garantia_EQ001.pdf','certificado_garantia_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Philips 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ001.pdf','contrato_manutencao_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório de Manutenção 2026','2026-02-15',NULL,'relatorio_manutencao_EQ001.pdf','relatorio_manutencao_EQ001.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração 2026','2026-01-10','2027-01-10','certificado_calibracao_EQ001.pdf','certificado_calibracao_EQ001.pdf'),
-- EQ002
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual Evita V600','2021-09-08','2031-09-08','manual_servico_EQ002.pdf','manual_servico_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Evita V600','2021-09-08','2031-09-08','manual_utilizacao_EQ002.pdf','manual_utilizacao_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Evita V600','2021-09-08','2031-09-08','declaracao_conformidade_EQ002.pdf','declaracao_conformidade_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Dräger 2021','2021-09-08',NULL,'contrato_aquisicao_EQ002.pdf','contrato_aquisicao_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Dräger 2021','2021-09-08',NULL,'fatura_EQ002.pdf','fatura_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Certificado de Garantia Dräger','2021-09-08','2024-09-08','certificado_garantia_EQ002.pdf','certificado_garantia_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato TecnoMed 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ002.pdf','contrato_manutencao_EQ002.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Manutenção Semestral 2025','2025-06-15',NULL,'relatorio_manutencao_EQ002.pdf','relatorio_manutencao_EQ002.pdf'),
-- EQ003
((SELECT id FROM equipamentos WHERE codigo='EQ003'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Infusomat Space','2020-01-21','2030-01-21','manual_utilizacao_EQ003.pdf','manual_utilizacao_EQ003.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura B. Braun 2020','2020-01-21',NULL,'fatura_EQ003.pdf','fatura_EQ003.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração B. Braun 2025','2025-03-15','2026-03-15','certificado_calibracao_EQ003.pdf','certificado_calibracao_EQ003.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório de Calibração 2025','2025-03-15',NULL,'relatorio_calibracao_EQ003.pdf','relatorio_calibracao_EQ003.pdf'),
-- EQ004
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Zoll R Series','2022-06-15','2032-06-15','manual_servico_EQ004.pdf','manual_servico_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Zoll R Series','2022-06-15','2032-06-15','manual_utilizacao_EQ004.pdf','manual_utilizacao_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Zoll R Series','2022-06-15','2032-06-15','declaracao_conformidade_EQ004.pdf','declaracao_conformidade_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Zoll 2022','2022-06-15',NULL,'contrato_aquisicao_EQ004.pdf','contrato_aquisicao_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Zoll 2022','2022-06-15',NULL,'fatura_EQ004.pdf','fatura_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Zoll R Series','2022-06-15','2025-06-15','certificado_garantia_EQ004.pdf','certificado_garantia_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Zoll 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ004.pdf','contrato_manutencao_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Manutenção Anual 2025','2025-03-20',NULL,'relatorio_manutencao_EQ004.pdf','relatorio_manutencao_EQ004.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Zoll 2025','2025-03-20','2026-03-20','certificado_calibracao_EQ004.pdf','certificado_calibracao_EQ004.pdf'),
-- EQ005
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Siemens Acuson Redwood','2024-04-10','2033-04-10','manual_servico_EQ005.pdf','manual_servico_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Acuson Redwood','2024-04-10','2034-04-10','manual_utilizacao_EQ005.pdf','manual_utilizacao_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Siemens Acuson Redwood','2024-04-10','2034-04-10','declaracao_conformidade_EQ005.pdf','declaracao_conformidade_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Siemens 2024','2024-04-10',NULL,'contrato_aquisicao_EQ005.pdf','contrato_aquisicao_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Siemens 2024','2024-04-10',NULL,'fatura_EQ005.pdf','fatura_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Siemens Acuson Redwood','2024-04-10','2027-04-10','certificado_garantia_EQ005.pdf','certificado_garantia_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Siemens 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ005.pdf','contrato_manutencao_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 2025','2025-02-15',NULL,'relatorio_manutencao_EQ005.pdf','relatorio_manutencao_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Ecógrafo 2025','2025-02-15','2026-02-15','certificado_calibracao_EQ005.pdf','certificado_calibracao_EQ005.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração Ecógrafo 2025','2025-02-15',NULL,'relatorio_calibracao_EQ005.pdf','relatorio_calibracao_EQ005.pdf'),
-- EQ006
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Roche Cobas Pure','2024-02-20','2034-02-20','manual_servico_EQ006.pdf','manual_servico_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Cobas Pure','2024-02-20','2034-02-20','manual_utilizacao_EQ006.pdf','manual_utilizacao_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Cobas Pure','2024-02-20','2034-02-20','declaracao_conformidade_EQ006.pdf','declaracao_conformidade_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Roche 2024','2024-02-20',NULL,'contrato_aquisicao_EQ006.pdf','contrato_aquisicao_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Roche 2024','2024-02-20',NULL,'fatura_EQ006.pdf','fatura_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Roche Cobas Pure','2024-02-20','2027-02-20','certificado_garantia_EQ006.pdf','certificado_garantia_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Roche 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ006.pdf','contrato_manutencao_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 1º Semestre 2025','2025-03-15',NULL,'relatorio_manutencao_EQ006.pdf','relatorio_manutencao_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Cobas Pure 2025','2025-03-15','2026-03-15','certificado_calibracao_EQ006.pdf','certificado_calibracao_EQ006.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração Cobas Pure 2025','2025-03-15',NULL,'relatorio_calibracao_EQ006.pdf','relatorio_calibracao_EQ006.pdf'),
-- EQ007
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Getinge HS66','2021-05-12','2031-05-12','manual_servico_EQ007.pdf','manual_servico_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Getinge HS66','2021-05-12','2031-05-12','manual_utilizacao_EQ007.pdf','manual_utilizacao_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Getinge HS66','2021-05-12','2031-05-12','declaracao_conformidade_EQ007.pdf','declaracao_conformidade_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Getinge 2021','2021-05-12',NULL,'contrato_aquisicao_EQ007.pdf','contrato_aquisicao_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Getinge 2021','2021-05-12',NULL,'fatura_EQ007.pdf','fatura_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Getinge HS66','2021-05-12','2024-05-12','certificado_garantia_EQ007.pdf','certificado_garantia_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Getinge 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ007.pdf','contrato_manutencao_EQ007.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 1º Trimestre 2025','2025-03-05',NULL,'relatorio_manutencao_EQ007.pdf','relatorio_manutencao_EQ007.pdf'),
-- EQ008
((SELECT id FROM equipamentos WHERE codigo='EQ008'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço BTL-5820S','2023-01-10','2033-01-10','manual_servico_EQ008.pdf','manual_servico_EQ008.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização BTL-5820S','2023-01-10','2033-01-10','manual_utilizacao_EQ008.pdf','manual_utilizacao_EQ008.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade BTL-5820S','2023-01-10','2033-01-10','declaracao_conformidade_EQ008.pdf','declaracao_conformidade_EQ008.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia BTL-5820S','2023-02-15','2026-02-15','certificado_garantia_EQ008.pdf','certificado_garantia_EQ008.pdf'),
-- EQ009
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço CARESCAPE B450','2022-09-08','2032-09-08','manual_servico_EQ009.pdf','manual_servico_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização CARESCAPE B450','2022-09-08','2032-09-08','manual_utilizacao_EQ009.pdf','manual_utilizacao_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade CARESCAPE B450','2022-09-08','2032-09-08','declaracao_conformidade_EQ009.pdf','declaracao_conformidade_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de aluguer'),'Contrato Aluguer GE 2022','2022-09-08','2027-09-08','contrato_aluguer_EQ009.pdf','contrato_aluguer_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura GE 2022','2022-09-08',NULL,'fatura_EQ009.pdf','fatura_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia GE CARESCAPE B450','2022-09-08','2025-09-08','certificado_garantia_EQ009.pdf','certificado_garantia_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção GE 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ009.pdf','contrato_manutencao_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração B450 2025','2025-05-10','2026-05-10','certificado_calibracao_EQ009.pdf','certificado_calibracao_EQ009.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração B450 2025','2025-05-10',NULL,'relatorio_calibracao_EQ009.pdf','relatorio_calibracao_EQ009.pdf'),
-- EQ010
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Perfusor Space','2021-03-15','2031-03-15','manual_servico_EQ010.pdf','manual_servico_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Perfusor Space','2021-03-15','2031-03-15','manual_utilizacao_EQ010.pdf','manual_utilizacao_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Perfusor Space','2021-03-15','2031-03-15','declaracao_conformidade_EQ010.pdf','declaracao_conformidade_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de empréstimo'),'Contrato Empréstimo Bomba Infusora 2021','2021-07-22','2026-07-22','contrato_emprestimo_EQ010.pdf','contrato_emprestimo_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Perfusor Space','2021-07-22','2024-07-22','certificado_garantia_EQ010.pdf','certificado_garantia_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Perfusor 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ010.pdf','contrato_manutencao_EQ010.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Avaliação Técnica 2025','2025-04-18',NULL,'relatorio_manutencao_EQ010.pdf','relatorio_manutencao_EQ010.pdf'),
-- EQ011
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Philips TC35','2020-02-10','2030-02-10','manual_servico_EQ011.pdf','manual_servico_EQ011.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Philips TC35','2020-02-10','2030-02-10','manual_utilizacao_EQ011.pdf','manual_utilizacao_EQ011.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Philips TC35','2020-02-10','2030-02-10','declaracao_conformidade_EQ011.pdf','declaracao_conformidade_EQ011.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Philips 2020','2020-02-10',NULL,'contrato_aquisicao_EQ011.pdf','contrato_aquisicao_EQ011.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Philips 2020','2020-02-10',NULL,'fatura_EQ011.pdf','fatura_EQ011.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Philips TC35','2020-02-10','2023-02-10','certificado_garantia_EQ011.pdf','certificado_garantia_EQ011.pdf'),
-- EQ012
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Dräger Evita V600','2023-01-12','2033-01-12','manual_servico_EQ012.pdf','manual_servico_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Evita V600','2023-01-12','2033-01-12','manual_utilizacao_EQ012.pdf','manual_utilizacao_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Evita V600','2023-01-12','2033-01-12','declaracao_conformidade_EQ012.pdf','declaracao_conformidade_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Dräger 2023','2023-01-12',NULL,'contrato_aquisicao_EQ012.pdf','contrato_aquisicao_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Dräger 2023','2023-01-12',NULL,'fatura_EQ012.pdf','fatura_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Dräger Evita V600','2023-01-12','2026-01-12','certificado_garantia_EQ012.pdf','certificado_garantia_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Dräger 2025','2025-01-01','2025-12-31','contrato_manutencao_EQ012.pdf','contrato_manutencao_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 1º Semestre 2025','2025-04-15',NULL,'relatorio_manutencao_EQ012.pdf','relatorio_manutencao_EQ012.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Evita V600','2025-04-15','2026-04-15','certificado_calibracao_EQ012.pdf','certificado_calibracao_EQ012.pdf'),
-- EQ013
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Eppendorf 5702','2016-04-05','2026-04-05','manual_servico_EQ013.pdf','manual_servico_EQ013.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Eppendorf 5702','2016-04-05','2026-04-05','manual_utilizacao_EQ013.pdf','manual_utilizacao_EQ013.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Eppendorf 5702','2016-04-05','2026-04-05','declaracao_conformidade_EQ013.pdf','declaracao_conformidade_EQ013.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Centrífuga 2016','2016-04-05',NULL,'contrato_aquisicao_EQ013.pdf','contrato_aquisicao_EQ013.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Centrífuga 2016','2016-04-05',NULL,'fatura_EQ013.pdf','fatura_EQ013.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ013'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Eppendorf 5702','2016-04-05','2019-04-05','certificado_garantia_EQ013.pdf','certificado_garantia_EQ013.pdf'),
-- EQ014
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço IntelliVue MX550','2022-06-20','2032-06-20','manual_servico_EQ014.pdf','manual_servico_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização IntelliVue MX550','2022-06-20','2032-06-20','manual_utilizacao_EQ014.pdf','manual_utilizacao_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade IntelliVue MX550','2022-06-20','2032-06-20','declaracao_conformidade_EQ014.pdf','declaracao_conformidade_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Philips 2022','2022-06-20',NULL,'contrato_aquisicao_EQ014.pdf','contrato_aquisicao_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Philips MX550','2022-06-20',NULL,'fatura_EQ014.pdf','fatura_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia IntelliVue MX550','2023-06-20','2026-06-25','certificado_garantia_EQ014.pdf','certificado_garantia_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Philips 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ014.pdf','contrato_manutencao_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 2026','2026-01-15',NULL,'relatorio_manutencao_EQ014.pdf','relatorio_manutencao_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração MX550','2026-01-15','2027-01-15','certificado_calibracao_EQ014.pdf','certificado_calibracao_EQ014.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração MX550','2026-01-15',NULL,'relatorio_calibracao_EQ014.pdf','relatorio_calibracao_EQ014.pdf'),
-- EQ015
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Biodex Gait Trainer 3','2022-09-15','2032-09-15','manual_servico_EQ015.pdf','manual_servico_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Gait Trainer 3','2022-09-15','2032-09-15','manual_utilizacao_EQ015.pdf','manual_utilizacao_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Gait Trainer 3','2022-09-15','2032-09-15','declaracao_conformidade_EQ015.pdf','declaracao_conformidade_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de aluguer'),'Contrato Aluguer Biodex 2022','2022-10-10','2027-10-10','contrato_aluguer_EQ015.pdf','contrato_aluguer_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Biodex 2022','2022-10-10',NULL,'fatura_EQ015.pdf','fatura_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Biodex Gait Trainer 3','2022-10-10','2026-06-28','certificado_garantia_EQ015.pdf','certificado_garantia_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Biodex 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ015.pdf','contrato_manutencao_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 2026','2026-02-15',NULL,'relatorio_manutencao_EQ015.pdf','relatorio_manutencao_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Gait Trainer 2026','2026-05-20','2026-06-20','certificado_calibracao_EQ015.pdf','certificado_calibracao_EQ015.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração Gait Trainer 2026','2026-05-20',NULL,'relatorio_calibracao_EQ015.pdf','relatorio_calibracao_EQ015.pdf'),
-- EQ016
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço ACUSON Redwood','2024-01-15','2034-01-15','manual_servico_EQ016.pdf','manual_servico_EQ016.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização ACUSON Redwood','2024-01-15','2034-01-15','manual_utilizacao_EQ016.pdf','manual_utilizacao_EQ016.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade ACUSON Redwood','2024-01-15','2034-01-15','declaracao_conformidade_EQ016.pdf','declaracao_conformidade_EQ016.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Termo de doação'),'Termo de Doação Ecógrafo 2024','2024-02-20',NULL,'termo_doacao_EQ016.pdf','termo_doacao_EQ016.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia ACUSON Redwood','2024-02-20','2028-02-20','certificado_garantia_EQ016.pdf','certificado_garantia_EQ016.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Redwood 2026','2026-01-15','2027-01-15','certificado_calibracao_EQ016.pdf','certificado_calibracao_EQ016.pdf'),
-- EQ017
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Sysmex XN-550','2024-03-12','2034-03-12','manual_servico_EQ017.pdf','manual_servico_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Sysmex XN-550','2024-03-12','2034-03-12','manual_utilizacao_EQ017.pdf','manual_utilizacao_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Sysmex XN-550','2024-03-12','2034-03-12','declaracao_conformidade_EQ017.pdf','declaracao_conformidade_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Sysmex 2024','2024-03-18',NULL,'contrato_aquisicao_EQ017.pdf','contrato_aquisicao_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Sysmex XN-550','2024-03-18',NULL,'fatura_EQ017.pdf','fatura_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Sysmex XN-550','2024-03-18','2027-03-18','certificado_garantia_EQ017.pdf','certificado_garantia_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Sysmex 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ017.pdf','contrato_manutencao_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo Laboratório 2026','2026-01-10',NULL,'relatorio_manutencao_EQ017.pdf','relatorio_manutencao_EQ017.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração XN-550','2026-01-10','2027-01-10','certificado_calibracao_EQ017.pdf','certificado_calibracao_EQ017.pdf'),
-- EQ018
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Perfusor Compact Plus','2023-07-18','2033-07-18','manual_servico_EQ018.pdf','manual_servico_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Perfusor Compact Plus','2023-07-18','2033-07-18','manual_utilizacao_EQ018.pdf','manual_utilizacao_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Perfusor Compact Plus','2023-07-18','2033-07-18','declaracao_conformidade_EQ018.pdf','declaracao_conformidade_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Bomba Seringa 2023','2023-07-18',NULL,'contrato_aquisicao_EQ018.pdf','contrato_aquisicao_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Bomba Seringa 2023','2023-07-18',NULL,'fatura_EQ018.pdf','fatura_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Perfusor Compact Plus','2023-07-18','2026-06-30','certificado_garantia_EQ018.pdf','certificado_garantia_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção B. Braun 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ018.pdf','contrato_manutencao_EQ018.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ018'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo 2026','2026-02-15',NULL,'relatorio_manutencao_EQ018.pdf','relatorio_manutencao_EQ018.pdf'),
-- EQ019
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Getinge WD15 Claro','2019-04-15','2029-04-15','manual_servico_EQ019.pdf','manual_servico_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Getinge WD15 Claro','2019-04-15','2029-04-15','manual_utilizacao_EQ019.pdf','manual_utilizacao_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade WD15 Claro','2019-04-15','2029-04-15','declaracao_conformidade_EQ019.pdf','declaracao_conformidade_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição WD15 2019','2019-05-20',NULL,'contrato_aquisicao_EQ019.pdf','contrato_aquisicao_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura WD15 2019','2019-05-20',NULL,'fatura_EQ019.pdf','fatura_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Getinge WD15','2019-05-20','2022-05-20','certificado_garantia_EQ019.pdf','certificado_garantia_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção WD15 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ019.pdf','contrato_manutencao_EQ019.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo WD15 2026','2026-01-10',NULL,'relatorio_manutencao_EQ019.pdf','relatorio_manutencao_EQ019.pdf'),
-- EQ020
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Isolette 8000 Plus','2023-05-05','2033-05-05','manual_servico_EQ020.pdf','manual_servico_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Isolette 8000 Plus','2023-05-05','2033-05-05','manual_utilizacao_EQ020.pdf','manual_utilizacao_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Isolette 8000 Plus','2023-05-05','2033-05-05','declaracao_conformidade_EQ020.pdf','declaracao_conformidade_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Incubadora 2023','2023-05-05',NULL,'contrato_aquisicao_EQ020.pdf','contrato_aquisicao_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Incubadora 2023','2023-05-05',NULL,'fatura_EQ020.pdf','fatura_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Isolette 8000 Plus','2023-05-05','2026-07-05','certificado_garantia_EQ020.pdf','certificado_garantia_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Isolette 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ020.pdf','contrato_manutencao_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo Isolette 2026','2026-01-20',NULL,'relatorio_manutencao_EQ020.pdf','relatorio_manutencao_EQ020.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Isolette','2026-01-20','2027-01-20','certificado_calibracao_EQ020.pdf','certificado_calibracao_EQ020.pdf'),
-- EQ021
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço CARESCAPE B450','2021-03-10','2031-03-10','manual_servico_EQ021.pdf','manual_servico_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização CARESCAPE B450','2021-03-10','2031-03-10','manual_utilizacao_EQ021.pdf','manual_utilizacao_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade CARESCAPE B450','2021-03-10','2031-03-10','declaracao_conformidade_EQ021.pdf','declaracao_conformidade_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Monitor GE 2021','2021-03-25',NULL,'contrato_aquisicao_EQ021.pdf','contrato_aquisicao_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Monitor GE 2021','2021-03-25',NULL,'fatura_EQ021.pdf','fatura_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia CARESCAPE B450','2021-03-25','2024-03-25','certificado_garantia_EQ021.pdf','certificado_garantia_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção GE 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ021.pdf','contrato_manutencao_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Corretivo B450','2026-06-05',NULL,'relatorio_manutencao_EQ021.pdf','relatorio_manutencao_EQ021.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração B450','2026-02-15','2027-02-15','certificado_calibracao_EQ021.pdf','certificado_calibracao_EQ021.pdf'),
-- EQ022
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço PageWriter TC35','2022-05-12','2032-05-12','manual_servico_EQ022.pdf','manual_servico_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização PageWriter TC35','2022-05-12','2032-05-12','manual_utilizacao_EQ022.pdf','manual_utilizacao_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade PageWriter TC35','2022-05-12','2032-05-12','declaracao_conformidade_EQ022.pdf','declaracao_conformidade_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição ECG 2022','2022-06-20',NULL,'contrato_aquisicao_EQ022.pdf','contrato_aquisicao_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura ECG Philips 2022','2022-06-20',NULL,'fatura_EQ022.pdf','fatura_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia PageWriter TC35','2022-06-20','2025-06-20','certificado_garantia_EQ022.pdf','certificado_garantia_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção ECG 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ022.pdf','contrato_manutencao_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo ECG 2026','2026-01-15',NULL,'relatorio_manutencao_EQ022.pdf','relatorio_manutencao_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração TC35','2026-06-10','2027-06-10','certificado_calibracao_EQ022.pdf','certificado_calibracao_EQ022.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Calibração'),'Relatório Calibração TC35','2026-06-10',NULL,'relatorio_calibracao_EQ022.pdf','relatorio_calibracao_EQ022.pdf'),
-- EQ023
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Ergoselect 200','2018-03-15','2028-03-15','manual_servico_EQ023.pdf','manual_servico_EQ023.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Ergoselect 200','2018-03-15','2028-03-15','manual_utilizacao_EQ023.pdf','manual_utilizacao_EQ023.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Ergoselect 200','2018-03-15','2028-03-15','declaracao_conformidade_EQ023.pdf','declaracao_conformidade_EQ023.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Ergoselect 2018','2018-04-20',NULL,'contrato_aquisicao_EQ023.pdf','contrato_aquisicao_EQ023.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Ergoselect 2018','2018-04-20',NULL,'fatura_EQ023.pdf','fatura_EQ023.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ023'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Ergoselect 200','2018-04-20','2021-04-20','certificado_garantia_EQ023.pdf','certificado_garantia_EQ023.pdf'),
-- EQ024
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Infusomat Space','2020-01-15','2030-01-15','manual_servico_EQ024.pdf','manual_servico_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Infusomat Space','2020-01-15','2030-01-15','manual_utilizacao_EQ024.pdf','manual_utilizacao_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Infusomat Space','2020-01-15','2030-01-15','declaracao_conformidade_EQ024.pdf','declaracao_conformidade_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Infusomat 2020','2020-02-20',NULL,'contrato_aquisicao_EQ024.pdf','contrato_aquisicao_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Infusomat 2020','2020-02-20',NULL,'fatura_EQ024.pdf','fatura_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Infusomat Space','2020-02-20','2023-02-20','certificado_garantia_EQ024.pdf','certificado_garantia_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Infusomat 2026','2026-01-01','2026-07-15','contrato_manutencao_EQ024.pdf','contrato_manutencao_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Avaliação Técnica 2026','2026-06-08',NULL,'relatorio_manutencao_EQ024.pdf','relatorio_manutencao_EQ024.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ024'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Infusomat','2026-02-10','2027-02-10','certificado_calibracao_EQ024.pdf','certificado_calibracao_EQ024.pdf'),
-- EQ025
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Cobas c 311','2024-02-10','2034-02-10','manual_servico_EQ025.pdf','manual_servico_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Cobas c 311','2024-02-10','2034-02-10','manual_utilizacao_EQ025.pdf','manual_utilizacao_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Cobas c 311','2024-02-10','2034-02-10','declaracao_conformidade_EQ025.pdf','declaracao_conformidade_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de empréstimo'),'Contrato Empréstimo Cobas c311','2024-08-01','2027-08-01','contrato_emprestimo_EQ025.pdf','contrato_emprestimo_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Cobas c311','2024-08-01','2026-07-12','certificado_garantia_EQ025.pdf','certificado_garantia_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Roche 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ025.pdf','contrato_manutencao_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Trimestral 2026','2026-04-01',NULL,'relatorio_manutencao_EQ025.pdf','relatorio_manutencao_EQ025.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Cobas c311','2026-04-01','2027-04-01','certificado_calibracao_EQ025.pdf','certificado_calibracao_EQ025.pdf'),
-- EQ026
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço SEER 1000','2015-02-10','2025-02-10','manual_servico_EQ026.pdf','manual_servico_EQ026.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização SEER 1000','2015-02-10','2025-02-10','manual_utilizacao_EQ026.pdf','manual_utilizacao_EQ026.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade SEER 1000','2015-02-10','2025-02-10','declaracao_conformidade_EQ026.pdf','declaracao_conformidade_EQ026.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Holter 2015','2015-03-20',NULL,'contrato_aquisicao_EQ026.pdf','contrato_aquisicao_EQ026.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Holter 2015','2015-03-20',NULL,'fatura_EQ026.pdf','fatura_EQ026.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ026'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia SEER 1000','2015-03-20','2018-03-20','certificado_garantia_EQ026.pdf','certificado_garantia_EQ026.pdf'),
-- EQ027
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Philips Lumify','2025-01-15','2035-01-15','manual_servico_EQ027.pdf','manual_servico_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Philips Lumify','2025-01-15','2035-01-15','manual_utilizacao_EQ027.pdf','manual_utilizacao_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Philips Lumify','2025-01-15','2035-01-15','declaracao_conformidade_EQ027.pdf','declaracao_conformidade_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de aluguer'),'Contrato Aluguer Lumify','2025-02-01','2027-01-31','contrato_aluguer_EQ027.pdf','contrato_aluguer_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Aluguer Fevereiro 2025','2025-02-01',NULL,'fatura_EQ027.pdf','fatura_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Philips Lumify','2025-02-01','2028-02-01','certificado_garantia_EQ027.pdf','certificado_garantia_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção Lumify','2026-01-01','2026-12-31','contrato_manutencao_EQ027.pdf','contrato_manutencao_EQ027.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo Lumify','2026-02-12',NULL,'relatorio_manutencao_EQ027.pdf','relatorio_manutencao_EQ027.pdf'),
-- EQ028
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Oxylog 3000 Plus','2019-04-12','2029-04-12','manual_servico_EQ028.pdf','manual_servico_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Oxylog 3000 Plus','2019-04-12','2029-04-12','manual_utilizacao_EQ028.pdf','manual_utilizacao_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Oxylog 3000 Plus','2019-04-12','2029-04-12','declaracao_conformidade_EQ028.pdf','declaracao_conformidade_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Oxylog 2019','2019-05-10',NULL,'contrato_aquisicao_EQ028.pdf','contrato_aquisicao_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Oxylog 2019','2019-05-10',NULL,'fatura_EQ028.pdf','fatura_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Oxylog 3000 Plus','2019-05-10','2022-05-10','certificado_garantia_EQ028.pdf','certificado_garantia_EQ028.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração Oxylog','2026-01-15','2027-01-15','certificado_calibracao_EQ028.pdf','certificado_calibracao_EQ028.pdf'),
-- EQ029
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço Gait Trainer 3','2022-03-15','2032-03-15','manual_servico_EQ029.pdf','manual_servico_EQ029.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização Gait Trainer 3','2022-03-15','2032-03-15','manual_utilizacao_EQ029.pdf','manual_utilizacao_EQ029.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade Gait Trainer 3','2022-03-15','2032-03-15','declaracao_conformidade_EQ029.pdf','declaracao_conformidade_EQ029.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição Gait Trainer 2022','2022-04-20',NULL,'contrato_aquisicao_EQ029.pdf','contrato_aquisicao_EQ029.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura Gait Trainer 2022','2022-04-20',NULL,'fatura_EQ029.pdf','fatura_EQ029.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia Gait Trainer 3','2022-04-20','2025-04-20','certificado_garantia_EQ029.pdf','certificado_garantia_EQ029.pdf'),
-- EQ030
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Serviço'),'Manual de Serviço IntelliVue MX550','2025-02-15','2035-02-15','manual_servico_EQ030.pdf','manual_servico_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Manual de Utilização'),'Manual de Utilização IntelliVue MX550','2025-02-15','2035-02-15','manual_utilizacao_EQ030.pdf','manual_utilizacao_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Declaração de Conformidade'),'Declaração de Conformidade IntelliVue MX550','2025-02-15','2035-02-15','declaracao_conformidade_EQ030.pdf','declaracao_conformidade_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Aquisição'),'Contrato Aquisição IntelliVue MX550','2025-03-01',NULL,'contrato_aquisicao_EQ030.pdf','contrato_aquisicao_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Fatura'),'Fatura IntelliVue MX550','2025-03-01',NULL,'fatura_EQ030.pdf','fatura_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Garantia'),'Garantia IntelliVue MX550','2025-03-01','2029-03-01','certificado_garantia_EQ030.pdf','certificado_garantia_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Contrato de Manutenção'),'Contrato Manutenção IntelliVue 2026','2026-01-01','2026-12-31','contrato_manutencao_EQ030.pdf','contrato_manutencao_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Relatório de Manutenção'),'Relatório Preventivo IntelliVue 2026','2026-03-15',NULL,'relatorio_manutencao_EQ030.pdf','relatorio_manutencao_EQ030.pdf'),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),(SELECT id FROM tipos_documento_equipamento WHERE designacao='Certificado de Calibração'),'Certificado Calibração MX550','2026-03-15','2027-03-15','certificado_calibracao_EQ030.pdf','certificado_calibracao_EQ030.pdf');

-- ============================================================
-- ACESSÓRIOS
-- ============================================================

INSERT INTO acessorios (equipamento_id, nome, referencia, quantidade, unidade_id, estado_id, observacoes) VALUES
-- EQ001
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'Cabo de ECG 5 derivações','ACC-ECG-001',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'Sensor de SpO2 adulto','ACC-SPO2-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'Manguito de pressão arterial adulto','ACC-NIBP-001',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ002
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Circuito ventilatório adulto reutilizável','ACC-CIR-001',3,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Filtro bacteriano/viral','ACC-FIL-001',5,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Sensor de fluxo proximal','ACC-SFP-001',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ003
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'Suporte de poste para bomba','ACC-SUP-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'Cabo de alimentação de substituição','ACC-CAB-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ004
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Pás externas reutilizáveis adulto','ACC-PAS-001',1,(SELECT id FROM unidades WHERE designacao='par'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Cabo de ECG 3 derivações','ACC-ECG-002',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Cabo de SpO2','ACC-SPO2-002',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ005
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'Sonda convexa','ACC-SON-001',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'Sonda linear','ACC-SON-002',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'Pedal multifunções','ACC-PED-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ006
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'Leitor de código de barras','ACC-LCB-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'Módulo de amostras','ACC-MOD-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ007
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'Carro de carga','ACC-CAR-001',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'Cestos inox','ACC-CES-001',8,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ008
((SELECT id FROM equipamentos WHERE codigo='EQ008'),'Cabeça de tratamento 1 MHz','ACC-US-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ008'),'Cabeça de tratamento 3 MHz','ACC-US-002',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ009
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'Sensor SpO2','ACC-SPO2-009',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'Braçadeira NIBP adulto','ACC-NIBP-009',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'Cabo ECG 5 derivações','ACC-ECG-009',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ010
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'Suporte de fixação','ACC-SUP-010',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'Cabo de alimentação','ACC-CAB-010',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ011
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'Cabo ECG 12 derivações','ACC-ECG-011',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'Carrinho de transporte','ACC-CAR-011',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ012
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'Braço articulado','ACC-BRA-012',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'Humidificador aquecido','ACC-HUM-012',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ013
((SELECT id FROM equipamentos WHERE codigo='EQ013'),'Rotor de 24 posições','ACC-ROT-013',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='danificado'),''),
-- EQ014
((SELECT id FROM equipamentos WHERE codigo='EQ014'),'Sensor SpO2','ACC-SPO2-014',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ014'),'Cabo ECG','ACC-ECG-014',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ015
((SELECT id FROM equipamentos WHERE codigo='EQ015'),'Arnês de segurança','ACC-ARN-015',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ015'),'Barra de apoio lateral','ACC-BAR-015',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ016
((SELECT id FROM equipamentos WHERE codigo='EQ016'),'Sonda Convexa','ACC-SON-016',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ016'),'Sonda Linear','ACC-SON-017',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ017
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'Leitor de códigos de barras','ACC-COD-017',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'UPS','ACC-UPS-017',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ018
((SELECT id FROM equipamentos WHERE codigo='EQ018'),'Suporte de fixação','ACC-SUP-018',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ019
((SELECT id FROM equipamentos WHERE codigo='EQ019'),'Cesto para instrumentos','ACC-CES-019',6,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ020
((SELECT id FROM equipamentos WHERE codigo='EQ020'),'Sensor de temperatura','ACC-TMP-020',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ020'),'Colchão neonatal','ACC-COL-020',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ021
((SELECT id FROM equipamentos WHERE codigo='EQ021'),'Sensor SpO2','ACC-SPO2-021',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ021'),'Cabo ECG','ACC-ECG-021',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ022
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'Cabo ECG 10 derivações','ACC-ECG-022',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'Carro de transporte','ACC-CAR-022',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ023
((SELECT id FROM equipamentos WHERE codigo='EQ023'),'Sensor de frequência cardíaca','ACC-FC-023',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ024
((SELECT id FROM equipamentos WHERE codigo='EQ024'),'Suporte de fixação','ACC-SUP-024',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ025
((SELECT id FROM equipamentos WHERE codigo='EQ025'),'Leitor de código de barras','ACC-COD-025',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ026
((SELECT id FROM equipamentos WHERE codigo='EQ026'),'Bolsa de transporte','ACC-BOL-026',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='abatido'),''),
-- EQ027
((SELECT id FROM equipamentos WHERE codigo='EQ027'),'Sonda convexa','ACC-SON-027',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ027'),'Tablet clínico','ACC-TAB-027',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ028
((SELECT id FROM equipamentos WHERE codigo='EQ028'),'Circuito respiratório reutilizável','ACC-CIR-028',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ028'),'Mala de transporte','ACC-MAL-028',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ029
((SELECT id FROM equipamentos WHERE codigo='EQ029'),'Arnês de segurança','ACC-ARN-029',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ029'),'Barra de apoio lateral','ACC-BAR-029',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ030
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'Sensor SpO2','ACC-SPO2-030',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'Cabo ECG 5 derivações','ACC-ECG-030',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'Braçadeira NIBP','ACC-NIBP-030',2,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),'');


-- ============================================================
-- CONSUMÍVEIS
-- ============================================================

INSERT INTO consumiveis (equipamento_id, nome, referencia, quantidade, unidade_id, estado_id, observacoes) VALUES
-- EQ001
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'Elétrodos de ECG descartáveis','CON-ECG-001',100,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),'Repor quando stock atingir 20 unidades'),
((SELECT id FROM equipamentos WHERE codigo='EQ001'),'Papel de impressão térmica','CON-PAP-001',5,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ002
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Circuito ventilatório descartável','CON-CIR-001',10,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Câmara de humidificação descartável','CON-HUM-001',8,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ002'),'Filtro HME descartável','CON-HME-001',20,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),'Substituir a cada 24h'),
-- EQ003
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'Linha de infusão B. Braun compatível','CON-LIN-001',20,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'Seringa 50ml','CON-SER-001',30,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ003'),'Seringa 20ml','CON-SER-002',20,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ004
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Elétrodos multifunções descartáveis adulto','CON-ELE-001',5,(SELECT id FROM unidades WHERE designacao='par'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),'Verificar validade regularmente'),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Papel de registo ECG','CON-PAP-002',3,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ004'),'Bateria de substituição','CON-BAT-001',1,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),'Manter sempre carregada'),
-- EQ005
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'Gel de ultrassom','CON-GEL-001',20,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ005'),'Papel térmico','CON-PAP-003',5,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ006
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'Reagente Bioquímico','CON-REB-001',12,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'Cuvetes descartáveis','CON-CUV-001',500,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ006'),'Solução de limpeza','CON-LIM-001',4,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ007
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'Indicadores químicos','CON-IND-001',150,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ007'),'Fita de esterilização','CON-FIT-001',25,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ008
((SELECT id FROM equipamentos WHERE codigo='EQ008'),'Gel condutor','CON-GEL-002',10,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ009
((SELECT id FROM equipamentos WHERE codigo='EQ009'),'Elétrodos ECG descartáveis','CON-ECG-009',100,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ010
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'Equipos de infusão','CON-EQP-010',50,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ010'),'Seringas 50 ml','CON-SER-010',100,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ011
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'Papel térmico ECG','CON-PAP-011',8,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ011'),'Elétrodos descartáveis','CON-ELE-011',200,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ012
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'Circuito respiratório','CON-CIR-012',20,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ012'),'Filtro bacteriano','CON-FIL-012',30,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ013
((SELECT id FROM equipamentos WHERE codigo='EQ013'),'Tubos de centrifugação','CON-TUB-013',0,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='danificado'),''),
-- EQ014
((SELECT id FROM equipamentos WHERE codigo='EQ014'),'Elétrodos ECG','CON-ECG-014',150,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='em-uso'),''),
-- EQ016
((SELECT id FROM equipamentos WHERE codigo='EQ016'),'Gel para ultrassons','CON-GEL-016',20,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ017
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'Reagente diluente','CON-DIL-017',8,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ017'),'Controlo hematológico','CON-CTL-017',4,(SELECT id FROM unidades WHERE designacao='kit'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ018
((SELECT id FROM equipamentos WHERE codigo='EQ018'),'Seringas 50 ml','CON-SER-018',120,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ019
((SELECT id FROM equipamentos WHERE codigo='EQ019'),'Detergente enzimático','CON-DET-019',10,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ019'),'Neutralizante','CON-NEU-019',6,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ020
((SELECT id FROM equipamentos WHERE codigo='EQ020'),'Filtro de ar','CON-FIL-020',10,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ021
((SELECT id FROM equipamentos WHERE codigo='EQ021'),'Elétrodos ECG','CON-ECG-021',200,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ022
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'Papel térmico ECG','CON-PAP-022',15,(SELECT id FROM unidades WHERE designacao='rolo'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ022'),'Elétrodos descartáveis','CON-ELE-022',300,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ024
((SELECT id FROM equipamentos WHERE codigo='EQ024'),'Equipos de infusão','CON-INF-024',100,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ025
((SELECT id FROM equipamentos WHERE codigo='EQ025'),'Reagente bioquímico','CON-REA-025',12,(SELECT id FROM unidades WHERE designacao='kit'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
((SELECT id FROM equipamentos WHERE codigo='EQ025'),'Calibrador','CON-CAL-025',4,(SELECT id FROM unidades WHERE designacao='kit'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ026
((SELECT id FROM equipamentos WHERE codigo='EQ026'),'Elétrodos descartáveis','CON-ELE-026',0,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='abatido'),''),
-- EQ027
((SELECT id FROM equipamentos WHERE codigo='EQ027'),'Gel de ultrassom','CON-GEL-027',20,(SELECT id FROM unidades WHERE designacao='frasco'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ028
((SELECT id FROM equipamentos WHERE codigo='EQ028'),'Filtro respiratório','CON-FIL-028',15,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),''),
-- EQ030
((SELECT id FROM equipamentos WHERE codigo='EQ030'),'Elétrodos ECG','CON-ECG-030',300,(SELECT id FROM unidades WHERE designacao='unid'),(SELECT id FROM estados_acessorio WHERE valor='novo'),'');
-- EQ015, EQ023, EQ029: sem consumíveis


-- ============================================================
-- CONTEÚDOS PÚBLICOS
-- ============================================================

INSERT INTO conteudos_publicos (nome_campo, conteudo_campo) VALUES
('home_titulo',              'Sistema de Inventário de Equipamentos Hospitalares'),
('home_texto',               'Plataforma web para gestão e monitorização do inventário de equipamentos médicos em ambiente hospitalar.'),
('home_botao',               'Entre em contacto connosco'),
('sobre_titulo',             'Sobre a MediVault'),
('sobre_texto_1',            'A MediVault é uma plataforma web desenvolvida para apoiar instituições de saúde na gestão organizada e centralizada do inventário hospitalar de equipamentos médicos.'),
('sobre_texto_2',            'O sistema permite reunir, num único local, informação essencial sobre os equipamentos, incluindo categoria, localização, estado atual, fornecedor, documentação técnica, garantias e contactos associados.'),
('sobre_texto_3',            'O objetivo da plataforma é substituir métodos dispersos, como folhas de cálculo, documentos isolados e registos manuais, por uma solução digital mais segura, acessível e eficiente para os utilizadores autorizados.'),
('sobre_card_titulo',        'O que a MediVault permite?'),
('sobre_card_texto_1',       'Gerir equipamentos médicos e respetiva informação técnica;'),
('sobre_card_texto_2',       'Associar equipamentos a localizações hospitalares específicas;'),
('sobre_card_texto_3',       'Registar fornecedores, garantias e contratos associados;'),
('sobre_card_texto_4',       'Consultar indicadores básicos através de um dashboard.'),
('funcionalidades_titulo',   'Funcionalidades'),
('funcionalidades_texto',    'A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.'),
('funcionalidade_titulo_1',  'Gestão de Equipamentos'),
('funcionalidade_texto_1',   'Registo, consulta, edição e remoção de equipamentos médicos existentes no inventário hospitalar, com total segurança e controlo.'),
('funcionalidade_titulo_2',  'Localizações'),
('funcionalidade_texto_2',   'Organização da localização física dos equipamentos por edifício, piso, serviço e sala.'),
('funcionalidade_titulo_3',  'Fornecedores'),
('funcionalidade_texto_3',   'Gestão de fornecedores associados aos equipamentos médicos e respetivos contactos.'),
('funcionalidade_titulo_4',  'Documentação'),
('funcionalidade_texto_4',   'Registo e controlo de documentação técnica, manuais, certificados e relatórios.'),
('funcionalidade_titulo_5',  'Garantias e Contratos'),
('funcionalidade_texto_5',   'Acompanhamento de garantias, contratos de manutenção e datas relevantes.'),
('funcionalidade_titulo_6',  'Pesquisa e Filtragem'),
('funcionalidade_texto_6',   'Encontre rapidamente os equipamentos, fornecedores e localizações pretendidos através de pesquisa e filtros avançados.'),
('funcionalidade_titulo_7',  'Dashboard'),
('funcionalidade_texto_7',   'Visualização resumida de indicadores relevantes para apoio à gestão.'),
('funcionalidade_titulo_8',  'Alertas'),
('funcionalidade_texto_8',   'Receba alertas sobre garantias a expirar e outras situações relevantes.'),
('contactos_titulo',         'Contactos'),
('contactos_texto',          'Entre em contacto connosco para esclarecer dúvidas sobre a MediVault ou obter mais informações sobre a gestão do inventário hospitalar.'),
('localizacao',              'Travessa Encosta do Pilar, 9000-777, Funchal, Madeira'),
('horario',                  'Segunda a sexta-feira: 09h00 às 19h00; Sábados: 09h0 às 14h00; Domingos e Feriados: Encerrado'),
('email',                    'suporte@medivault.pt'),
('telefone',                 '+351 930 466 310');


SET FOREIGN_KEY_CHECKS = 1;