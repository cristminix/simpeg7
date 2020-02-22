<?php

/**
 * 
 */
class Login extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_web');
	}
	public function index()
	{
		$session_data = $this->session->userdata('logged_in');
		
        if (!empty($data['sesi'])) {
        	redirect($data['sesi']);
        }


		$id_app 		= $this->m_web->get_opsi_value();
		$getCaptcha     = $this->_gbr_captcha();

		$data 	= [
			'nama_app' 		=> $id_app->nama_aplikasi,
			'slogan_app'	=> $id_app->nama_aplikasi,
			'gbr_captcha' 	=> $getCaptcha['image'],
			'word'			=> $getCaptcha['word'],
			'captcha_time'	=> $getCaptcha['captcha_time'],
			'com_url' 		=> '',
			'sesi' => $session_data['back_office']

		];
		$this->load->add_view_path('public/assets/themes/login/');
		// die(is_file($this->viewPath.'index.php'));
		$this->load->view( 'index', $data);
	}

	public function _gbr_captcha()
    {
        $vals = array(
            // 'word' => $this->word,
            'img_path'   => FCPATH .'public/assets/images/captcha/',
            'img_url'    => base_url() . 'public/assets/images/captcha/',
            'font_path'  => './system/fonts/GARABD.ttf',
            'img_width'  => '150',
            'img_height' => 40,
        );
        $cap       = create_captcha($vals);
        $datamasuk = array(
            'captcha_time' => $cap['time'],
            'word'         => $cap['word'],
        );

        // $this->input->post($cap['word']);
        // $this->word= $cap['word'];
        $word       = $cap['word'];

        $expiration = time() - 3600;
        
        $this->db->query("DELETE FROM captcha WHERE word <> '" . $cap['word'] . "' AND captcha_time <> " . $cap['time']);
        
        $query = $this->db->insert_string('captcha', $datamasuk);
        
        $this->db->query($query);

        return array(
            'image'        => $cap['image'],
            'word'         => $cap['word'],
            'captcha_time' => $cap['time'],
        );
    }

    public function refresh()
    {
        $session_data = $this->session->userdata('logged_in');
        $data['sesi'] = $session_data['back_office'];

        if (!empty($data['sesi'])) {redirect($data['sesi']);}

        $id_app                = $this->m_web->get_opsi_value();
        $data['nama_app']      = @$id_app->nama_aplikasi;
        $data['slogan_app']    = @$id_app->slogan_aplikasi;
        $getCaptcha            = $this->_gbr_captcha();
        $data['gbr_captcha']   = $getCaptcha['image'];
        $data['word']          = $getCaptcha['word'];
        $data['captcha_time']  = $getCaptcha['captcha_time'];
        $data['user_name']     = $_POST['user_name'];
        $data['user_password'] = $_POST['user_password'];

        $this->load->add_view_path('public/assets/themes/login/');
        $this->load->view( 'index', $data);
    }

    public function deleteImage()
    {
        

        $idTime = '\*';
        $files  = glob(FCPATH . "captcha" . $idTime); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
        }

        return $this;
    }
    public function dologin()
    {
		
        $this->load->library('auth/auth');
        $this->form_validation->set_rules('user_name', "Nama User", 'trim|required');
        $this->form_validation->set_rules('user_password', "Password", 'trim|required');
        $this->form_validation->set_rules('captcha', "Captcha", 'trim|validate_captcha');

        $empty_captcha = empty($_POST['captcha']);
        $captcha = strtolower($_POST['captcha']);
        $word = strtolower($_POST['word']);

        if ( $empty_captcha || ( $captcha != $word)) {
            $responce = [
            	'result' => 'failed', 
            	'message' => 'Cek Captcha'
            ];
        } else {

            if ($this->form_validation->run() == false) {
                $responce = array('result' => 'failed', 'message' => validation_errors());
            } else {
                $this->load->library('auth');
                $datalogin = array(
                    'user_name'     => $this->input->post('user_name'),
                    'user_password' => $this->input->post('user_password'),
                );
                if ($this->auth->process_login($datalogin) == false) {
                    $responce = array('result' => 'failed', 'message' => 'Username atau Password yang anda masukkan salah');
                } else {
                    $session_data = $this->session->userdata('logged_in');
                    $this->deleteImage();
                    $responce = array('result' => 'succes', 'message' => 'Login anda diterima. Mohon menunggu..', 'section' => $session_data['back_office']);
                }
            }

        }
        echo json_encode($responce);
    }
    public function keepalive()
    {
        echo 'OK';
    }
    public function out()
    {
        $session_data = $this->session->userdata('logged_in');
        $this->db->delete('user_online', array('user_id' => $session_data['id_user']));
        $this->session->sess_destroy();
        echo "<script type=\"text/javascript\">location.href = '" . site_url() . "' + 'login'; </script>";
    }
}