<?php
class Items extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Item_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index() {
        $data['items'] = $this->Item_model->get_items();
        $this->load->view('items/index', $data);
    }
    
    public function view($id) {
        $data = $this->Item_model->get_item($id);
        echo json_encode($data);
    }

    public function create() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('items/create');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $data['image'] = $uploadData['file_name'];
                } else {
                    $data['image'] = '';
                }
            } else {
                $data['image'] = '';
            }

            $this->Item_model->create_item($data);
            redirect('items');
        }
    }
    
    public function edit($id) {
        $data['item'] = $this->Item_model->get_item($id);

        if (empty($data['item'])) {
            show_404();
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('items/edit', $data);
        } else {
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $update_data['image'] = $uploadData['file_name'];
                }
            }

            $this->Item_model->update_item($id, $update_data);
            redirect('items');
        }
    }
    
    public function delete($id) {
        $this->Item_model->delete_item($id);
        redirect('items');
    }
}
