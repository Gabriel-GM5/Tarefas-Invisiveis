<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GruposFamiliares_Model extends CI_Model
{
    public function getGruposFamiliares($userID = null)
    {
        if ($userID) {
            $this->db->from('grupos_familiares');
            $this->db->select('grupos_familiares.id, grupos_familiares.nome');
            $this->db->join('users_x_grupos_familiares', 'users_x_grupos_familiares.grupo_familiar_id = grupos_familiares.id', 'left');
            $this->db->where('users_x_grupos_familiares.user_id', $userID);
            $this->db->where('users_x_grupos_familiares.ativo', 1);
            $res = $this->db->get()->result();
            return $res;
        } else {
            return false;
        }
    }

    public function getGrupoFamiliar($grupoID = null)
    {
        if ($grupoID) {
            $this->db->from('grupos_familiares');
            $this->db->select('grupos_familiares.id, grupos_familiares.nome');
            $this->db->join('users_x_grupos_familiares', 'users_x_grupos_familiares.grupo_familiar_id = grupos_familiares.id', 'left');
            $this->db->where('users_x_grupos_familiares.grupo_familiar_id', $grupoID);
            $this->db->limit('1');
            $res = $this->db->get()->row();
            return $res;
        } else {
            return false;
        }
    }

    public function setGrupoFamiliar($nome)
    {
        if ($nome) {
            $this->db->set('nome', $nome);
            $this->db->insert('grupos_familiares');
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function vincular_usuario_grupo($userID = null, $groupID = null)
    {
        if ($userID && $groupID) {
            $this->db->set('user_id', $userID);
            $this->db->set('grupo_familiar_id', $groupID);
            return $this->db->insert('users_x_grupos_familiares');
        } else {
            return false;
        }
    }

    public function getTarefasGrupo($groupID = null)
    {
        if ($groupID) {
            $this->db->select('tarefas.*, prioridades_tarefa.descricao as prioridade, estados_tarefa.descricao as estado');
            $this->db->from('tarefas');
            $this->db->join('prioridades_tarefa', 'prioridades_tarefa.id = tarefas.prioridades_tarefa_id', 'left');
            $this->db->join('estados_tarefa', 'estados_tarefa.id = tarefas.estados_tarefa_id', 'left');
            $this->db->where('tarefas.grupos_familiares_id', $groupID);
            return $this->db->get()->result();
        } else {
            return false;
        }
    }

    public function getMembrosGrupo($idGrupo = null)
    {
        if ($idGrupo) {
            $this->db->select('users.id, users.first_name, users.last_name, users.email, users_x_grupos_familiares.id as usr_gf_id, users_x_grupos_familiares.ativo');
            $this->db->from('users');
            $this->db->join('users_x_grupos_familiares', 'users_x_grupos_familiares.user_id = users.id', 'left');
            $this->db->where('users_x_grupos_familiares.grupo_familiar_id', $idGrupo);
            $this->db->where('users_x_grupos_familiares.ativo', 1);
            $res = $this->db->get()->result();
            return $res;
        } else {
            return false;
        }
    }

    public function getMembrosGrupoDesativos($idGrupo = null)
    {
        if ($idGrupo) {
            $this->db->select('users.id, users.first_name, users.last_name, users.email, users_x_grupos_familiares.id as usr_gf_id, users_x_grupos_familiares.ativo');
            $this->db->from('users');
            $this->db->join('users_x_grupos_familiares', 'users_x_grupos_familiares.user_id = users.id', 'left');
            $this->db->where('users_x_grupos_familiares.grupo_familiar_id', $idGrupo);
            $this->db->where('users_x_grupos_familiares.ativo', 0);
            $res = $this->db->get()->result();
            return $res;
        } else {
            return false;
        }
    }

    public function getPrioridadesTarefas()
    {
        $this->db->from('prioridades_tarefa');
        $res = $this->db->get()->result();
        return $res;
    }

    public function setTarefa($idGrupo = null, $titulo = null, $descricao = null, $dataHora = null, $prioridade = null, $estado = null)
    {
        if ($idGrupo && $titulo && $dataHora && $prioridade && $estado) {
            $this->db->set('titulo', $titulo);
            $this->db->set('descricao', $descricao);
            $this->db->set('data_hora_criacao', $dataHora);
            $this->db->set('prioridades_tarefa_id', $prioridade);
            $this->db->set('estados_tarefa_id', $estado);
            $this->db->set('grupos_familiares_id', $idGrupo);
            $this->db->insert('tarefas');
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function editTarefa($idTarefa = null, $idGrupo = null, $titulo = null, $descricao = null, $dataHora = null, $prioridade = null, $estado = null)
    {
        if ($idTarefa && $idGrupo && $titulo && $dataHora && $prioridade && $estado) {
            $this->db->set('titulo', $titulo);
            $this->db->set('descricao', $descricao);
            $this->db->set('data_hora_criacao', $dataHora);
            $this->db->set('prioridades_tarefa_id', $prioridade);
            $this->db->set('estados_tarefa_id', $estado);
            $this->db->set('grupos_familiares_id', $idGrupo);
            $this->db->where('id', $idTarefa);
            return $this->db->update('tarefas');
        } else {
            return false;
        }
    }

    public function vincular_UsuarioTarefa($tarefa_id = null, $usuario_id = null)
    {
        if ($tarefa_id && $usuario_id) {
            $this->db->set('tarefas_id', $tarefa_id);
            $this->db->set('users_id', $usuario_id);
            return $this->db->insert('tarefas_has_users');
        } else {
            return false;
        }
    }

    public function limparUsuariosTarefa($tarefa_id = null)
    {
        if ($tarefa_id) {
            $this->db->where('tarefas_id', $tarefa_id);
            return $this->db->delete('tarefas_has_users');
        } else {
            return false;
        }
    }

    public function get_participantes_tarefa($tarefa_id = null)
    {
        if ($tarefa_id) {
            $this->db->from('tarefas_has_users');
            $this->db->where('tarefas_id', $tarefa_id);
            return $this->db->get()->result();
        } else {
            return false;
        }
    }

    //Provavelmente irá para a biblioteca custom
    public function get_user_by_email($email = null)
    {
        if ($email) {
            $this->db->select('id');
            $this->db->from('users');
            $this->db->where('email', $email);
            $this->db->limit(1);
            return $this->db->get()->row()->id;
        } else {
            return false;
        }
    }

    public function ativa_desativa_membro($id = null, $ativo = null)
    {
        if ($id) {
            $this->db->set('ativo', $ativo);
            $this->db->where('id', $id);
            return $this->db->update('users_x_grupos_familiares');
        } else {
            return false;
        }
    }

    public function registrar_conclusao_tarefa($tarefa_id = null)
    {
        if ($tarefa_id) {
            $this->db->set('estados_tarefa_id', 2);
            date_default_timezone_set('America/Sao_Paulo');
            $data = new DateTime();
            $this->db->set('data_hora_conclusão', $data->format('Y-m-d H:i:s'));
            $this->db->where('id', $tarefa_id);
            $this->db->update('tarefas');
        } else {
            return false;
        }
    }

    public function retificar_conclusao_tarefa($tarefa_id = null)
    {
        if ($tarefa_id) {
            $this->db->set('estados_tarefa_id', 1);
            $this->db->set('data_hora_conclusão', NULL);
            $this->db->where('id', $tarefa_id);
            $this->db->update('tarefas');
        } else {
            return false;
        }
    }
}
