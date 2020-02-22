<?php

/**
 * 
 */
class MY_Form_validation extends CI_Form_validation
{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, validates the info, and stores it
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	 public function validate_captcha($word)
    {
		 $this->CI =& get_instance();
		 // var_dump ($word);
		 // var_dump ($captcha);
		 // var_dump ($_POST['captcha']);
		// var_dump ($_POST['word']);
		 
		 $word = strtolower($word);
         if(empty($word) || $word != strtolower($_POST['captcha']) ){
            $this->CI->form_validation->set_message('validate_captcha', 'The letters you entered do not match the image.');
            return FALSE;
         }else{
             return TRUE;
         }
    }
}