<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom
{

    public function renderizarPagina($view = null, $data = null)
    {
        $CI = &get_instance();
        if ($CI->ion_auth->logged_in()) {
            $user = $CI->ion_auth->user()->row();
            $data_m['menu_desktop'] = '
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
            <li><a href="' . site_url('dashboard') . '">Dashboard</a></li>
            <li><a href="' . site_url('GruposFamiliares') . '">Grupos Familiares</a></li>
            <li>
            <a class="dropdown-trigger btn" href="#" data-target="dropdown1"><i class="material-icons left">account_circle</i>' . $user->first_name . '<i class="material-icons right">arrow_drop_down</i></a>
            <ul id="dropdown1" class="dropdown-content">
            <li><a href="#!">Perfil</a></li>
            <li><a href="#!">Ajuda</a></li>
            <li><a href="' . site_url('home/logout') . '">Sair</a></li>
            </ul>
            </li>
            </ul>
            ';

            $data_m['menu_mobile'] = '
            <ul class="sidenav" id="mobile-demo">
            <li>
            <a class="dropdown-trigger btn" href="#" data-target="dropdown2"><i class="material-icons left">account_circle</i>' . $user->first_name . '<i class="material-icons right">arrow_drop_down</i></a>
            <ul id="dropdown2" class="dropdown-content">
            <li><a href="#!">Perfil</a></li>
            <li><a href="#!">Ajuda</a></li>
            <li><a href="' . site_url('home/logout') . '">Sair</a></li>
            </ul>
            </li>
            <li><a href="' . site_url('dashboard') . '">Dashboard</a></li>
            <li><a href="' . site_url('GruposFamiliares') . '">Grupos Familiares</a></li>
            </ul>
            ';
        } else {
            $data_m['menu_desktop'] = '';
            $data_m['menu_mobile'] = '';
        }
        $CI->load->view('includes/0_begin');
        $CI->load->view('includes/1_head');
        $CI->load->view('includes/2_body_start');
        $CI->load->view('includes/3_1_header', $data_m);
        $CI->load->view('includes/3_2_navbar', $data_m);
        $CI->load->view('includes/4_content_start');
        $CI->load->view($view, $data);
        $CI->load->view('includes/5_content_end');
        $CI->load->view('includes/6_footer');
        $CI->load->view('includes/7_import');
        $CI->load->view('includes/8_body_end');
        $CI->load->view('includes/9_end');
    }

    public function in_grupo($userID = null, $grupoID = null)
    {
        if ($userID && $grupoID) {
            $CI = &get_instance();
            $CI->load->model('Custom_Model');
            if ($CI->Custom_Model->get_user_group($userID, $grupoID)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
