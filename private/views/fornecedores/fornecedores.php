<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal da área privada -->
    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Fornecedores</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="novo_fornecedor.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Novo fornecedor
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre os fornecedores associados aos equipamentos médicos do inventário
            hospitalar.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaFornecedores" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por código, nome da empresa, NIF, contacto telefónico, email, morada, website, pessoa de contacto ou tipo de fornecedor...">
                    <button type="button" id="botaoPesquisarFornecedores" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaFornecedores"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroTipoFornecedor">
                            Tipo de fornecedor
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroTipoFornecedor" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                                <option value="Fabricante">
                                    Fabricante
                                </option>

                                <option value="Distribuidor ou Fornecedor comercial">
                                    Distribuidor ou Fornecedor comercial
                                </option>

                                <option value="Empresa de assistência técnica">
                                    Empresa de assistência técnica
                                </option>

                                <option value="Fornecedor de consumíveis ou acessórios">
                                    Fornecedor de consumíveis ou acessórios
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroNomeEmpresa">
                            Nome da empresa
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroNomeEmpresa" class="campo-filtro-equipamentos">

                                <option value="">Todas</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroMoradaFornecedor">
                            Morada
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroMoradaFornecedor" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                                <option value="Aveiro">Aveiro, Portugal</option>
                                <option value="Beja">Beja, Portugal</option>
                                <option value="Braga">Braga, Portugal</option>
                                <option value="Bragança">Bragança, Portugal</option>
                                <option value="Castelo Branco">Castelo Branco, Portugal</option>
                                <option value="Coimbra">Coimbra, Portugal</option>
                                <option value="Évora">Évora, Portugal</option>
                                <option value="Faro">Faro, Portugal</option>
                                <option value="Guarda">Guarda, Portugal</option>
                                <option value="Leiria">Leiria, Portugal</option>
                                <option value="Lisboa">Lisboa, Portugal</option>
                                <option value="Portalegre">Portalegre, Portugal</option>
                                <option value="Porto">Porto, Portugal</option>
                                <option value="Santarém">Santarém, Portugal</option>
                                <option value="Setúbal">Setúbal, Portugal</option>
                                <option value="Viana do Castelo">Viana do Castelo, Portugal</option>
                                <option value="Vila Real">Vila Real, Portugal</option>
                                <option value="Viseu">Viseu, Portugal</option>
                                <option value="Região Autónoma dos Açores">Região Autónoma dos Açores, Portugal
                                </option>
                                <option value="Região Autónoma da Madeira">Região Autónoma da Madeira, Portugal
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroPessoaContacto">
                            Pessoa de contacto
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroPessoaContacto" class="campo-filtro-equipamentos">

                                <option value="">Todas</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEquipamentoFornecedor">
                            Equipamento associado
                        </label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroEquipamentoFornecedor" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">
                        <label>&nbsp;</label>
                        <button type="button" id="botaoLimparApenasFiltrosFornecedores"
                            class="botao-limpar-apenas-filtros" title="Limpar filtros">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>

                </div>
            </div>

        </section>

        <div class="acao-exportar-tabela">
            <a href="#" class="link-exportar-excel">
                <i class="fa-solid fa-file-excel"></i>
                Exportar Listagem dos Fornecedores
            </a>
        </div>

        <div class="tabela-privada">
            <table>
                <thead>
                    <tr>
                        <th>Nome da empresa</th>
                        <th>Tipo de fornecedor</th>
                        <th>Pessoa de contacto</th>
                        <th>Telefone de contacto</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody id="tabela-fornecedores">

                </tbody>
            </table>
        </div>

    </main>

</div>

<!-- Modal eliminar fornecedor -->
<div class="modal fade" id="modalEliminarFornecedor" tabindex="-1" aria-labelledby="tituloModalEliminarFornecedor"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarFornecedor">

                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p id="textoModalEliminarFornecedor">
                    Tem a certeza que pretende eliminar este fornecedor?
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoFornecedor()">

                    Eliminar

                </button>

            </div>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>