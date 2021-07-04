<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_Model');
    }

    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->load->model('GruposFamiliares_Model');
            $data['grupos'] = $this->GruposFamiliares_Model->getGruposFamiliares($this->ion_auth->user()->row()->id);
            $data['tarefas'] = $this->Dashboard_Model->getTarefasPendentes($this->ion_auth->user()->row()->id);
            $this->custom->renderizarPagina('dashboard/dashboard', $data);
        } else {
            redirect('home', 'refresh');
        }
    }
}
