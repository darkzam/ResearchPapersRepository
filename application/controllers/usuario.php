<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//esta clase permite registrar y loguear al usuario

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // To load the CI benchmark and memory usage profiler - set 1==1.
      /*  if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }*/

        // Load required CI libraries and helpers.
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

        // Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
        if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'auth/logout') {
            // Preserve any flashdata messages so they are passed to the redirect page.
            if ($this->session->flashdata('message')) {
                $this->session->keep_flashdata('message');
            }

            // Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
            if ($this->flexi_auth->is_admin()) {
                redirect('usuario_admin/dashboard');
            } else {
                echo "<script>alert('te has logueado user normal');</script>";
                redirect('usuario_public/dashboard');
            }
        }

        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', 'http://sistemaconsultas.com/');
        $this->load->vars('includes_dir', 'http://sistemaconsultas.com/includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
    }

    function index() {
        $this->login();
    }

    function login() {
        // If 'Login' form has been submited, attempt to log the user in.
        if ($this->input->post('login_user')) {         //echo "<script>  alert('intento cargar el demo');   </script>";
            $this->load->model('usuario_model');
            $this->usuario_model->login();
        }

        // CAPTCHA Example
        // Check whether there are any existing failed login attempts from the users ip address and whether those attempts have exceeded the defined threshold limit.
        // If the user has exceeded the limit, generate a 'CAPTCHA' that the user must additionally complete when next attempting to login.
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            /**
             * reCAPTCHA
             * http://www.google.com/recaptcha
             * To activate reCAPTCHA, ensure the 'recaptcha()' function below is uncommented and then comment out the 'math_captcha()' function further below.
             *
             * A boolean variable can be passed to 'recaptcha()' to set whether to use SSL or not.
             * When displaying the captcha in a view, if the reCAPTCHA theme has been set to one of the template skins (See https://developers.google.com/recaptcha/docs/customization),
             *  then the 'recaptcha()' function generates all the html required.
             * If using a 'custom' reCAPTCHA theme, then the custom html must be PREPENDED to the code returned by the 'recaptcha()' function.
             * Again see https://developers.google.com/recaptcha/docs/customization for a template 'custom' html theme. 
             * 
             * Note: To use this example, you will also need to enable the recaptcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            $this->data['captcha'] = $this->flexi_auth->recaptcha(FALSE);

            /**
             * flexi auths math CAPTCHA
             * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
             * For flexibility on CAPTCHA presentation, the 'math_captcha()' function only generates a string of the equation, see the example below.
             * 
             * To activate math_captcha, ensure the 'math_captcha()' function below is uncommented and then comment out the 'recaptcha()' function above.
             *
             * Note: To use this example, you will also need to enable the math_captcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
             */
            # $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
        }

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('usuarios/login', $this->data);
    }

    function register_account() {
        // Redirect user away from registration page if already logged in.


        if ($this->flexi_auth->is_logged_in()) {
            redirect('usuario');
        }
        // If 'Registration' form has been submitted, attempt to register their details as a new account.
        $this->load->model('usuario_model');

        if ($this->input->post('register_user')) {

            $this->usuario_model->register_account();
        }
// Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data['programas'] = $this->usuario_model->get_programas();
        $this->load->view('usuarios/formregistro', $this->data);
    }

}
