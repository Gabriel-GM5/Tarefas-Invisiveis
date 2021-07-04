<div class="row">
    <div class="col">
        <h2><?php echo htmlspecialchars($grupo_info->nome); ?></h2>
    </div>
</div>

<div class="row">
    <div class="col s12 m6 l4">
        <h4>Tarefas pendentes <a class="btn-floating waves-effect waves-light tooltipped modal-trigger" href="#modalTarefa" data-position="bottom" data-tooltip="Cadastrar nova tarefa!"><i class="material-icons">add</i></a></h4>
        <?php
        if ($tarefas_grupo) {
        ?>
            <div class="collection scroll">
                <?php
                foreach ($tarefas_grupo as $tarefa) {
                    if ($tarefa->estados_tarefa_id == 1) {
                ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle">group</i>
                            <span class="title"><?php echo htmlspecialchars($tarefa->titulo); ?></span>
                            <p>
                                ID: <?php echo htmlspecialchars($tarefa->id); ?>
                                <br>
                                Descrição: <?php echo htmlspecialchars($tarefa->descricao); ?>
                                <br>
                                Para: <?php echo date("d/m/Y - H:i", strtotime($tarefa->data_hora_criacao)); ?>
                                <?php
                                foreach ($membros_grupo as $membro) {
                                    $checked = '';
                                    foreach ($membros_tarefas as $m) {
                                        foreach ($m as $m2) {
                                            if ($m2->tarefas_id == $tarefa->id && $m2->users_id == $membro->id) {
                                                echo '<p> - ' . htmlspecialchars($membro->first_name . ' ' . $membro->last_name) . '</p>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </p>
                            <div class="secondary-content">
                                <button data-target="modal_tarefa_<?php echo htmlspecialchars($tarefa->id); ?>" class="modal-trigger btn btn-flat tooltipped" data-tooltip="Designar Membro!"><i class="material-icons">person_outline</i></button>
                                <br>
                                <button data-target="modal_editar_tarefa_<?php echo htmlspecialchars($tarefa->id); ?>" class="modal-trigger btn btn-flat tooltipped" data-tooltip="Editar tarefa!"><i class="material-icons">edit</i></button>
                                <?php
                                foreach ($membros_grupo as $membro) {
                                    $checked = '';
                                    foreach ($membros_tarefas as $m) {
                                        foreach ($m as $m2) {
                                            if ($m2->tarefas_id == $tarefa->id && $m2->users_id == $membro->id && $m2->users_id == $this->ion_auth->user()->row()->id) {
                                ?>
                                                <br>
                                                <button class="btn tooltipped" data-tooltip="Resgistrar conclusão!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/registrar_conclusao/' . $grupo_info->id . '/' . $tarefa->id) ?>'"><i class="material-icons">check</i></button>
                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </li>
                        <div id="modal_tarefa_<?php echo htmlspecialchars($tarefa->id); ?>" class="modal">
                            <div class="modal-content">
                                <h4><?php echo htmlspecialchars($tarefa->titulo); ?></h4>
                                <p><?php echo htmlspecialchars($tarefa->descricao); ?></p>
                                <?php
                                $attributes = array('id' => 'tarefa');
                                $hidden = array('grupo_id' => htmlspecialchars($grupo_info->id), 'tarefa_id' => $tarefa->id);
                                echo form_open('gruposFamiliares/vincularMembroTarefa', $attributes, $hidden);
                                ?>
                                <div class="row">
                                    <h6>Membros:</h6>
                                    <div class="input-field col s12">
                                        <?php
                                        foreach ($membros_grupo as $membro) {
                                            $checked = '';
                                            foreach ($membros_tarefas as $m) {
                                                foreach ($m as $m2) {
                                                    if ($m2->tarefas_id == $tarefa->id && $m2->users_id == $membro->id) {
                                                        $checked = 'checked="checked"';
                                                    }
                                                }
                                            }
                                        ?>
                                            <p><label><input id="membros_grupo[]" name="membros_grupo[]" <?php echo htmlspecialchars($checked); ?> value="<?php echo htmlspecialchars($membro->id); ?>" type="checkbox" /><span><?php echo htmlspecialchars($membro->first_name . ' ' . $membro->last_name) ?></span></label></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn waves-effect waves-light primario" type="submit" name="designar">
                                    Designar
                                </button>
                                <button class="btn waves-effect waves-light modal-close secundario" type="button" name="cancelar">
                                    Cancelar
                                </button>
                            </div>
                            <?php
                            echo form_close();
                            ?>
                        </div>
                        <div id="modal_editar_tarefa_<?php echo htmlspecialchars($tarefa->id); ?>" class="modal">
                            <div class="modal-content">
                                <h4>Editar Tarefa <?php echo htmlspecialchars($tarefa->id); ?></h4>
                                <div class="row">
                                    <?php
                                    $attributes = array('id' => 'tarefa');
                                    $hidden = array('grupo_id' => htmlspecialchars($grupo_info->id), 'tarefa_id' => htmlspecialchars($tarefa->id));
                                    echo form_open('gruposFamiliares/editar_tarefa', $attributes, $hidden);
                                    ?>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <?php
                                            $data = array(
                                                'id' => 'titulo',
                                                'name' => 'titulo',
                                                'type' => 'text',
                                                'class' => 'validate',
                                                'value' => $tarefa->titulo,
                                                'required' => 'required'
                                            );
                                            echo form_input($data);
                                            ?>
                                            <label for="titulo">Título</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <?php
                                            $data = array(
                                                'id' => 'descricao',
                                                'name' => 'descricao',
                                                'type' => 'text',
                                                'class' => 'validate materialize-textarea',
                                                'value' => $tarefa->descricao,
                                            );
                                            echo form_textarea($data);
                                            ?>
                                            <label for="descricao">Descrição</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <?php
                                            $data = array(
                                                'id' => 'dataHora',
                                                'name' => 'dataHora',
                                                'type' => 'text',
                                                'class' => 'validate dataHora',
                                                'value' => date("H:i", strtotime($tarefa->data_hora_criacao)) . ' de ' . date("d/m/Y", strtotime($tarefa->data_hora_criacao)),
                                                'required' => 'required'
                                            );
                                            echo form_input($data);
                                            ?>
                                            <label for="dataHora">Data e Hora</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <select name='prioridade' id='prioridade' class="validate" required>
                                                <option value="" disabled selected>Selecione a prioridade</option>
                                                <?php
                                                foreach ($prioridades as $prioridade) {
                                                    if ($tarefa->prioridades_tarefa_id == $prioridade->id) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                ?>
                                                    <option <?php echo $selected ?> value="<?php echo htmlspecialchars($prioridade->id); ?>"><?php echo htmlspecialchars($prioridade->descricao); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <label for="prioridade">Prioridade da tarefa</label>
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
                <?php
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col s12 m6 l4">
        <h4>Tarefas concluídas</h4>
        <?php
        if ($tarefas_grupo) {
        ?>
            <div class="collection scroll">
                <?php
                foreach ($tarefas_grupo as $tarefa) {
                    if ($tarefa->estados_tarefa_id == 2) {
                ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle">group</i>
                            <span class="title"><?php echo htmlspecialchars($tarefa->titulo); ?></span>
                            <p>
                                ID: <?php echo htmlspecialchars($tarefa->id); ?>
                                <br>
                                Descrição: <?php echo htmlspecialchars($tarefa->descricao); ?>
                                <br>
                                Para: <?php echo date("d/m/Y - H:i", strtotime($tarefa->data_hora_criacao)); ?>
                                <br>
                                Entregue: <?php echo date("d/m/Y - H:i", strtotime($tarefa->data_hora_conclusão)); ?>
                                <?php
                                foreach ($membros_grupo as $membro) {
                                    $checked = '';
                                    foreach ($membros_tarefas as $m) {
                                        foreach ($m as $m2) {
                                            if ($m2->tarefas_id == $tarefa->id && $m2->users_id == $membro->id) {
                                                echo '<p> - ' . htmlspecialchars($membro->first_name . ' ' . $membro->last_name) . '</p>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </p>
                            <div class="secondary-content">
                                <button class="btn btn-flat tooltipped" data-tooltip="Retificar!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/retificar_conclusao/' . $grupo_info->id . '/' . $tarefa->id) ?>'"><i class="material-icons">undo</i></button>
                            </div>
                        </li>
                <?php
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col s12 m6 l4">
        <h4>Membros <a class="btn-floating waves-effect waves-light tooltipped modal-trigger" href="#modal_novo_membro" data-position="bottom" data-tooltip="Novo membro!"><i class="material-icons">add</i></a></h4>
        <?php
        if ($membros_grupo) {
        ?>
            <div class="collection scroll">
                <?php
                foreach ($membros_grupo as $membro) {
                ?>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">person</i>
                        <span class="title"><?php echo htmlspecialchars($membro->first_name . ' ' . $membro->last_name) ?></span>
                        <p>
                            ID: <?php echo htmlspecialchars($membro->id); ?>
                            <br>
                            E-mail: <?php echo htmlspecialchars($membro->email); ?>
                        </p>
                        <?php
                        if ($membro->ativo) {
                        ?>
                            <button class="secondary-content btn btn-flat tooltipped" data-tooltip="Desativar membro!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/desativar_membro/' . $grupo_info->id . '/' . $membro->usr_gf_id) ?>'"><i class="material-icons">visibility_off</i></button>
                        <?php
                        } else {
                        ?>
                            <button class="secondary-content btn btn-flat tooltipped" data-tooltip="Ativar membro!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/ativar_membro/' . $grupo_info->id . '/' . $membro->usr_gf_id) ?>'"><i class="material-icons">visibility</i></button>
                        <?php
                        }
                        ?>
                    </li>
                <?php
                }
                ?>
                <?php
                foreach ($membros_desativos as $membro) {
                ?>
                    <li class="collection-item avatar">
                        <i class="material-icons circle">person</i>
                        <span class="title"><?php echo htmlspecialchars($membro->first_name . ' ' . $membro->last_name) ?></span>
                        <p>
                            ID: <?php echo htmlspecialchars($membro->id); ?>
                            <br>
                            E-mail: <?php echo htmlspecialchars($membro->email); ?>
                        </p>
                        <?php
                        if ($membro->ativo) {
                        ?>
                            <button class="secondary-content btn btn-flat tooltipped" data-tooltip="Desativar membro!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/desativar_membro/' . $grupo_info->id . '/' . $membro->usr_gf_id) ?>'"><i class="material-icons">visibility_off</i></button>
                        <?php
                        } else {
                        ?>
                            <button class="secondary-content btn btn-flat tooltipped" data-tooltip="Ativar membro!" onclick="window.location.href='<?php echo site_url('GruposFamiliares/ativar_membro/' . $grupo_info->id . '/' . $membro->usr_gf_id) ?>'"><i class="material-icons">visibility</i></button>
                        <?php
                        }
                        ?>
                    </li>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="modalTarefa" class="modal">
    <div class="modal-content">
        <h4>Criar Tarefa</h4>
        <div class="row">
            <?php
            $attributes = array('id' => 'tarefa');
            $hidden = array('grupo_id' => htmlspecialchars($grupo_info->id));
            echo form_open('gruposFamiliares/novaTarefa', $attributes, $hidden);
            ?>
            <div class="row">
                <div class="input-field col s12">
                    <?php
                    $data = array(
                        'id' => 'titulo',
                        'name' => 'titulo',
                        'type' => 'text',
                        'class' => 'validate',
                        'value' => set_value('titulo'),
                        'required' => 'required'
                    );
                    echo form_input($data);
                    ?>
                    <label for="titulo">Título</label>
                </div>
                <div class="input-field col s12">
                    <?php
                    $data = array(
                        'id' => 'descricao',
                        'name' => 'descricao',
                        'type' => 'text',
                        'class' => 'validate materialize-textarea',
                        'value' => set_value('descricao'),
                    );
                    echo form_textarea($data);
                    ?>
                    <label for="descricao">Descrição</label>
                </div>
                <div class="input-field col s12">
                    <?php
                    $data = array(
                        'id' => 'dataHora',
                        'name' => 'dataHora',
                        'type' => 'text',
                        'class' => 'validate dataHora',
                        'value' => set_value('dataHora'),
                        'required' => 'required'
                    );
                    echo form_input($data);
                    ?>
                    <label for="dataHora">Data e Hora</label>
                </div>
                <div class="input-field col s12">
                    <select name='prioridade' id='prioridade' class="validate" required>
                        <option value="" disabled selected>Selecione a prioridade</option>
                        <?php
                        foreach ($prioridades as $prioridade) {
                        ?>
                            <option value="<?php echo htmlspecialchars($prioridade->id); ?>"><?php echo htmlspecialchars($prioridade->descricao); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="prioridade">Prioridade da tarefa</label>
                </div>
                <div class="adicionavel">
                    <button class="btn waves-effect waves-light primario designar" type="button" name="designar">
                        Designar
                    </button>
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

<div id="modal_novo_membro" class="modal">
    <div class="modal-content">
        <h4>Adicionar Membro</h4>
        <div class="row">
            <?php
            $attributes = array('id' => 'tarefa');
            $hidden = array('grupo_id' => htmlspecialchars($grupo_info->id));
            echo form_open('gruposFamiliares/novo_membro', $attributes, $hidden);
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
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn waves-effect waves-light primario" type="submit" name="Adicionar">
            Adicionar
        </button>
        <button class="btn waves-effect waves-light modal-close secundario" type="button" name="cancelar">
            Cancelar
        </button>
    </div>
    <?php
    echo form_close();
    ?>
</div>