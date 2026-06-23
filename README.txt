================================================================================
  MEDIVAULT — Sistema Web de Apoio ao Inventário Hospitalar de Equipamentos Médicos
  Unidade Curricular: Sistemas de Informação e Bases de Dados Aplicados à Saúde
  LEBIOM | ISEP | 2025-2026
================================================================================

IDENTIFICAÇÃO
--------------------------------------------------------------------------------
Nome do Projeto   : MediVault
Nome do Estudante : Joana Rodrigues
Número do Estudante: 1241466


DESCRIÇÃO DA APLICAÇÃO
--------------------------------------------------------------------------------
O MediVault é uma aplicação web desenvolvida para simular um sistema de gestão
do inventário hospitalar de equipamentos médicos. A aplicação permite registar,
consultar, editar e remover equipamentos médicos, fornecedores, localizações e
documentação técnica associada, incluindo gestão de garantias e contratos de
manutenção.

O sistema é composto por duas áreas distintas:
  - Área Pública  : website institucional da empresa de software (Front Office),
                    acessível sem autenticação, com conteúdos editáveis.
  - Área Privada  : sistema de gestão do inventário (Back Office), acessível
                    apenas após autenticação, com painel de controlo (dashboard),
                    CRUD de equipamentos, fornecedores e localizações, exportação
                    de dados, geração de QR codes e muito mais.


ESTRUTURA DE DIRETORIAS
--------------------------------------------------------------------------------
medivault/
├── public/                   Área pública (index.php, logout.php)
├── private/                  Área privada (protegida por autenticação)
│   ├── home.php              Página inicial após login
│   ├── iniciar_sessao.php    Página de login
│   ├── processa_iniciar_sessao.php
│   ├── includes/             Componentes reutilizáveis (header, footer, navbar,
│   │                         menu, funcoes.php, validacoes.php)
│   ├── logs/                 Ficheiros de log (autenticacao.log, erros.log)
│   └── views/
│       ├── dashboard/        Painel de indicadores e gráficos
│       ├── equipamentos/     CRUD + exportação + ficha PDF + QR code
│       ├── fornecedores/     CRUD + exportação
│       ├── localizacoes/     CRUD + exportação
│       ├── gestao_conteudos/ Gestão dos conteúdos da área pública
│       ├── mensagens/        Mensagens de contacto recebidas do site público
│       └── utilizador/       Alteração de password
├── config/
│   └── config.php            Configuração da aplicação e da base de dados
├── assets/
│   ├── css/1241466.css       Folha de estilos personalizada
│   ├── js/1241466.js         Scripts JavaScript
│   ├── js/chart.umd.min.js   Chart.js para gráficos do dashboard
│   ├── js/qrcode.min.js      Geração de QR codes
│   ├── bootstrap/            Bootstrap 5 (local)
│   ├── datatables/           DataTables para tabelas interativas
│   ├── jquery/               jQuery
│   └── imagens/              Logótipo e imagens da aplicação
├── base_dados/
│   ├── modelo_bd.sql         Script DDL (criação de todas as tabelas)
│   ├── inserts_bd.sql        Dados de teste para demonstração
│   └── modelo_bd.dbml        Modelo relacional em DBML
├── uploads/
│   ├── documentacao_equipamentos/  Documentos associados a equipamentos
│   └── documentacao_fornecedores/  Documentos associados a fornecedores
└── README.txt                Este ficheiro


TECNOLOGIAS UTILIZADAS
--------------------------------------------------------------------------------
  Frontend  : HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, Chart.js, DataTables
  Backend   : PHP 8
  Base de dados: MySQL (acesso via PDO)
  Extras    : QR Code (qrcode.min.js), encriptação AES (OpenSSL + MySQL AES)


INSTALAÇÃO E EXECUÇÃO
--------------------------------------------------------------------------------
Requisitos:
  - Servidor local com PHP 8 e MySQL:
      Windows : Laragon (recomendado)
      macOS   : MAMP
  - Browser atualizado (Chrome, Firefox, Edge)

Passos:

