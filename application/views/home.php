<div class="row login">
    <div class="col s12 m6 l4 offset-m3 offset-l4">
        <div class="row">
            <div class="col s12">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <center>
                            <span class="card-title"><strong>Login</strong></span>
                            <?php
                            $attributes = array('id' => 'login');
                            echo form_open('home/login');
                            ?>
                            <div class="row">
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
                                </div>
                            </div>
                            <?php
                            echo form_close();
                            ?>
                            <div class="row">
                                <div class="col s6">
                                    <?php
                                    echo anchor('home/cadastro', 'Cadastrar', 'title="Cadastre-se!"');
                                    ?>
                                </div>
                                <div class="col s6">
                                    <?php
                                    echo anchor('#!', 'Recuperar Senha', 'title="Esqueci minha senha!"');
                                    ?>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>