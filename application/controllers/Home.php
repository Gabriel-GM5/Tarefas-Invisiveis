<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_Model');
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
			$this->load->helper('form');
			$this->custom->renderizarPagina('home');
		} else {
			redirect('dashboard');
		}
	}

	public function cadastro()
	{
		if (!$this->ion_auth->logged_in()) {
			$this->load->helper('form');
			$this->custom->renderizarPagina('cadastro');
		} else {
			redirect('home', 'refresh');
		}
	}

	public function cadastrar()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required');
		$this->form_validation->set_rules('e-mail', 'E-mail', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required');
		if ($this->form_validation->run()) {
			if ($this->ion_auth->register($this->input->post('e-mail'), $this->input->post('senha'), $this->input->post('e-mail'), array('first_name' => $this->input->post('nome'), 'last_name' => $this->input->post('sobrenome')))) {
				$this->session->set_flashdata('success', 'Cadastrado!');
				redirect('home', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Erro ao cadastrar!');
				redirect('home/cadastro', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
			redirect('home/cadastro', 'refresh');
		}
	}

	public function login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('e-mail', 'E-mail', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required');
		if ($this->form_validation->run()) {
			if ($this->ion_auth->login($this->input->post('e-mail'), $this->input->post('senha'), true)) {
				$this->session->set_flashdata('success', 'Logado!');
			} else {
				$this->session->set_flashdata('error', 'Usuário ou senha incorretos!');
			}
		} else {
			$this->session->set_flashdata('error', validation_errors());
		}
		redirect('home', 'refresh');
	}

	public function logout()
	{
		if ($this->ion_auth->logout()) {
			$this->session->set_flashdata('success', 'Deslogado!');
		} else {
			$this->session->set_flashdata('error', 'Comportamento inesperado!');
		}
		redirect('home', 'refresh');
	}
}