1. Copiar a pasta do projeto para o diretório correto:

     Windows (Laragon):
       Pasta : C:\laragon\www\sibdas\1241466\medivault\
       URL   : http://127.0.0.1/sibdas/1241466/medivault/
       (ou http://localhost/sibdas/1241466/medivault/ com Laragon em modo Pretty URLs desativado)

     macOS (MAMP):
       Pasta : /Applications/MAMP/htdocs/sibdas/1241466/medivault/
       URL   : http://127.0.0.1/sibdas/1241466/medivault/
       (MAMP configurado com porta 80 — confirmar em MAMP > Preferências > Portas)

2. Importar a base de dados:
     A base de dados foi desenvolvida com DBeaver, ligada ao servidor das aulas.
     A base de dados já existia no servidor — não foi necessário criá-la manualmente.

     Servidor de BD utilizado:
       Host          : vsgate-s1.dei.isep.ipp.pt
       Porta         : 10464
       Base de dados : db1241466
       Utilizador    : 1241466

     Para recriar a base de dados localmente:
     a. Abrir o DBeaver e ligar ao servidor MySQL local
     b. Selecionar a base de dados de destino
     c. Clicar com o botão direito > Tools > Execute Script
     d. Executar primeiro: base_dados/modelo_bd.sql  (cria todas as tabelas)
     e. Executar depois : base_dados/inserts_bd.sql  (insere os dados de teste)

3. Verificar a configuração em config/config.php:
     - BASE_URL deve ser '/sibdas/1241466/medivault'
     - Ajustar credenciais MySQL se necessário

4. Aceder à aplicação:
     Área pública : http://127.0.0.1/sibdas/1241466/medivault/public/
     Login        : http://127.0.0.1/sibdas/1241466/medivault/private/iniciar_sessao.php


CREDENCIAIS DE ACESSO
--------------------------------------------------------------------------------
Perfil Administrador (acesso total — CRUD, exportações, gestão de conteúdos):
  Email    : admin@medivault.pt
  Password : Admin#2025!

Perfil Técnico (acesso a CRUD e exportações, sem gestão de utilizadores):
  Email    : tecnico@medivault.pt
  Password : Agente#2025!

Perfil Profissional de Saúde (apenas consulta — sem criação/edição/remoção):
  Email    : profissional_saude@medivault.pt
  Password : Saude#2025!


INSTRUÇÕES PARA TESTES PRINCIPAIS
--------------------------------------------------------------------------------

1. LOGIN
   - Aceder a: private/iniciar_sessao.php
   - As credenciais de teste encontram-se indicadas na secção
"CREDENCIAIS DE ACESSO" deste ficheiro e devem ser introduzidas manualmente.

2. DASHBOARD
   - Após login, o dashboard apresenta indicadores globais do inventário:
     total de equipamentos, equipamentos ativos/em manutenção/inativos,
     garantias expiradas, equipamentos sem documentação, distribuição por
     serviço e por categoria (gráficos Chart.js), equipamentos de criticidade
     elevada e garantias a expirar nos próximos 30 dias.

3. EQUIPAMENTOS (CRUD completo)
   - Listar equipamentos com DataTables (pesquisa, ordenação, paginação)
   - Adicionar novo equipamento com separadores (Identificação, Aquisição,
     Garantia, Contrato, Fornecedor, Localização, Acessórios e Consumíveis)
   - Consultar ficha detalhada de cada equipamento
   - Editar dados do equipamento
   - Remover (soft delete com confirmação)
   - Reativar equipamentos desativados
   - Exportar para CSV, JSON e PDF
   - Gerar e descarregar ficha PDF individual de cada equipamento
   - Visualizar QR code do equipamento na ficha detalhada

4. FORNECEDORES (CRUD completo — Administrador e Técnico)
   - Listar, adicionar, editar, remover e reativar fornecedores
   - Associar fornecedores a equipamentos
   - Exportar para CSV, JSON e PDF

5. LOCALIZAÇÕES (CRUD completo)
   - Gerir localizações hospitalares (edifício, piso, serviço, sala)
   - Exportar para CSV, JSON e PDF

6. GESTÃO DE CONTEÚDOS (Área Pública — apenas Administrador)
   - Menu: Gestão de Conteúdos
   - Permite editar os textos apresentados na área pública (sobre, missão,
     funcionalidades, contactos) sem tocar no HTML

7. MENSAGENS DE CONTACTO (apenas Administrador — acessível via navbar)
   - Ícone de mensagens na barra de navegação superior
   - Visualizar e gerir mensagens enviadas através do formulário de contacto
     do site público; marcar como lidas

8. ALTERAÇÃO DE PASSWORD
   - Menu: Utilizador > Alterar Password
   - Permite alterar a password do utilizador autenticado

9. ÁREA PÚBLICA
   - Aceder a: public/index.php
   - Apresenta o website institucional da MediVault com navegação por âncoras
     (Home, Sobre, Funcionalidades, Contacto); conteúdos editáveis pela
     área privada; formulário de contacto funcional

10. LOGOUT
    - Disponível via public/logout.php
    - O menu lateral tem um botão "Sair" que redireciona para a área pública
    - Destrói a sessão e redireciona para o login


SEGURANÇA IMPLEMENTADA
--------------------------------------------------------------------------------
- Passwords armazenadas com password_hash() (bcrypt)
- Gestão de sessões autenticadas
- Restrição de acesso por perfis de utilizador
- Proteção das páginas privadas
- Registo automático de logs
- Encriptação AES dos emails dos utilizadores
- Proteção dos ficheiros de log através de .htaccess


NOTAS ADICIONAIS
--------------------------------------------------------------------------------
- O ficheiro base_dados/inserts_bd.sql inclui 30 equipamentos, 9 fornecedores,
  12 localizações e respetiva documentação para demonstração completa.
- Os ficheiros de log são gerados automaticamente em private/logs/ e protegidos
  por .htaccess.
- A pasta uploads/ contém os documentos PDF de demonstração associados a
  equipamentos e fornecedores.
- A aplicação usa AES_ENCRYPT/AES_DECRYPT do MySQL para encriptação dos emails
  dos utilizadores e password_hash() (bcrypt) para as passwords.
- Em caso de erro de ligação à base de dados, verificar as credenciais
  em config/config.php.

================================================================================