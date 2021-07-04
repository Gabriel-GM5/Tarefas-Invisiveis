<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_Model extends CI_Model
{
    public function getTarefasPendentes($userID = null)
    {
        if ($userID) {
            $this->db->select('tarefas.*, prioridades_tarefa.descricao as prioridade, estados_tarefa.descricao as estado, grupos_familiares.nome as nome_grupo_familiar');
            $this->db->from('tarefas');
            $this->db->join('prioridades_tarefa', 'prioridades_tarefa.id = tarefas.prioridades_tarefa_id', 'left');
            $this->db->join('estados_tarefa', 'estados_tarefa.id = tarefas.estados_tarefa_id', 'left');
            $this->db->join('tarefas_has_users', 'tarefas_has_users.tarefas_id = tarefas.id');
            $this->db->join('grupos_familiares', 'grupos_familiares.id = tarefas.grupos_familiares_id', 'left');
            $this->db->where('tarefas_has_users.users_id', $userID);
            $this->db->where('tarefas.estados_tarefa_id', 1);
            return $this->db->get()->result();
        } else {
            return false;
        }
    }   
}
