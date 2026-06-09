<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal da área privada -->
    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Localizações</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="nova_localizacao.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Nova localização
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre as localizações físicas associadas aos equipamentos médicos.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaLocalizacoes" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por código da localização, edifício, piso, serviço/departamento ou sala/gabinete...">
                    <button type="button" id="botaoPesquisarLocalizacoes" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaLocalizacoes"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroEdificioLocalizacao">
                            Edifício
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroEdificioLocalizacao" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroServicoLocalizacao">
                            Serviço/Departamento
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroServicoLocalizacao" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroPisoLocalizacao">
                            Piso
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroPisoLocalizacao" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroSalaLocalizacao">
                            Sala/Gabinete
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroSalaLocalizacao" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEquipamentoLocalizacao">Equipamento associado</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroEquipamentoLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">

                        <label>&nbsp;</label>

                        <button type="button" id="botaoLimparApenasFiltrosLocalizacoes"
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
                Exportar Listagem das Localizações
            </a>
        </div>

        <div class="tabela-privada">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Edifício</th>
                        <th>Piso</th>
                        <th>Serviço/Departamento</th>
                        <th>Sala/Gabinete</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody id="tabela-localizacoes">
                    <tr>
                        <td>LOC001</td>
                        <td>Edifício Principal</td>
                        <td>Piso 2</td>
                        <td>Unidade de Cuidados Intensivos</td>
                        <td>Sala 2.10</td>
                        <td>Monitor multiparamétrico de sinais vitais</td>
                        <td class="acoes-tabela-privada">
                            <a href="consultar_localizacao.php?id=LOC001" class="acao-tabela-privada">
                                <i class="fa-regular fa-eye"></i>
                                Consultar
                            </a>

                            <a href="editar_localizacao.php?id=LOC001" class="acao-tabela-privada">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Editar
                            </a>

                            <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarLocalizacao"
                                onclick="prepararEliminacaoLocalizacao('LOC001')">
                                <i class="fa-regular fa-trash-can"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>LOC002</td>
                        <td>Edifício Principal</td>
                        <td>Piso 2</td>
                        <td>Unidade de Cuidados Intensivos</td>
                        <td>Sala 2.11</td>
                        <td>Ventilador pulmonar</td>
                        <td class="acoes-tabela-privada">
                            <a href="consultar_localizacao.php?id=LOC002" class="acao-tabela-privada">
                                <i class="fa-regular fa-eye"></i>
                                Consultar
                            </a>

                            <a href="editar_localizacao.php?id=LOC002" class="acao-tabela-privada">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Editar
                            </a>

                            <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarLocalizacao"
                                onclick="prepararEliminacaoLocalizacao('LOC002')">
                                <i class="fa-regular fa-trash-can"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>LOC003</td>
                        <td>Edifício B</td>
                        <td>Piso 0</td>
                        <td>Serviço de Medicina</td>
                        <td>Gabinete 0.04</td>
                        <td>Bomba de infusão</td>
                        <td class="acoes-tabela-privada">
                            <a href="consultar_localizacao.php?id=LOC003" class="acao-tabela-privada">
                                <i class="fa-regular fa-eye"></i>
                                Consultar
                            </a>

                            <a href="editar_localizacao.php?id=LOC003" class="acao-tabela-privada">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Editar
                            </a>

                            <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarLocalizacao"
                                onclick="prepararEliminacaoLocalizacao('LOC003')">
                                <i class="fa-regular fa-trash-can"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>LOC004</td>
                        <td>Edifício Principal</td>
                        <td>Piso 1</td>
                        <td>Urgência</td>
                        <td>Sala 1.02</td>
                        <td>Desfibrilhador</td>
                        <td class="acoes-tabela-privada">
                            <a href="consultar_localizacao.php?id=LOC004" class="acao-tabela-privada">
                                <i class="fa-regular fa-eye"></i>
                                Consultar
                            </a>

                            <a href="editar_localizacao.php?id=LOC004" class="acao-tabela-privada">
                                <i class="fa-regular fa-pen-to-square"></i>
                                Editar
                            </a>

                            <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal"
                                data-bs-target="#modalEliminarLocalizacao"
                                onclick="prepararEliminacaoLocalizacao('LOC004')">
                                <i class="fa-regular fa-trash-can"></i>
                                Eliminar
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </main>

</div>

<!-- Modal eliminar localização -->
<div class="modal fade" id="modalEliminarLocalizacao" tabindex="-1" aria-labelledby="tituloModalEliminarLocalizacao"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarLocalizacao">

                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p id="textoModalEliminarLocalizacao">
                    Tem a certeza que pretende eliminar esta localização?
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoLocalizacao()">

                    Eliminar

                </button>

            </div>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>