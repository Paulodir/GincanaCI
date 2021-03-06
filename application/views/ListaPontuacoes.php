<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->config->base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Pontuações por Prova</li>
        </ol>
    </nav> 
    <?= ($this->session->flashdata('retorno')) ? $this->session->flashdata('retorno') : ''; ?>
    <?= validation_errors(); ?>
    <div class="table-responsive">
        <table class="table table-striped">        
            <thead class="thead-dark">
                <tr>
                    <th>Equipe</th>
                    <th>Prova</th>
                    <th>Supervisor de Prova</th>
                    <th>Pontos</th>
                    <th>Data e Hora</th>
                    <th>Ações</th>
                </tr>
            </thead>        
            <tbody>
                <?php
                if (count($pontuacoes) > 0) {
                    foreach ($pontuacoes as $p) {
                        echo '<tr>';
                        echo '<td>' . $p->equipe . '</td>';
                        echo '<td>' . $p->prova . '</td>';
                        echo '<td>' . $p->usuario . '</td>';
                        echo '<td>' . $p->pontos . '</td>';
                        if (($p->data_hora) === '0000-00-00 00:00:00') {
                            echo '<td>Não informada</td>';
                        } else {
                            echo '<td>' . $p->datahora . '</td>';
                        }
                        echo '<td>'
                        . '<a href="' . $this->config->base_url() . 'Pontuacao/alterar/' . $p->id . '" class="btn btn-sm btn-outline-secondary mr-2" ><i class="fas fa-pencil-alt"></i> Alterar</a>'
                        . '<a href="' . $this->config->base_url() . 'Pontuacao/deletar/' . $p->id . '" class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i> Deletar</a>'
                        . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Nenhuma Pontuação foi atribuída até o momento.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>