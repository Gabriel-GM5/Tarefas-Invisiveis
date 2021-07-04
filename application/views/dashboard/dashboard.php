<div class="row">
    <div class="col">
        <h3>Dashboard</h3>
    </div>
</div>

<div class="row">
    <div class="col s12 m12 l6">
        <h4>Tarefas Pendentes</h4>
        <?php
        if ($tarefas) {
        ?>
            <div class="collection scroll">
                <?php
                foreach ($tarefas as $tarefa) {
                ?>
                    <a class="collection-item avatar" href="<?php echo site_url('gruposFamiliares/grupo/' . $tarefa->grupos_familiares_id) ?>">
                        <i class="material-icons circle">group</i>
                        <span class="title"><?php echo htmlspecialchars($tarefa->titulo); ?></span>
                        <p>
                            ID: <?php echo htmlspecialchars($tarefa->id); ?>
                            <br>
                            Descrição: <?php echo htmlspecialchars($tarefa->descricao); ?>
                            <br>
                            Para: <?php echo date("d/m/Y - H:i", strtotime($tarefa->data_hora_criacao)); ?>
                            <br>
                            Grupo: <?php echo htmlspecialchars($tarefa->nome_grupo_familiar); ?>
                        </p>
                    </a>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <center>
                <h5>Nenhum grupo para exibir!</h5>
            </center>
        <?php
        }
        ?>
    </div>
    <div class="col s12 m12 l6">
        <h4>Grupos Familiares</h4>
        <?php
        if ($grupos) {
        ?>
            <div class="collection scroll">
                <?php
                foreach ($grupos as $grupo) {
                ?>
                    <a class="collection-item avatar" href="<?php echo site_url('gruposFamiliares/grupo/' . $grupo->id) ?>">
                        <i class="material-icons circle">group</i>
                        <span class="title"><?php echo htmlspecialchars($grupo->nome) ?></span>
                        <p>ID: <?php echo htmlspecialchars($grupo->id) ?></p>
                    </a>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <center>
                <h5>Nenhum grupo para exibir!</h5>
            </center>
        <?php
        }
        ?>
    </div>
</div>