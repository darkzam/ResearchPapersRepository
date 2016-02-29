<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        // Load required CI libraries and helpers.
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

        // Check user is logged in as an admin.
        // For security, admin users should always sign in via Password rather than 'Remember me'.
        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin()) {
            // Set a custom error message.
            $this->flexi_auth->set_error_message('Debes iniciar sesión como administrador para acceder a este área', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('usuario');
        }

        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', 'http://sistemaconsultas.com/');
        $this->load->vars('includes_dir', 'http://sistemaconsultas.com/includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));

        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
    }

    function index() {

        $this->dashboard();
    }

    function dashboard() {

        $this->data['message'] = $this->session->flashdata('message');
        $this->data['test'] = $this->auth->session_data;

        $this->load->view('usuarios/admin/tablero_admin', $this->data);
    }

    function manage_request() {
        $this->load->model('usuario_model');
        $this->data['numpagina'] = $this->input->post('clave');
        $this->data['fila'] = $this->input->post('fila');
        $this->data['regmax'] = $this->input->post('regmax');
        $festado = $this->input->post('festado');
        $fuser = $this->input->post('fuser');

        //$this->load->library('pagination');
        //$config['base_url'] = base_url().'usuario_admin/manage_request';
        $this->data['title'] = 'Administrar Solicitudes';
        //devolver las solicitudes pendientes, aprobadas y denegadas.
        //$this->data['solicitudes'] = $this->usuario_model->get_solicitudes();
        //aca modigique

        $this->data['solicitudes'] = $this->usuario_model->get_solicitudes($this->data['fila'], $this->data['regmax'] + 1, $festado, $fuser);
        //$this->data['solicitudes'] = null;
        $this->load->view('usuarios/admin/manage_request', $this->data);
    }

    function request_background() {
        if (!$this->flexi_auth->is_privileged('Administrar Solicitudes')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin');
        }
        $this->load->view('usuarios/admin/background', $this->data);
    }

    //devuelve datos para el emergente de aprobar o denegar solicitud
    function get_request_data() {
        $idsol = $this->input->post('clave');
        $this->load->model('usuario_model');
        $this->data['solicitud'] = $this->usuario_model->get_solicitud_by_id($idsol);
        $usuario = $this->flexi_auth->get_user_by_id($this->data['solicitud']['Id_user']);
        $this->data['user'] = $usuario->row_array();
        $this->data['tesis'] = $this->usuario_model->show_ficha_by_id($this->data['solicitud']['Id_ficha']);
        $this->load->view('usuarios/admin/analizar_solicitud', $this->data);
    }

    function aprobar() {
        $estado = 0;
        $comentarios = $this->input->post('observacion');
        $id = $this->input->post('clave');
        $id_admin = $this->flexi_auth->get_user_id();
        $date = date('Y/m/d', time());
        $this->load->model('usuario_model');
        $this->usuario_model->update_solicitud_by_id($id, $estado, $comentarios, $date, $id_admin);
    }

    function denegar() {
        $estado = 1;
        $id = $this->input->post('clave');
        $comentario = $this->input->post('observacion');
        $date = date('Y/m/d', time());
        $id_admin = $this->flexi_auth->get_user_id();
        $this->load->model('usuario_model');
        $this->usuario_model->update_solicitud_by_id($id, $estado, $comentario, $date, $id_admin);
    }

    function historial_solicitud() {

        $id = $this->input->post('clave');
        $this->load->model('usuario_model');
        $this->data['detalles'] = $this->usuario_model->get_historial_by_id($id);
        $this->load->view('usuarios/admin/historia_solicitud', $this->data);
    }

    function gestionar_tesis() {
        if (!$this->flexi_auth->is_privileged('Gestionar Tesis')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin');
        }
        $this->data['msg'] = '';
        $this->load->model('usuario_model');
        $this->data['programas'] = $this->usuario_model->get_programas();
        $this->load->view('usuarios/admin/gestionar_tesis', $this->data);
    }

    function upload_file() {
        //Configure
        //set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777
        //necesita darle permisos a la carpeta para poder subir el archivo 777 en linux

        $this->data['msg'] = '';
        $this->data['nombre'] = 'no hay titulo en el momento';

        // set the filter image types
        // $config['allowed_types'] = 'gif|jpg|png';

        $this->form_validation->set_rules('titulo', 'Titulo', 'required');
        $this->form_validation->set_rules('autor', 'Autor', 'required');
        $this->form_validation->set_rules('director', 'Director', 'required');
        $this->form_validation->set_rules('ano', 'Año', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('resumen', 'Resumen', 'required');
        $this->form_validation->set_rules('keywords', 'Palabras Claves', 'required');
        $this->form_validation->set_rules('programa', 'Programa', 'required|integer|greater_than[-1]|less_than[5]');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('usuarios/admin/gestionar_tesis', $this->data);
        } else {
            //load the upload library

            $this->load->model('usuario_model');

            if (!empty($_FILES['userfile']['name'])) {

                $idprograma = $this->input->post('programa');
                $programa = $this->usuario_model->get_programas($idprograma);

//                $nombres = ['ADMINISTRACION DE EMPRESAS', 'CONTADURIA PUBLICA', 'EDU FISICA', 'INGENIERIA  INDUSTRIAL', 'PSICOLOGIA'];
                //verificar que exista el directorio
                if (!is_dir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'))) {

                    $oldmask = umask(0);
                    mkdir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'), 0777, TRUE);
                    umask($oldmask);
                }
                $config['remove_spaces'] = false;
                $config['upload_path'] = "/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano');
                $config['allowed_types'] = 'pdf';
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->set_allowed_types('pdf');
                //if not successful, set the error message
                if (!$this->upload->do_upload('userfile')) {
                    $this->data['msg'] = $this->upload->display_errors('<div class="ui negative message">', '</div>');
                } else { //else, set the success message
                    $datosarchivo = $this->upload->data();
                    $nombrearchivo = $datosarchivo['file_name'];
                    $datos['Titulo'] = $this->input->post('titulo');
                    $datos['Autor'] = $this->input->post('autor');
                    $datos['Director'] = $this->input->post('director');
                    $datos['Año'] = $this->input->post('ano');
                    $datos['Resumen'] = $this->input->post('resumen');
                    $datos['Keywords'] = $this->input->post('keywords');
                    $datos['Programa'] = $this->input->post('programa');
                    $datos['Path'] = $nombrearchivo;
                    // $this->load->model('usuario_model');
                    $this->usuario_model->insert_ficha($datos);
                    $ultimo = $this->usuario_model->get_ultima_ficha();

                    $this->procesar_Trabajo_Grado($datosarchivo['full_path'], $ultimo['Id']);

                    $this->session->set_flashdata("success", "La tesis: <strong> ".$ultimo['Id']." - " . $datos['Titulo'] . "</strong><br> Ha sido creada con éxito.");
                    //  $this->session->set_flashdata("success","el path es ". $datosarchivo['full_path'] );

                    redirect('usuario_admin/gestionar_tesis');
                }

                $this->load->view('usuarios/admin/gestionar_tesis', $this->data);
            }
        }
    }

    function administrar_usuarios() {

        $this->load->model('usuario_model');

        // Check user has privileges to view user accounts, else display a message to notify the user they do not have valid privileges.
        if (!$this->flexi_auth->is_privileged('Administrar Usuarios')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin');
        }

        // If 'Admin Search User' form has been submitted, this example will lookup the users email address and first and last name.

        if ($this->input->post('search_users') && $this->input->post('search_query')) {
            // Convert uri ' ' to '-' spacing to prevent '20%'.
            // Note: Native php functions like urlencode() could be used, but by default, CodeIgniter disallows '+' characters.
            $search_query = str_replace(' ', '-', $this->input->post('search_query'));

            // Assign search to query string.
            redirect('usuario_admin/administrar_usuarios/search/' . $search_query . '/page/');
        }
        // If 'Manage User Accounts' form has been submitted and user has privileges to update user accounts, then update the account details.
        else if ($this->input->post('update_users') && $this->flexi_auth->is_privileged('Administrar Usuarios')) {
            $this->usuario_model->update_user_accounts();
        }

        // Get user account data for all users. 
        // If a search has been performed, then filter the returned users.
        $this->usuario_model->get_user_accounts();

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('usuarios/admin/administrar_usuarios', $this->data);
    }

    function edit_user($id) {

        if ($id === null) {
            redirect('usuario_admin/administrar_usuarios');
        }
        //sino tiene el privilegio de editar redirija al controlador
        //cojer el post 

        $user = $this->flexi_auth->get_user_by_id($id)->row_array();

        if (!$user) {

            redirect('usuario_admin/administrar_usuarios');
        }

        $this->data['nuevopassword'] = '';
        //  var_dump(  $this->data['user']);
        if ($this->input->post('resetearpass')) {

            $username = $this->input->post('update_username');
            $this->flexi_auth->forgotten_password($username);

            $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $count = mb_strlen($chars);

            for ($i = 0, $result = ''; $i < 8; $i++) {
                $index = rand(0, $count - 1);
                $result .= mb_substr($chars, $index, 1);
            }

            $this->flexi_auth->forgotten_password_complete($id, $result);
            $this->data['nuevopassword'] = $result;
        }

        if ($this->input->post('update_account')) {
            $this->load->model('usuario_model');
            $this->usuario_model->update_account_by_admin($id);
        }
        $this->data['user'] = $user;
        //llamar base de datos con el id
        //cargar a la vista mostrar datos
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('usuarios/admin/edit_user', $this->data);
    }

    function administrar_grupos() {
        // Check user has privileges to view user groups, else display a message to notify the user they do not have valid privileges.
        if (!$this->flexi_auth->is_privileged('Administrar Grupos de Usuarios')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin');
        }

        // If 'Manage User Group' form has been submitted and user has privileges, delete user groups.
        // Define the group data columns to use on the view page. 
        // Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
        // Read more on 'db_column()' functions in the quick help section near the top of this controller. 
        $sql_select = array(
            $this->flexi_auth->db_column('user_group', 'id'),
            $this->flexi_auth->db_column('user_group', 'name'),
            $this->flexi_auth->db_column('user_group', 'description'),
            $this->flexi_auth->db_column('user_group', 'admin')
        );
        $this->data['user_groups'] = $this->flexi_auth->get_groups_array($sql_select);

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('usuarios/admin/administrar_grupos_view', $this->data);
    }

    function actualizar_permisos_grupos($group_id) {
        // Check user has privileges to update group privileges, else display a message to notify the user they do not have valid privileges.
        if (!$this->flexi_auth->is_privileged('Administrar Grupos de Usuarios')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin/administrar_grupos');
        }

        // If 'Update Group Privilege' form has been submitted, update the privileges of the user group.
        if ($this->input->post('update_group_privilege')) {
            $this->load->model('usuario_model');
            $this->usuario_model->update_group_privileges($group_id);
        }

        // Get data for the current user group.
        $sql_where = array($this->flexi_auth->db_column('user_group', 'id') => $group_id);
        $this->data['group'] = $this->flexi_auth->get_groups_row_array(FALSE, $sql_where);

        // Get all privilege data. 
        $sql_select = array(
            $this->flexi_auth->db_column('user_privileges', 'id'),
            $this->flexi_auth->db_column('user_privileges', 'name'),
            $this->flexi_auth->db_column('user_privileges', 'description')
        );
        $this->data['privileges'] = $this->flexi_auth->get_privileges_array($sql_select);

        // Get data for the current privilege group.
        $sql_select = array($this->flexi_auth->db_column('user_privilege_groups', 'privilege_id'));
        $sql_where = array($this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $group_id);
        $group_privileges = $this->flexi_auth->get_user_group_privileges_array($sql_select, $sql_where);

        // For the purposes of the example demo view, create an array of ids for all the privileges that have been assigned to a privilege group.
        // The array can then be used within the view to check whether the group has a specific privilege, this data allows us to then format form input values accordingly. 
        $this->data['group_privileges'] = array();
        foreach ($group_privileges as $privilege) {
            $this->data['group_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_groups', 'privilege_id')];
        }

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        // For demo purposes of demonstrate whether the current defined user privilege source is getting privilege data from either individual user 
        // privileges or user group privileges, load the settings array containing the current privilege sources. 
        $this->data['privilege_sources'] = $this->auth->auth_settings['privilege_sources'];

        $this->load->view('usuarios/admin/actualizar_permisos_grupos_view', $this->data);
    }

    function estadisticas() {
        $this->load->view('usuarios/admin/estadisticas_view');
    }

    function get_estadisticas() {
        $this->load->model('usuario_model');
        $datos = $this->usuario_model->get_numero_solicitudes();

        echo json_encode($datos);
        // $this->load->view('usuarios/admin/estadisticas_tabla', $datos);
    }

    function get_estadisticas_ingresos() {
        $this->load->model('usuario_model');
        $parametro = $this->input->post('opcion1');
        $mes = $this->input->post('opcion2');
        $datos = $this->usuario_model->get_number_logins_by_date($parametro, $mes);

        echo json_encode($datos);
    }

    function get_solicitud_sgte_atras() {

        $idsol = $this->input->post('id');
        $boton = $this->input->post('boton');
        $estado = $this->input->post('estado');
        $this->load->model('usuario_model');
        $resultado = $this->usuario_model->get_solicitud_contigua($idsol, $boton, $estado);

        echo json_encode($resultado);
    }

    function modificar_tesis() {
        if (!$this->flexi_auth->is_privileged('Gestionar Tesis')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_admin');
        }
        $this->data['msg'] = '';
        $this->load->model('usuario_model');
        $this->data['programas'] = $this->usuario_model->get_programas();
        $this->load->view('usuarios/admin/modificar_tesis', $this->data);
    }

    function get_tesis() {
        $this->data['fila'] = $this->input->post('fila');
        $this->data['regmax'] = $this->input->post('regmax');
        $idficha = $this->input->post('fid');


        $this->load->model('usuario_model');
        $this->data['tesis'] = $this->usuario_model->get_fichas($this->data['fila'], $this->data['regmax'] + 1, $idficha);

        $this->data['programas'] = $this->usuario_model->get_programas();
        $this->load->view('usuarios/admin/tabla_tesis', $this->data);
    }

    function ajax_tesis_id() {

        $id = $this->input->post('id');
        $this->load->model('usuario_model');
        $this->data['tesis'] = $this->usuario_model->show_ficha_by_id($id);
        $this->data['programas'] = $this->usuario_model->get_programas();
        $this->load->view('usuarios/admin/pestana_tesis', $this->data);
    }

    function visualizar($id) {
        //$id = $this->input->post('idficha');
        $this->load->model('usuario_model');
        $this->data['id'] = $id;
        $this->data['ficha'] = $this->usuario_model->show_ficha_by_id($id);
        $programa = $this->usuario_model->get_programas( $this->data['ficha']['Programa']);
        $this->push_file($this->data['ficha']['Path'], $this->data['ficha']['Año'], $programa['codigo']);
    }

    function push_file($name, $año, $codigo) {
        // make sure it's a file before doing anything!
        //$nombrearchivo = utf8_decode($name);
        $directoriobase = "/home/zamir/Documents/tesiscompletas/" . $codigo . "/" . $año . "/";
        $path = $directoriobase . urldecode($name);

        if (is_file($path)) {
            // required for IE
            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }

            // get the file mime type using the file extension
            $this->load->helper('file');

            $mime = get_mime_by_extension($path);

            // Build the headers to push out the file properly.
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
            header('Cache-Control: private', false);
            header('Content-Type: ' . $mime);  // Add the mime type from Code igniter.
            //header('Content-Type: application/pdf'); 
            header('Content-Disposition: inline; filename="' . $name . '"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        } else {
          
            echo "no se encontro el archivo: " . $path;
        }
    }

    function upload_file2() {
        //para modificar
        //Configure
        //set the path where the files uploaded will be copied. NOTE if using linux, set the folder to permission 777

        $this->data['msg'] = '';
        $this->data['nombre'] = 'no hay titulo en el momento';

        // set the filter image types
        // $config['allowed_types'] = 'gif|jpg|png';

        $this->form_validation->set_rules('titulo', 'Titulo', 'required');
        $this->form_validation->set_rules('autor', 'Autor', 'required');
        $this->form_validation->set_rules('director', 'Director', 'required');
        $this->form_validation->set_rules('ano', 'Año', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('resumen', 'Resumen', 'required');
        $this->form_validation->set_rules('keywords', 'Palabras Claves', 'required');
        $this->form_validation->set_rules('programa', 'Programa', 'required|integer|greater_than[-1]|less_than[6]');

        $this->load->model('usuario_model');

        if ($this->form_validation->run() == FALSE) {

            if (empty($_FILES['userfile']['name']) && empty(validation_errors())) {
                $this->data['msg'] = "<div class='ui negative message'>No se pudo leer el pdf, agregue permisos de lectura al archivo.</div>";
            }
            $this->data['programas'] = $this->usuario_model->get_programas();
            $this->load->view('usuarios/admin/modificar_tesis', $this->data);
        } else {
            //load the upload library
            //se obtiene el codigo del nuevo programa a actualizar
            $idprograma = $this->input->post('programa');
            $programa = $this->usuario_model->get_programas($idprograma);

            if (!empty($_FILES['userfile']['name'])) {
                //imod
                //nuevo programa

                $directoriobase = "/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano');
                $config['allowed_types'] = 'pdf';
                $config['upload_path'] = $directoriobase;
                $config['remove_spaces'] = false;
                //entonces detectar si la nueva carpeta de programa existe, sino crearla para subir el archivo independientemente del archivo anterior
                if (!is_dir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'))) {

                    $oldmask = umask(0);
                    mkdir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'), 0777, TRUE);
                    umask($oldmask);
                }

                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->set_allowed_types('pdf');
                //if not successful, set the error message
                if (!$this->upload->do_upload('userfile')) {

                    $this->data['msg'] = $this->upload->display_errors('<div class="ui negative message">', '</div>');
                } else { //else, set the success message
                    //sacar datos anteriores de la ficha
                    $ficha = $this->usuario_model->show_ficha_by_id($this->input->post('identificacion'));
                    //sacar el codigo del programa viejo
                    $programaviejo = $this->usuario_model->get_programas($ficha['Programa']);

                    $datosarchivo = $this->upload->data();
                    //este es el nombre del archivo que va en el path
                    $path = $datosarchivo['file_name'];
                    $id = $this->input->post('identificacion');
                    $datos['Titulo'] = $this->input->post('titulo');
                    $datos['Autor'] = $this->input->post('autor');
                    $datos['Director'] = $this->input->post('director');
                    $datos['Año'] = $this->input->post('ano');
                    $datos['Resumen'] = $this->input->post('resumen');
                    $datos['Keywords'] = $this->input->post('keywords');
                    $datos['Path'] = $path;
                    $datos['Programa'] = $this->input->post('programa');
                    //        $this->load->model('usuario_model');
                    $this->usuario_model->actualizar_ficha($id, $datos, true);

                    //entonces detectar si el viejo archivo existe si existe borrarlo
                    //borrar el archivo completo anterior, manteniendo el folder
                    if (is_file("/home/zamir/Documents/tesiscompletas/" . $programaviejo['codigo'] . "/" . $ficha['Año'] . "/" . $ficha['Path'])) {

                        unlink("/home/zamir/Documents/tesiscompletas/" . $programaviejo['codigo'] . "/" . $ficha['Año'] . "/" . $ficha['Path']);
                    }
                    //borrar la antigua carpeta de id de las hojas para la visualizacion
                    if (is_dir("/home/zamir/Documents/tesishojas/" . $id)) {
                        //si existe borre el tesishojas/id/ y su contenido
                        $files = glob("/home/zamir/Documents/tesishojas/" . $id . "/*"); // get all file names
                        foreach ($files as $file) { // iterate files
                            if (is_file($file)) {
                                unlink($file); // delete file
                            }
                        }
                    }
                    //procesar tesis y agregar nuevas hojas
                    $this->procesar_Trabajo_Grado($datosarchivo['full_path'], $id);

                    $this->session->set_flashdata("success", "La tesis <b>" . $id . " - " . $datos['Titulo'] . "</b> fue modificada exitosamente con el nuevo archivo.");

                    redirect('usuario_admin/modificar_tesis');
                }

                $this->load->view('usuarios/admin/modificar_tesis', $this->data);
            } else {
                //se actualizan datos pero sin subir nuevo archivo
                //se verifica que exista el dir, sino existe se crea con permisos 0777
                if (!is_dir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'))) {

                    $oldmask = umask(0);
                    mkdir("/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano'), 0777, TRUE);
                    umask($oldmask);
                }
                //sacar el codigo del programa y año y archivo viejo
                $ficha = $this->usuario_model->show_ficha_by_id($this->input->post('identificacion'));
                $programaviejo = $this->usuario_model->get_programas($ficha['Programa']);
                //entonces detectar si el viejo archivo existe si existe borrarlo
                //si el archivo anterior existe, moverlo al nuevo directorio, luego eliminar el archivo anterior
                if (is_file("/home/zamir/Documents/tesiscompletas/" . $programaviejo['codigo'] . "/" . $ficha['Año'] . "/" . $ficha['Path'])) {

                    rename("/home/zamir/Documents/tesiscompletas/" . $programaviejo['codigo'] . "/" . $ficha['Año'] . "/" . $ficha['Path'], "/home/zamir/Documents/tesiscompletas/" . $programa['codigo'] . "/" . $this->input->post('ano') . "/" . $ficha['Path']);
                    //   unlink("/home/zamir/Documents/tesiscompletas/" . $programaviejo['codigo'] . "/" . $ficha['Año'] . "/" . $ficha['Path']);
                }

                $id = $this->input->post('identificacion');
                $datos['Titulo'] = $this->input->post('titulo');
                $datos['Autor'] = $this->input->post('autor');
                $datos['Director'] = $this->input->post('director');
                $datos['Año'] = $this->input->post('ano');
                $datos['Resumen'] = $this->input->post('resumen');
                $datos['Keywords'] = $this->input->post('keywords');
                $datos['Programa'] = $this->input->post('programa');

                $this->usuario_model->actualizar_ficha($id, $datos, false);

                $this->session->set_flashdata("success", "La tesis <b>" . $id . " - " . $datos['Titulo'] . "</b> fue modificada exitosamente.");
                redirect('usuario_admin/modificar_tesis');
            }
        }
    }

    function busqueda_ajax_tesis() {

        $this->load->model('usuario_model');
        $this->data['title'] = 'Resultados de Busqueda';
        $campos = array();
        $claves = $this->input->post('claves');
        $this->data['numpagina'] = $this->input->post('numpagina');
        // $string = $this->input->post('clave');
        //validar el array de claves
        foreach ($claves as $clave) {

            $string = strtolower($clave);
            $string = trim($string);
            $temp = explode(" ", $string);
            array_push($campos, $temp);
        }
        $this->data['fila'] = $this->input->post('fila');
        $this->data['regmax'] = $this->input->post('regmax');
        //busqueda de fichas con un array de palabras y un string con el nombre de columna
        $this->data['tesis'] = $this->usuario_model->show_fichas($campos, $this->data['fila'], $this->data['regmax'] + 1);
        $this->data['programas'] = $this->usuario_model->get_programas();

        $this->load->view('usuarios/admin/tabla_tesis', $this->data);
    }

    private function procesar_Trabajo_Grado($path, $id) {

        //aumentamos el tiempo de ejecucioin del script por si demora mucho -1 es sin limite
        ini_set('MAX_EXECUTION_TIME', -1);
        //ver si existe la carpeta Id en tesishojas Sino esta creela con los permisos 777
        if (!is_dir("/home/zamir/Documents/tesishojas/" . $id)) {
            $oldmask = umask(0);
            mkdir("/home/zamir/Documents/tesishojas/" . $id, 0777, TRUE);
            umask($oldmask);
        }

        exec('gs -sDEVICE=pdfwrite -dSAFER -o "/home/zamir/Documents/tesishojas/' . $id . '/hoja-%d.pdf" "' . $path . '"');
    }

    function logout() {
        // By setting the logout functions argument as 'TRUE', all browser sessions are logged out.

        $this->flexi_auth->logout(TRUE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('usuario');
    }

    /*
      function convertirTesis() {

      //url = ADMINISTRACION DE EMPRESAS\2010\CARACTERIZACIÓN DEL SECTOR TURISMO.pdf
      //   ini_set('MAX_EXECUTION_TIME', -1);
      $this->load->model('usuario_model');

      for($id = 293; $id < 862 ; $id ++){
      $ficha = $this->usuario_model->show_ficha_by_id($id);
      if (!empty($ficha)) {

      $pathAnterior = $ficha['Path'];
      $pathAnterior = utf8_decode($pathAnterior);
      $pathAnterior = urldecode($pathAnterior);

      //  $string = 'http://' . $pathAnterior;
      //  $array = parse_url($string);
      //  $host = str_replace(' ', '', $array['host']);

      //   $path = str_replace('/', '//', $array['path']);
      //   $nuevo = $array['host'] . $array['path'];

      if (!is_dir("application/tesishojas/".$ficha['Id'] )) {
      mkdir("application/tesishojas/" . $ficha['Id'], 0777, TRUE);
      }


      exec('gswin64c -sDEVICE=pdfwrite -dSAFER -o "c:/Xampp/htdocs/SistemaConsultas/application/tesishojas/'.$ficha['Id'].'/hoja-%d.pdf" "c:/Xampp/htdocs/SistemaConsultas/application/tesis/'.$pathAnterior.'"');
      }
      }
      } */
}
