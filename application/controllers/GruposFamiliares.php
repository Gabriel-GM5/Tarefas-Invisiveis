<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GruposFamiliares extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GruposFamiliares_Model');
    }

    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->load->helper('form');
            $data['grupos'] = $this->GruposFamiliares_Model->getGruposFamiliares($this->ion_auth->user()->row()->id);
            $this->custom->renderizarPagina('gruposFamiliares/gruposFamiliares', $data);
        } else {
            redirect('home', 'refresh');
        }
    }

    public function criar()
    {
        if ($this->ion_auth->logged_in()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            if ($this->form_validation->run()) {
                $insertID = $this->GruposFamiliares_Model->setGrupoFamiliar($this->input->post('nome'));
                if ($insertID) {
                    redirect('GruposFamiliares/auto_vincular/' . $insertID);
                } else {
                    $this->session->set_flashdata('error', 'Erro ao criar grupo!');
                    redirect('gruposFamiliares', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('gruposFamiliares', 'refresh');
            }
        } else {
            redirect('home', 'refresh');
        }
    }

    public function auto_vincular($idGrupo = null)
    {
        if ($idGrupo && $this->ion_auth->logged_in()) {
            if ($this->GruposFamiliares_Model->vincular_usuario_grupo($this->ion_auth->user()->row()->id, $idGrupo)) {
                $this->session->set_flashdata('success', 'Você entrou no grupo!');
            } else {
                $this->session->set_flashdata('error', 'Erro ao entrar no grupo!');
            }
            redirect('gruposFamiliares');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function grupo($idGrupo)
    {
        if ($this->ion_auth->logged_in() && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $idGrupo)) {
            $this->load->helper('form');
            $data['grupo_info'] = $this->GruposFamiliares_Model->getGrupoFamiliar($idGrupo);
            $data['tarefas_grupo'] = $this->GruposFamiliares_Model->getTarefasGrupo($idGrupo);
            $data['membros_grupo'] = $this->GruposFamiliares_Model->getMembrosGrupo($idGrupo);
            $data['membros_desativos'] = $this->GruposFamiliares_Model->getMembrosGrupoDesativos($idGrupo);
            $data['membros_tarefas'] = array();
            foreach ($data['tarefas_grupo'] as $tarefa) {
                array_push($data['membros_tarefas'], $this->GruposFamiliares_Model->get_participantes_tarefa($tarefa->id));
            }
            $data['prioridades'] = $this->GruposFamiliares_Model->getPrioridadesTarefas();
            $this->custom->renderizarPagina('gruposFamiliares/grupo', $data);
        } else {
            redirect('home', 'refresh');
        }
    }

    public function novaTarefa()
    {
        if ($this->ion_auth->logged_in() && $this->input->post('grupo_id') && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $this->input->post('grupo_id'))) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('grupo_id', 'Grupo', 'required');
            $this->form_validation->set_rules('titulo', 'Título', 'required');
            $this->form_validation->set_rules('dataHora', 'Data e Hora', 'required');
            $this->form_validation->set_rules('prioridade', 'Prioridade', 'required');
            if ($this->form_validation->run()) {
                $tmp1 = explode(' de ', $this->input->post('dataHora'))[0];
                $tmp2 = explode(' de ', $this->input->post('dataHora'))[1];
                $tmp1 = $tmp1 . ':00';
                $tmp2 = DateTime::createFromFormat('d/m/Y', $tmp2);
                $dataHora = $tmp2->format('Y-m-d') . ' ' . $tmp1;
                $tarefa_id = $this->GruposFamiliares_Model->setTarefa($this->input->post('grupo_id'), $this->input->post('titulo'), $this->input->post('descricao'), $dataHora, $this->input->post('prioridade'), 1);
                if ($tarefa_id) {
                    $this->session->set_flashdata('success', 'Tarefa Criada!');
                    $this->vincular_usuarios_tarefas($tarefa_id, $this->input->post('membros_grupo'));
                }
            } else {
                $this->session->set_flashdata('error', 'Tarefa não criada');
            }
            redirect('gruposFamiliares/grupo/' . $this->input->post('grupo_id'), 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function editar_tarefa()
    {
        if ($this->ion_auth->logged_in() && $this->input->post('grupo_id') && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $this->input->post('grupo_id'))) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tarefa_id', 'Tarefa', 'required');
            $this->form_validation->set_rules('grupo_id', 'Grupo', 'required');
            $this->form_validation->set_rules('titulo', 'Título', 'required');
            $this->form_validation->set_rules('dataHora', 'Data e Hora', 'required');
            $this->form_validation->set_rules('prioridade', 'Prioridade', 'required');
            if ($this->form_validation->run()) {
                $tmp1 = explode(' de ', $this->input->post('dataHora'))[0];
                $tmp2 = explode(' de ', $this->input->post('dataHora'))[1];
                $tmp1 = $tmp1 . ':00';
                $tmp2 = DateTime::createFromFormat('d/m/Y', $tmp2);
                $dataHora = $tmp2->format('Y-m-d') . ' ' . $tmp1;
                $tarefa_id = $this->GruposFamiliares_Model->editTarefa($this->input->post('tarefa_id'), $this->input->post('grupo_id'), $this->input->post('titulo'), $this->input->post('descricao'), $dataHora, $this->input->post('prioridade'), 1);
                if ($tarefa_id) {
                    $this->session->set_flashdata('success', 'Tarefa Criada!');
                }
            } else {
                $this->session->set_flashdata('error', 'Tarefa não criada');
            }
            redirect('gruposFamiliares/grupo/' . $this->input->post('grupo_id'), 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function vincularMembroTarefa()
    {
        if ($this->ion_auth->logged_in() && $this->input->post('grupo_id') && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $this->input->post('grupo_id'))) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tarefa_id', 'Tarefa', 'required');
            if ($this->form_validation->run()) {
                $this->vincular_usuarios_tarefas($this->input->post('tarefa_id'), $this->input->post('membros_grupo'));
            }
            redirect('gruposFamiliares/grupo/' . $this->input->post('grupo_id'), 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    //Provavelmente irá para a biblioteca Custom
    private function vincular_usuarios_tarefas($tarefa_id = null, $usuarios = null)
    {
        if ($tarefa_id) {
            $this->GruposFamiliares_Model->limparUsuariosTarefa($tarefa_id);
            if (isset($usuarios[0])) {
                foreach ($usuarios as $usr) {
                    $this->GruposFamiliares_Model->vincular_UsuarioTarefa($tarefa_id, $usr);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function novo_membro()
    {
        if ($this->ion_auth->logged_in() && $this->input->post('grupo_id')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('e-mail', 'E-mail', 'required');
            if ($this->form_validation->run()) {
                $user_id = $this->GruposFamiliares_Model->get_user_by_email($this->input->post('e-mail'));
                if ($user_id) {
                    $this->GruposFamiliares_Model->vincular_usuario_grupo($user_id, $this->input->post('grupo_id'));
                }
                redirect('gruposFamiliares/grupo/' . $this->input->post('grupo_id'), 'refresh');
            }
        } else {
            redirect('home', 'refresh');
        }
    }

    public function desativar_membro($idGrupo = null, $idMembro = null)
    {
        if ($this->ion_auth->logged_in() && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $idGrupo)) {
            if ($this->GruposFamiliares_Model->ativa_desativa_membro($idMembro, 0)) {
                $this->session->set_flashdata('success', 'Usuário desativado!');
            } else {
                $this->session->set_flashdata('error', 'Usuário ativado!');
            }
            redirect('gruposFamiliares/grupo/' . $idGrupo, 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function ativar_membro($idGrupo = null, $idMembro = null)
    {
        if ($this->ion_auth->logged_in() && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $idGrupo) && $idGrupo && $idMembro) {
            if ($this->GruposFamiliares_Model->ativa_desativa_membro($idMembro, 1)) {
                $this->session->set_flashdata('success', 'Usuário ativado!');
            } else {
                $this->session->set_flashdata('error', 'Usuário desativado!');
            }
            redirect('gruposFamiliares/grupo/' . $idGrupo, 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function registrar_conclusao($idGrupo = null, $tarefa_id = null)
    {
        if ($this->ion_auth->logged_in() && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $idGrupo) && $idGrupo && $tarefa_id) {
            if ($this->GruposFamiliares_Model->registrar_conclusao_tarefa($tarefa_id)) {
                $this->session->set_flashdata('success', 'Conclusão registrada!');
            } else {
                $this->session->set_flashdata('error', 'Erro!');
            }
            redirect('gruposFamiliares/grupo/' . $idGrupo, 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }

    public function retificar_conclusao($idGrupo = null, $tarefa_id = null)
    {
        if ($this->ion_auth->logged_in() && $this->custom->in_grupo($this->ion_auth->user()->row()->id, $idGrupo) && $idGrupo && $tarefa_id) {
            if ($this->GruposFamiliares_Model->retificar_conclusao_tarefa($tarefa_id)) {
                $this->session->set_flashdata('success', 'Retificado!');
            } else {
                $this->session->set_flashdata('error', 'Erro!');
            }
            redirect('gruposFamiliares/grupo/' . $idGrupo, 'refresh');
        } else {
            redirect('home', 'refresh');
        }
    }
}
