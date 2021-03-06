<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Todo controller do codeigniter precisa extender (ser filho)
//da classe CI_Controller
class Integrante extends CI_Controller {

    public function __construct() {
        //chama o contrutor da classe pai CI_Controller
        parent::__construct();
        //chama o método que faz a validação de login de usuário
        $this->load->model('Usuario_model');
        $this->Usuario_model->verificaLogin();
        $this->load->model('Integrante_Model');
    }

    public function index() {
        $this->listar();
    }

    public function listar() {
        $data['integrantes'] = $this->Integrante_Model->getAll();
        $this->load->view('Header');
        $this->load->view('ListaIntegrantes', $data);
        $this->load->view('Footer');
    }

    public function cadastrar() {
        $this->form_validation->set_rules('Nome', 'Nome', 'required');
        $this->form_validation->set_rules('Equipe', 'Equipe', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->model('Equipe_Model', 'em');
            $data['equipes'] = $this->em->getAll();
            $this->load->view('Header');
            $this->load->view('FormularioIntegrante', $data);
            $this->load->view('Footer');
        } else {
            $this->load->model('Integrante_Model');
            $data = array(
                'nome' => $this->input->post('Nome'),
                'id_equipe' => $this->input->post('Equipe'),
                'data_nasc' => $this->input->post('data_nasc'),
                'rg' => $this->input->post('RG'),
                'cpf' => $this->input->post('CPF'),
            );
            if ($this->Integrante_Model->insert($data)) {
                $this->session->set_flashdata('retorno', '<div class="alert alert-success"><i class="fas fa-check-double"></i> Integrante cadastrado com sucesso</div>');
                redirect('Integrante/listar');
            } else {
                $this->session->set_flashdata('retorno', '<div class="alert alert-danger"><i class="far fa-hand-paper"></i> Erro ao cadastrar Integrante!!!</div>');
                redirect('Integrante/cadastrar');
            }
        }
    }

    public function alterar($id) {
        if ($id > 0) {
            $this->form_validation->set_rules('Nome', 'Nome', 'required');
            $this->form_validation->set_rules('Equipe', 'Equipe', 'required');
            if ($this->form_validation->run() == false) {
                $data['integrante'] = $this->Integrante_Model->getOne($id);
                $this->load->model('Equipe_Model');
                $data['equipes'] = $this->Equipe_Model->getAll();
                $this->load->view('Header');
                $this->load->view('FormularioIntegrante', $data);
                $this->load->view('Footer');
            } else {
                $data = array(
                    'nome' => $this->input->post('Nome'),
                    'id_equipe' => $this->input->post('Equipe'),
                    'data_nasc' => $this->input->post('data_nasc'),
                    'rg' => $this->input->post('RG'),
                    'cpf' => $this->input->post('CPF')
                );
                if ($this->Integrante_Model->update($id, $data)) {
                    $this->session->set_flashdata('retorno', '<div class="alert alert-success"><i class="fas fa-check-double"></i> Integrante alterado com sucesso!</div>');
                    redirect('Integrante/listar');
                } else {
                    $this->session->set_flashdata('retorno', '<div class="alert alert-danger"><i class="far fa-hand-paper"></i> Falha ao alterar Integrante...</div>');
                    redirect('Integrante/alterar/' . $id);
                }
            }
        } else {
            redirect('Integrante/listar');
        }
    }

    public function deletar($id) {
        if ($id > 0) {
            if ($this->Integrante_Model->delete($id)) {
                $this->session->set_flashdata('retorno', '<div class="alert alert-success"><i class="fas fa-check-double"></i> Integrante deletado com sucesso!</div>');
            } else {
                $this->session->set_flashdata('retorno', '<div class="alert alert-danger"><i class="far fa-hand-paper"></i> Falha ao Deletar Integrante...</div>');
            }
        }
        redirect('Integrante/listar');
    }
}
