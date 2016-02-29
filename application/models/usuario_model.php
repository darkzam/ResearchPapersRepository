<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuario_model extends CI_Model {

    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function login() {
        $this->load->library('form_validation');

        // Set validation rules.
        $this->form_validation->set_rules('login_identity', 'Identity (Email / Login)', 'required');
        $this->form_validation->set_rules('login_password', 'Password', 'required');

        // If failed login attempts from users IP exceeds limit defined by config file, validate captcha.
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            /**
             * reCAPTCHA
             * http://www.google.com/recaptcha
             * To activate reCAPTCHA, ensure the 'recaptcha_response_field' validation below is uncommented and then comment out the 'login_captcha' validation further below.
             *
             * The custom validation rule 'validate_recaptcha' can be found in '../libaries/MY_Form_validation.php'.
             * The form field name used by 'reCAPTCHA' is 'recaptcha_response_field', this field name IS NOT editable.
             * 
             * Note: To use this example, you will also need to enable the recaptcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
             */
            $this->form_validation->set_rules('recaptcha_response_field', 'Captcha Answer', 'required|validate_recaptcha');

            /**
             * flexi auths math CAPTCHA
             * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
             * To activate Math CAPTCHA, ensure the 'login_captcha' validation below is uncommented and then comment out the 'recaptcha_response_field' validation above.
             * 
             * The field value submitted as the answer to the math captcha must be submitted to the 'validate_math_captcha' validation function.
             * The custom validation rule 'validate_math_captcha' can be found in '../libaries/MY_Form_validation.php'.
             * 
             * Note: To use this example, you will also need to enable the math_captcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
             */
            # $this->form_validation->set_rules('login_captcha', 'Captcha Answer', 'required|validate_math_captcha['.$this->input->post('login_captcha').']');				
        }

        // Run the validation.
        if ($this->form_validation->run()) {
            // Check if user wants the 'Remember me' feature enabled.
            $remember_user = ($this->input->post('remember_me') == 1);

            // Verify login data.
            $this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Reload page, if login was successful, sessions will have been created that will then further redirect verified users.
            redirect('usuario');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<div class="ui negative message">', '</div>');

            return FALSE;
        }
    }

    function register_account() {
        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'register_first_name', 'label' => 'First Name', 'rules' => 'required'),
            array('field' => 'register_last_name', 'label' => 'Last Name', 'rules' => 'required'),
            array('field' => 'register_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
            //   array('field' => 'codigo', 'label' => 'codigo', 'rules' => 'required'),
            array('field' => 'programa', 'label' => 'programa', 'rules' => 'required'),
            array('field' => 'sede', 'label' => 'sede', 'rules' => 'required'),
            array('field' => 'register_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
            array('field' => 'register_email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email|identity_available'),
            array('field' => 'register_username', 'label' => 'Username', 'rules' => 'required|min_length[4]|identity_available|is_natural'),
            array('field' => 'register_password', 'label' => 'Password', 'rules' => 'required|validate_password'),
            array('field' => 'register_confirm_password', 'label' => 'Confirm Password', 'rules' => 'required|matches[register_password]')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get user login details from input.
            $email = $this->input->post('register_email_address');
            $username = $this->input->post('register_username');
            $password = $this->input->post('register_password');

            // Get user profile data from input.
            // You can add whatever columns you need to customise user tables.
            $profile_data = array(
                'upro_first_name' => $this->input->post('register_first_name'),
                'upro_last_name' => $this->input->post('register_last_name'),
                'upro_phone' => $this->input->post('register_phone_number'),
                'upro_programa' => $this->input->post('programa'),
                //  'upro_codigo' => $this->input->post('codigo'),
                'upro_sede' => $this->input->post('sede'),
                'upro_newsletter' => $this->input->post('register_newsletter')
            );

            // Set whether to instantly activate account.
            // This var will be used twice, once for registration, then to check if to log the user in after registration.
            $instant_activate = TRUE;

            // The last 2 variables on the register function are optional, these variables allow you to:
            // #1. Specify the group ID for the user to be added to (i.e. 'Moderator' / 'Public'), the default is set via the config file.
            // #2. Set whether to automatically activate the account upon registration, default is FALSE. 
            // Note: An account activation email will be automatically sent if auto activate is FALSE, or if an activation time limit is set by the config file.
            $response = $this->flexi_auth->insert_user($email, $username, $password, $profile_data, 1, $instant_activate);

            if ($response) {
                // This is an example 'Welcome' email that could be sent to a new user upon registration.
                // Bear in mind, if registration has been set to require the user activates their account, they will already be receiving an activation email.
                // Therefore sending an additional email welcoming the user may be deemed unnecessary.
                $email_data = array('identity' => $email);
                // $this->flexi_auth->send_email($email, 'Welcome', 'registration_welcome.tpl.php', $email_data);
                $this->flexi_auth->login($username, $password, 0);
                // Note: The 'registration_welcome.tpl.php' template file is located in the '../views/includes/email/' directory defined by the config file.
                ###+++++++++++++++++###
                // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
                $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

                // This is an example of how to log the user into their account immeadiately after registering.
                // This example would only be used if users do not have to authenticate their account via email upon registration.
                if ($instant_activate && $this->flexi_auth->login($email, $password)) {
                    // Redirect user to public dashboard.
                    redirect('usuario_public/dashboard');
                }

                // Redirect user to login page
                redirect('usuario');
            }
        }

        // Set validation errors.
        $this->data['message'] = validation_errors('<div class="ui negative message">', '</div>');

        return FALSE;
    }

    function update_account() {
        $this->load->library('form_validation');
        // Set validation rules.
        // The custom rule 'identity_available' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'update_first_name', 'label' => 'First Name', 'rules' => 'required'),
            array('field' => 'update_last_name', 'label' => 'Last Name', 'rules' => 'required'),
            //  array('field' => 'codigo', 'label' => 'codigo', 'rules' => 'required'),
            array('field' => 'programa', 'label' => 'programa', 'rules' => 'required'),
            array('field' => 'sede', 'label' => 'sede', 'rules' => 'required'),
            array('field' => 'update_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
            array('field' => 'update_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
            array('field' => 'update_email', 'label' => 'Email', 'rules' => 'required|valid_email'),
            array('field' => 'update_username', 'label' => 'Username', 'rules' => 'min_length[4]')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Note: This example requires that the user updates their email address via a separate page for verification purposes.
            // Get user id from session to use in the update function as a primary key.

            $user_id = $this->flexi_auth->get_user_id();

            // Get user profile data from input.
            // IMPORTANT NOTE: As we are updating multiple tables (The main user account and user profile tables), it is very important to pass the
            // primary key column and value in the $profile_data for any custom user tables being updated, otherwise, the function will not
            // be able to identify the correct custom data row.
            // In this example, the primary key column and value is 'upro_uacc_fk' => $user_id.
            $profile_data = array(
                'upro_uacc_fk' => $user_id,
                'upro_first_name' => $this->input->post('update_first_name'),
                'upro_last_name' => $this->input->post('update_last_name'),
                'upro_phone' => $this->input->post('update_phone_number'),
                'upro_programa' => $this->input->post('programa'),
                //   'upro_codigo' => $this->input->post('codigo'),
                'upro_sede' => $this->input->post('sede'),
                'upro_newsletter' => $this->input->post('update_newsletter'),
                $this->flexi_auth->db_column('user_acc', 'email') => $this->input->post('update_email'),
                $this->flexi_auth->db_column('user_acc', 'username') => $this->input->post('update_username'),
                    //aca modifique
                    // 'uacc_identificacion' => $this->input->post('codigo')
            );

            // If we were only updating profile data (i.e. no email or username included), we could use the 'update_custom_user_data()' function instead.
            $response = $this->flexi_auth->update_user($user_id, $profile_data);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Redirect user.
            //($response) ? redirect('usuario_public/dashboard') : redirect('usuario_public/update_account');
            redirect(current_url());
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<div class="ui negative message">', '</div>');

            return FALSE;
        }
    }

    function update_account_by_admin($id) {

        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rule 'identity_available' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'update_first_name', 'label' => 'First Name', 'rules' => 'required'),
            array('field' => 'update_last_name', 'label' => 'Last Name', 'rules' => 'required'),
            //   array('field' => 'codigo', 'label' => 'codigo', 'rules' => 'required'),
            array('field' => 'programa', 'label' => 'programa', 'rules' => 'required'),
            array('field' => 'sede', 'label' => 'sede', 'rules' => 'required'),
            array('field' => 'update_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
            array('field' => 'update_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
            array('field' => 'update_email', 'label' => 'Email', 'rules' => 'required|valid_email'),
            array('field' => 'update_username', 'label' => 'Username', 'rules' => 'min_length[4]')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {



            $profile_data = array(
                'upro_uacc_fk' => $id,
                'upro_first_name' => $this->input->post('update_first_name'),
                'upro_last_name' => $this->input->post('update_last_name'),
                'upro_phone' => $this->input->post('update_phone_number'),
                'upro_programa' => $this->input->post('programa'),
                //  'upro_codigo' => $this->input->post('codigo'),
                'upro_sede' => $this->input->post('sede'),
                'upro_newsletter' => $this->input->post('update_newsletter'),
                $this->flexi_auth->db_column('user_acc', 'email') => $this->input->post('update_email'),
                $this->flexi_auth->db_column('user_acc', 'username') => $this->input->post('update_username')
                    //aca modifique
                    //  ,'uacc_identificacion' => $this->input->post('codigo')
            );

            // If we were only updating profile data (i.e. no email or username included), we could use the 'update_custom_user_data()' function instead.
            $response = $this->flexi_auth->update_user($id, $profile_data);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Redirect user.
            // ($response) ? redirect(current_url()) : redirect('usuario_admin/administrar_usuarios');
            redirect(current_url());
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<div class="ui negative message">', '</div>');

            return FALSE;
        }
    }

    function change_password() {
        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'current_password', 'label' => 'Password Actual', 'rules' => 'required'),
            array('field' => 'new_password', 'label' => 'Nuevo Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirme el nuevo Password', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get password data from input.
            $identity = $this->flexi_auth->get_user_identity();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            // Note: Changing a password will delete all 'Remember me' database sessions for the user, except their current session.
            $response = $this->flexi_auth->change_password($identity, $current_password, $new_password);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Redirect user.
            // Note: As an added layer of security, you may wish to email the user that their password has been updated.
            //($response) ? redirect('usuario_public/dashboard') : redirect('usuario_public/change_password');
            redirect(current_url());
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<div class="ui negative message">', '</div>');

            return FALSE;
        }
    }

    function show_fichas($campos, $index, $numregistros) {

        $this->load->database();
        //  $this->db->cache_on();
        $this->db->select('*')->from('fichas');

        foreach ($campos[0] as $clave) {
            $this->db->like('Titulo', $clave);
        }
        foreach ($campos[1] as $clave) {
            $this->db->like('Autor', $clave);
        }
        foreach ($campos[2] as $clave) {
            $this->db->like('Director', $clave);
        }
        foreach ($campos[3] as $clave) {
            $this->db->like('Año', $clave);
        }
        foreach ($campos[4] as $clave) {
            $this->db->like('Keywords', $clave);
        }
        foreach ($campos[5] as $clave) {
            $this->db->like('Programa', $clave);
        }
        $this->db->limit($numregistros, $index);

        $fichas = $this->db->get();
        return $fichas->result_array();
    }

    function show_all() {

        $this->load->database();
        $this->db->cache_on();
        $fichas = $this->db->get('fichas');

        return $fichas->result_array();
    }

    function show_ficha_by_id($id) {
        $this->load->database();
        $this->db->select('*')->from('fichas');
        $this->db->where('Id', $id);
        $ficha = $this->db->get();
        return $ficha->row_array();
    }

    function get_historial_by_id($id) {
        $this->load->database();
        $historial = $this->db->query("SELECT detalle_solicitudes.id_solicitud , detalle_solicitudes.fecha_mod, user_accounts.uacc_username, detalle_solicitudes.modificacion,detalle_solicitudes.comentarios FROM `solicitudes` JOIN `detalle_solicitudes` ON detalle_solicitudes.id_solicitud = solicitudes.id JOIN user_accounts
	ON user_accounts.uacc_id = detalle_solicitudes.id_admin WHERE detalle_solicitudes.id_solicitud = " . $id);
        return $historial->result_array();
    }

    function insert_solicitud($datos) {
        $this->load->database();
        $this->db->select('*')->from('solicitudes');
        $this->db->where('Id_user', $datos['Id_user']);
        $this->db->where('Id_ficha', $datos['Id_ficha']);
        $query = $ficha = $this->db->get();
        //insertar id_user, id_ficha , estado, fecha . en tabla solicitudes  si no existe duplicado
        if ($query->num_rows() == 0) {
            $this->db->insert('solicitudes', $datos);
            return true;
        }
        return false;
    }

    function get_solicitudes($index, $numregistros, $festado, $fuser) {
        // para el admin
        $this->load->database();
        //aca modifique para administrar solicitudes
        //$query  = $this->db->query('SELECT solicitudes.id, demo_user_profiles.upro_codigo, solicitudes.id_ficha, solicitudes.fecha, solicitudes.estado,solicitudes.paginas, solicitudes.comentarios  FROM `solicitudes` LEFT JOIN `demo_user_profiles` ON solicitudes.id_user = demo_user_profiles.upro_uacc_fk');
        //Querys para filtro estado con filtro usuario = vacio  = todos los usuarios
        if (empty($fuser)) {
            //Query para filtro estado = Todas

            $where = empty($festado) ? '' : 'WHERE solicitudes.estado LIKE "' . $festado . '%"';
            // anterior con upo_codigo  $query = $this->db->query('SELECT solicitudes.id, demo_user_profiles.upro_codigo, solicitudes.id_ficha, solicitudes.fecha, solicitudes.estado,solicitudes.paginas, solicitudes.comentarios  FROM `solicitudes` LEFT JOIN `demo_user_profiles` ON solicitudes.id_user = demo_user_profiles.upro_uacc_fk ' . $where . ' ORDER BY solicitudes.id DESC LIMIT ' . $index . ',' . $numregistros);
            $query = $this->db->query('SELECT solicitudes.id, user_accounts.uacc_username, solicitudes.id_ficha, solicitudes.fecha, solicitudes.estado,solicitudes.paginas, solicitudes.comentarios  FROM `solicitudes` LEFT JOIN `user_accounts` ON solicitudes.id_user = user_accounts.uacc_id ' . $where . ' ORDER BY solicitudes.id DESC LIMIT ' . $index . ',' . $numregistros);


            //Querys para filtro estado con filtro usuario = Existente = usuario especifico
            //Query para filtro estado = Todas = las del usuario especifico
            //Query para filtro estado = Aprobadas 
            //Query para filtro estado = Denegadas

            return $query->result_array();
        } else {
            $where = empty($festado) ? 'WHERE user_accounts.uacc_username LIKE "' . $fuser . '%"' : 'WHERE solicitudes.estado LIKE "' . $festado . '%" AND user_accounts.uacc_username LIKE "' . $fuser . '%"';
            $query = $this->db->query('SELECT solicitudes.id, user_accounts.uacc_username, solicitudes.id_ficha, solicitudes.fecha, solicitudes.estado,solicitudes.paginas, solicitudes.comentarios  FROM `solicitudes` LEFT JOIN `user_accounts` ON solicitudes.id_user = user_accounts.uacc_id ' . $where . ' ORDER BY solicitudes.id DESC LIMIT ' . $index . ',' . $numregistros);

            return $query->result_array();
        }
    }

    function get_solicitudes_by_user($id, $index, $regmax) {
        //para admin y usuario con id logueado al momento
        //SELECT solicitudes.id, solicitudes.id_user, solicitudes.fecha, solicitudes.estado, solicitudes.comentarios, fichas.titulo FROM `solicitudes` LEFT JOIN `fichas` ON solicitudes.id_ficha = fichas.id  WHERE id_user =24
        $this->load->database();
        /* $this->db->select('*')->from('solicitudes');
          $this->db->where('Id_user', $id); */
        //aca modifique agregue solicitudes.paginas,
        $query = $this->db->query('SELECT solicitudes.id, solicitudes.fecha, solicitudes.estado,solicitudes.paginas,solicitudes.comentarios, fichas.titulo FROM `solicitudes` LEFT JOIN `fichas` ON solicitudes.id_ficha = fichas.id  WHERE id_user = ' . $id . ' LIMIT ' . $index . ',' . $regmax);
        return $query->result_array();
    }

    function get_solicitud_by_id($id) {
        $this->load->database();
        $this->db->select('*')->from('solicitudes');
        $this->db->where('Id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_solicitud_by_id($id, $estado, $comentarios, $fecha, $id_admin) {
        $mensaje['Estado'] = '';
        $mensaje['Comentarios'] = $comentarios;
        if ($estado == 0) {
            $mensaje['Estado'] = 'aprobada';
        } else if ($estado == 1) {
            $mensaje['Estado'] = 'denegada';
        }
        //  $this->load->database();

        $query = $this->get_solicitud_by_id($id);

        if (!($query['Estado'] === $mensaje['Estado'] && $query['Comentarios'] === $comentarios)) {
            $this->db->where('Id', $id);
            $this->db->update('solicitudes', $mensaje);

            $mensaje2['id_solicitud'] = $id;
            $mensaje2['id_admin'] = $id_admin;
            $mensaje2['modificacion'] = $mensaje['Estado'];
            $mensaje2['fecha_mod'] = $fecha;
            $mensaje2['comentarios'] = $comentarios;
            $this->db->insert('detalle_solicitudes', $mensaje2);
        }
    }

    function update_solicitud_by_user($id, $estado) {
        // $id es el id del usuario, se denegaran las solicitudes PENDIENTES del usuario baneado
        $mensaje['Estado'] = '';
        if ($estado == 0) {
            $mensaje['Estado'] = 'aprobada';
        } else if ($estado == 1) {
            $mensaje['Estado'] = 'denegada';
        }
        $this->load->database();
        $this->db->where('Id_user', $id);
        $this->db->where('Estado', 'pendiente');
        $this->db->update('solicitudes', $mensaje);
    }

    function insert_ficha($datos) {
        $this->load->database();
        $this->db->select('*')->from('fichas');
        $this->db->where('Titulo', $datos['Titulo']);
        $this->db->where('Autor', $datos['Autor']);
        $query = $this->db->get();
        //insertar id_user, id_ficha , estado, fecha . en tabla solicitudes  si no existe duplicado
        if ($query->num_rows() == 0) {
            $this->db->insert('fichas', $datos);
        }
    }

    function get_user_accounts() {
        // Select user data to be displayed.
        $sql_select = array(
            $this->flexi_auth->db_column('user_acc', 'id'),
            $this->flexi_auth->db_column('user_acc', 'email'),
            $this->flexi_auth->db_column('user_acc', 'suspend'),
            $this->flexi_auth->db_column('user_acc', 'username'),
            // 'uacc_identificacion',
            $this->flexi_auth->db_column('user_group', 'name'),
            'upro_first_name',
            'upro_last_name',
        );
        $this->flexi_auth->sql_select($sql_select);

        // For this example, prevent any 'Master Admin' users (User group id of 3) being listed to non 'Master Admin' users.
        if (!$this->flexi_auth->in_group('Master Admin')) {
            $sql_where[$this->flexi_auth->db_column('user_group', 'id') . ' !='] = 3;
            $this->flexi_auth->sql_where($sql_where);
        }

        // Get url for any search query or pagination position.
        $uri = $this->uri->uri_to_assoc(3);

        // Set pagination limit, get current position and get total users.
        $limit = 10;
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;

        // Set SQL WHERE condition depending on whether a user search was submitted.
        if (array_key_exists('search', $uri)) {
            // Set pagination url to include search query.
            $pagination_url = 'usuario_admin/administrar_usuarios/search/' . $uri['search'] . '/';
            $config['uri_segment'] = 6; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.
            // Convert uri '-' back to ' ' spacing.
            $search_query = str_replace('-', ' ', $uri['search']);

            // Get users and total row count for pagination.
            // Custom SQL SELECT, WHERE and LIMIT statements have been set above using the sql_select(), sql_where(), sql_limit() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $this->flexi_auth->sql_like('uacc_username', $search_query);
            $total_users = $this->flexi_auth->search_users_query()->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['users'] = $this->flexi_auth->search_users_array();
        } else {
            // Set some defaults.
            $pagination_url = 'usuario_admin/administrar_usuarios/';
            $search_query = FALSE;
            $config['uri_segment'] = 4; // Changing to 4 will select the 4th segment, example 'controller/function/page/10'.
            // Get users and total row count for pagination.
            // Custom SQL SELECT and WHERE statements have been set above using the sql_select() and sql_where() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $total_users = $this->flexi_auth->get_users_query()->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['users'] = $this->flexi_auth->get_users_array();
        }

        // Create user record pagination.
        $this->load->library('pagination');
        $config['base_url'] = base_url() . $pagination_url . 'page/';
        $config['total_rows'] = $total_users;
        $config['per_page'] = $limit;
        //aca modifique
        $config['cur_tag_open'] = '<strong class="active item">';
        $config['cur_tag_close'] = '</strong>';
        $config['anchor_class'] = 'class="item"';
        $this->pagination->initialize($config);

        // Make search query and pagination data available to view.
        $this->data['search_query'] = $search_query; // Populates search input field in view.
        $this->data['pagination']['links'] = $this->pagination->create_links();
        $this->data['pagination']['total_users'] = $total_users;
    }

    // update accounts users
    function update_user_accounts() {
        // If user has privileges, delete users.
        if ($this->flexi_auth->is_privileged('Delete Users')) {
            if ($delete_users = $this->input->post('delete_user')) {
                foreach ($delete_users as $user_id => $delete) {
                    // Note: As the 'delete_user' input is a checkbox, it will only be present in the $_POST data if it has been checked,
                    // therefore we don't need to check the submitted value.
                    $this->flexi_auth->delete_user($user_id);
                }
            }
        }

        // Update User Suspension Status.
        // Suspending a user prevents them from logging into their account.
        if ($user_status = $this->input->post('suspend_status')) {
            // Get current statuses to check if submitted status has changed.
            $current_status = $this->input->post('current_status');

            foreach ($user_status as $user_id => $status) {
                if ($current_status[$user_id] != $status) {
                    if ($status == 1) {
                        $this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 1));
                        $this->update_solicitud_by_user($user_id, 1);
                    } else {
                        $this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 0));
                    }
                }
            }
        }

        // Save any public or admin status or error messages to CI's flash session data.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        // Redirect user.
        redirect('usuario_admin/administrar_usuarios');
    }

    function update_group_privileges($group_id) {
        // Update privileges.
        foreach ($this->input->post('update') as $row) {
            if ($row['current_status'] != $row['new_status']) {
                // Insert new user privilege.
                if ($row['new_status'] == 1) {
                    $this->flexi_auth->insert_user_group_privilege($group_id, $row['id']);
                }
                // Delete existing user privilege.
                else {
                    $sql_where = array(
                        $this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $group_id,
                        $this->flexi_auth->db_column('user_privilege_groups', 'privilege_id') => $row['id']
                    );

                    $this->flexi_auth->delete_user_group_privilege($sql_where);
                }
            }
        }

        // Save any public or admin status or error messages to CI's flash session data.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        // Redirect user.
        redirect('usuario_admin/administrar_grupos');
    }

    function get_numero_solicitudes() {
        // $datos;
        $this->db->where('Estado', 'aprobada');
        $this->db->from('solicitudes');
        $datos['naprob'] = $this->db->count_all_results();

        $this->db->where('Estado', 'denegada');
        $this->db->from('solicitudes');
        $datos['ndeneg'] = $this->db->count_all_results();

        $this->db->where('Estado', 'pendiente');
        $this->db->from('solicitudes');
        $datos['npendi'] = $this->db->count_all_results();

        return $datos;
    }

    function get_number_logins_by_date($eleccion, $opcion) {

        if ($eleccion) {
            // eleccion anual
            $data = $this->get_number_months();
            $resultado = '';

            $fechamin = new DateTime($data['fechamin']);
            $fechamax = new DateTime($data['fechamax']);

            $string2 = strtotime($fechamax->format('Y-m'));

            while (true) {
                $mes = $fechamin->format('m');
                $año = $fechamin->format('Y');
                $resultado = $resultado . ' SUM(IF(month(fecha_login) = ' . $mes . ' AND year(fecha_login) = ' . $año . ' ,numero_logins,0)) as "' . $fechamin->format('Y-m') . '",';

                $interval = new DateInterval('P1M');
                $fechamin->add($interval);

                $string = strtotime($fechamin->format('Y-m'));
                if ($string > $string2) {

                    break;
                }
            }

            $resultado = rtrim($resultado, ',');
            $query = $this->db->query('SELECT ' . $resultado . ' FROM `estadisticas`');
            return $query->row_array();
        } else {
            //buscar año y mes

            $fecha = new DateTime($opcion);
            $mes = $fecha->format('m');
            $año = $fecha->format('Y');

            $query = $this->db->query('SELECT * FROM `estadisticas` WHERE month(fecha_login) = ' . $mes . ' AND year(fecha_login) = ' . $año);

            return $query->result_array();
        }
    }

    function get_number_months() {

        $query = $this->db->query('select TIMESTAMPDIFF(MONTH, min(fecha_login), max(fecha_login)) as meses,
DATE_FORMAT(min(fecha_login), "%Y-%m") as fechamin , 
DATE_FORMAT(max(fecha_login), "%Y-%m") as fechamax 
 from estadisticas');

        return $query->row_array();
    }

    function insert_login($fecha) {

        $this->db->select('*')->from('estadisticas');
        $this->db->where('fecha_login', $fecha);

        $esta = $this->db->get();

        if ($esta->num_rows() == 0) {
            $datos['fecha_login'] = $fecha;
            $datos['numero_logins'] = 1;
            $this->db->insert('estadisticas', $datos);
            return true;
        } elseif ($esta->num_rows() > 0) {
            $hey = $esta->row_array();
            $data['numero_logins'] = $hey['numero_logins'] + 1;
            $this->db->where('id', $hey['id']);
            $this->db->update('estadisticas', $data);

            return true;
        }


        return false;
    }

    function get_solicitud_contigua($id, $boton, $estado) {
        $string = '';

        if ($estado === 'p') {

            $string = 'solicitudes.estado = "pendiente" AND ';
        }
        if ($estado === 'a') {

            $string = 'solicitudes.estado = "aprobada" AND ';
        }
        if ($estado === 'd') {

            $string = 'solicitudes.estado = "denegada" AND ';
        }

        //$this->load->database();
        if ($boton) {
            //boton atras
            $query = $this->db->query('SELECT * FROM solicitudes WHERE ' . $string . 'solicitudes.id < ' . $id . ' ORDER BY solicitudes.id DESC LIMIT 1');
            if ($query->num_rows() > 0) {
                $array = $query->row_array();
                return $array['Id'];
            } else {

                return -1;
            }
        } else {
            // boton siguiente
            $query = $this->db->query('SELECT * FROM solicitudes WHERE ' . $string . 'solicitudes.id > ' . $id . ' ORDER BY solicitudes.id LIMIT 1');
            if ($query->num_rows() > 0) {
                $array = $query->row_array();
                return $array['Id'];
            } else {

                return -1;
            }
        }
    }

    function get_fichas($index, $numregistros, $id) {

        $this->load->database();

        //Query para cuando no hay id de busqueda
        $where = empty($id) ? '' : 'WHERE fichas.Id LIKE "' . $id . '%"';
        $query = $this->db->query('SELECT * FROM `fichas` ' . $where . ' ORDER BY fichas.Id DESC LIMIT ' . $index . ',' . $numregistros);
        return $query->result_array();
    }

    function actualizar_ficha($id, $datos, $pathvacio) {
        // $id es el id del usuario, se denegaran las solicitudes PENDIENTES del usuario baneado
        //falta borrar el archivo antiguo
        $this->load->database();

        $query = $this->db->query("Select * from fichas where Id = " . $id);
        if ($query->num_rows() > 0) {
            $array = $query->row_array();

            if (file_exists($array['Path']) && $pathvacio) {
                unlink($array['Path']);
            }


            $this->db->where('Id', $id);
            $this->db->update('fichas', $datos);
        }
    }

    function get_ultima_ficha() {

        $this->load->database();

        $query = $this->db->query("SELECT fichas.Id from fichas ORDER BY fichas.id DESC LIMIT 1");

        if ($query->num_rows() > 0) {

            $resultado = $query->row_array();

            return $resultado;
        }

        return false;
    }

    function get_programas($where = false) {

        $this->load->database();

        if (!$where) {

            $this->db->select('*')->from('programas');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $resultado = $query->result_array();

                return $resultado;
            }

            return false;
            
        } else {

            $this->db->select('*')->from('programas')->where('id', $where);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $resultado = $query->row_array();

                return $resultado;
            }

            return false;
        }
    }

}
