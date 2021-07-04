<div class="row">
    <div class="col">
        <h1>Cadastro</h1>
    </div>
</div>

<div class="row">
    <?php
    $attributes = array('id' => 'cadastro');
    echo form_open('home/cadastrar');
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
            <label for="nome">Nome</label>
        </div>
        <div class="input-field col s12">
            <?php
            $data = array(
                'id' => 'sobrenome',
                'name' => 'sobrenome',
                'type' => 'text',
                'class' => 'validate',
                'value' => set_value('sobrenome'),
                'required' => 'required'
            );
            echo form_input($data);
            ?>
            <label for="sobrenome">Sobrenome</label>
        </div>
        <div class="input-field col s12">
            <?php
            $data = array(
                'id' => 'e-mail',
                'name' => 'e-mail',
                'type' => 'email',
                'class' => 'validate',
                'value' => set_value('e-mail'),
                'required' => 'required'
            );
            echo form_input($data);
            ?>
            <label for="e-mail">E-mail</label>
        </div>
        <div class="input-field col s12">
            <?php
            $data = array(
                'id' => 'senha',
                'name' => 'senha',
                'type' => 'password',
                'class' => 'validate',
                'value' => set_value('senha'),
                'required' => 'required'
            );
            echo form_input($data);
            ?>
            <label for="senha">Senha</label>
        </div>
        <div class="input-field col s12">
            <button class="btn waves-effect waves-light primario" type="submit" name="entrar">
                Entrar
            </button>
            <button class="btn waves-effect waves-light secundario" type="button" name="cancelar" onclick="window.location.href='<?php echo site_url(); ?>'">
                Cancelar
            </button>
        </div>
    </div>
    <?php
    echo form_close();
    ?>
</div>