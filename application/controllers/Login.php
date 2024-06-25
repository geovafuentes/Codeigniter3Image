<?php
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('login');
    }

    public function auth() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->User_model->get_user($username, $password);
            
            if ($user) {
                $this->session->set_userdata('user_id', $user->id);
                redirect('items');
            } else {
                $this->session->set_flashdata('error', 'Las credenciales son incorrectas');
                redirect('login');
            }
        }
    }
    public function logout() {
        // Destruir la sesión
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        echo json_encode(['status' => 'success']);
    }
}

?>
