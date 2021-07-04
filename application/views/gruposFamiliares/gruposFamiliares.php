<div class="row">
    <div class="col">
        <h2>Meus grupos familiares</h2>
    </div>
</div>
<div class="row">
    <div class="col s12">
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

<div class="fixed-action-btn">
    <a class="btn-floating btn-large">
        <i class="large material-icons">add</i>
    </a>
    <ul>
        <li><a class="btn-floating tooltipped modal-trigger" href="#modalNovoGrupo" data-position="left" data-tooltip="Criar um novo grupo"><i class="material-icons">group_add</i></a></li>
        <li><a class="btn-floating tooltipped" href="#!" data-position="left" data-tooltip="Procurar grupo"><i class="material-icons">search</i></a></li>
    </ul>
</div>

<div id="modalNovoGrupo" class="modal">
    <?php
    $attributes = array('id' => 'login');
    echo form_open('gruposFamiliares/criar');
    ?>
    <div class="modal-content">
        <h4>Criar grupo</h4>
        <div class="row">
            <?php
            $attributes = array('id' => 'grupo');
            echo form_open('gruposFamiliares/criar');
            ?>
            <div class="row">
                <div class="input-field col s12">
                    <?php
                    $data = array(
                        'id' => 'nome',
                        'name' => 'nome',
                        'type' => 'text',
                        'class' => 'validate',
                        'value' => set_value('nome'),
                        'required' => 'required'
                    );
                    echo form_input($data);
                    ?>
                    <label for="nome">Nome do grupo</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn waves-effect waves-light primario" type="submit" name="Criar">
            Criar
        </button>
        <button class="btn waves-effect waves-light modal-close secundario" type="button" name="cancelar">
            Cancelar
        </button>
    </div>
    <?php
    echo form_close();
    ?>
</div>