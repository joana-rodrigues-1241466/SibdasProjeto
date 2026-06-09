<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal da área privada -->
    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Equipamentos</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="novo_equipamento.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Novo equipamento
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre os equipamentos médicos registados no inventário hospitalar.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaEquipamentos" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por código, designação, marca, modelo, n.º de série, fornecedor ou localização...">

                    <button type="button" id="botaoPesquisarEquipamentos" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaEquipamentos"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEstadoEquipamento">
                            Estado atual
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
       <strong>Ativo</strong> - Equipamento operacional e disponível para utilização.<br><br>
       <strong>Em manutenção</strong> - Equipamento temporariamente indisponível devido a manutenção preventiva ou corretiva.<br><br>
       <strong>Inativo</strong> - Equipamento sem utilização atual, mas disponível para voltar ao serviço.<br><br>
       <strong>Em calibração</strong> - Equipamento em processo de calibração ou verificação metrológica.<br><br>
       <strong>Em quarentena</strong> - Equipamento isolado temporariamente para avaliação, descontaminação ou validação técnica.<br><br>
       <strong>Abatido</strong> - Equipamento retirado definitivamente de serviço e sem possibilidade de utilização.
       ">
                            </i>
                        </label>

                        <div class="select-filtro-wrapper">
                            <select id="filtroEstadoEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <option value="Ativo">Ativo</option>
                                <option value="Em manutenção">Em manutenção</option>
                                <option value="Inativo">Inativo</option>
                                <option value="Em calibração">Em calibração</option>
                                <option value="Em quarentena">Em quarentena</option>
                                <option value="Abatido">Abatido</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroFornecedorEquipamento">Fornecedor associado</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroFornecedorEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroLocalizacaoEquipamento">Localização associada</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroLocalizacaoEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroCategoriaEquipamento">Categoria
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
        <strong>Monitorização</strong> - Equipamentos utilizados para monitorizar parâmetros fisiológicos e o estado clínico do paciente.<br><br>
        <strong>Suporte de vida</strong> - Equipamentos essenciais para manter ou substituir funções vitais do organismo.<br><br>
        <strong>Terapia</strong> - Equipamentos utilizados na administração de tratamentos e intervenções terapêuticas.<br><br>
        <strong>Diagnóstico</strong> - Equipamentos destinados à deteção, avaliação e diagnóstico de condições clínicas.<br><br>
        <strong>Laboratório</strong> - Equipamentos utilizados na análise e processamento de amostras laboratoriais.<br><br>
        <strong>Esterilização</strong> - Equipamentos destinados à limpeza, desinfeção e esterilização de materiais e dispositivos médicos.<br><br>
        <strong>Reabilitação</strong> - Equipamentos utilizados na recuperação funcional e reabilitação dos pacientes.
        ">
                            </i>
                        </label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroCategoriaEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <option value="Monitorização">Monitorização</option>
                                <option value="Suporte de vida">Suporte de vida</option>
                                <option value="Terapia">Terapia</option>
                                <option value="Diagnóstico">Diagnóstico</option>
                                <option value="Laboratório">Laboratório</option>
                                <option value="Esterilização">Esterilização</option>
                                <option value="Reabilitação">Reabilitação</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroCriticidadeEquipamento">Criticidade
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
        <strong>Suporte de vida</strong> - Equipamento essencial para manter ou monitorizar funções vitais do paciente.<br><br>
        <strong>Alta</strong> - Equipamento cuja indisponibilidade afeta significativamente a prestação de cuidados de saúde.<br><br>
        <strong>Média</strong> - Equipamento importante, mas cuja indisponibilidade pode ser temporariamente compensada por alternativas.<br><br>
        <strong>Baixa</strong> - Equipamento de apoio com impacto reduzido na prestação de cuidados.
        ">
                            </i>
                        </label>

                        <div class="select-filtro-wrapper">
                            <select id="filtroCriticidadeEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <option value="Baixa">Baixa</option>
                                <option value="Média">Média</option>
                                <option value="Alta">Alta</option>
                                <option value="Suporte de vida">Suporte de vida</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">
                        <label>&nbsp;</label>
                        <button type="button" id="botaoLimparApenasFiltrosEquipamentos"
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
                Exportar Listagem dos Equipamentos
            </a>
        </div>

        <div class="tabela-privada">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Designação</th>
                        <th>Localização</th>
                        <th>Estado atual</th>
                        <th>Criticidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody id="tabela-equipamentos">

                </tbody>

            </table>

        </div>

    </main>

</div>

<!-- Modal eliminar equipamento -->
<div class="modal fade" id="modalEliminarEquipamento" tabindex="-1" aria-labelledby="tituloModalEliminarEquipamento"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarEquipamento">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <p id="textoModalEliminarEquipamento">
                    Tem a certeza que pretende eliminar este equipamento?
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoEquipamento()">
                    Eliminar
                </button>

            </div>

        </div>

    </div>

</div>

<?php include '../../includes/footer.php'; ?>