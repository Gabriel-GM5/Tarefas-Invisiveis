<?php
defined('BASEPATH') or exit('No direct script access allowed');

class API extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buscar_participantes_grupo_familiar($idGrupo)
    {
        $this->load->model('GruposFamiliares_Model');
        $membros_grupo = $this->GruposFamiliares_Model->getMembrosGrupo($idGrupo);
        echo json_encode($membros_grupo, JSON_FORCE_OBJECT);
    }
}
