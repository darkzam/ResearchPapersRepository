<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario_public extends CI_Controller {

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
        $this->load->helper('text');

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');

        // Check user is logged in via either password or 'Remember me'.
        // Note: Allow access to logged out users that are attempting to validate a change of their email address via the 'update_email' page/method.
        if (!$this->flexi_auth->is_logged_in()) {
            // Set a custom error message.
            $this->flexi_auth->set_error_message('Debes loguearte para acceder a este area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('usuario');
        }

        if ($this->flexi_auth->is_admin()) {
            redirect('usuario_admin/dashboard');
        }

        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', 'http://sistemaconsultas.com/');
        $this->load->vars('includes_dir', 'http://sistemaconsultas.com/includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));
        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        // $this->data['busqueda']= null;
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // flexi auth demo
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * Many of the functions within this controller load a custom model called 'demo_auth_model' that has been created for the purposes of this demo.
     * The 'demo_auth_model' file is not part of the flexi auth library, it is included to demonstrate how some of the functions of flexi auth can be used.
     *
     * These demos show working examples of how to implement some (most) of the functions available from the flexi auth library.
     * This particular controller 'auth_public', is used by users who have logged in and now wish to manage their account settings
     * 
     * All demos are to be used as exactly that, a demonstation of what the library can do.
     * In a few cases, some of the examples may not be considered as 'Best practice' at implementing some features in a live environment.
     */
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Dashboard
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * index
     * Forwards to the public dashboard.
     */
    function index() {
        $this->dashboard();
    }

    /**
     * dashboard (Public)
     * The public account dashboard page that acts as the landing page for newly logged in public users.
     * The dashboard provides links to some examples of the features available from the flexi auth library.  
     */
    function dashboard() {
        // Get any status message that may have been set.
        $this->data['message'] = $this->session->flashdata('message');

        $this->load->view('usuarios/public/tablero_public', $this->data);
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Public Account Management
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * update_account
     * Manage and update the account details of a logged in public user.
     */
    function update_account() {
        if (!$this->flexi_auth->is_privileged('Actualizar Perfil')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_public');
        }
         $this->load->model('usuario_model');
        // If 'Update Account' form has been submitted, update the user account details.
        if ($this->input->post('update_account')) {
           
            $this->usuario_model->update_account();
        }
        $this->data['programas'] = $this->usuario_model->get_programas();
        // Get users current data.
        // This example does so via 'get_user_by_identity()', however, 'get_users()' using any other unqiue identifying column and value could also be used.
        $this->data['user'] = $this->flexi_auth->get_user_by_identity_row_array();

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];


        $this->load->view('usuarios/public/accupdate_public', $this->data);
    }

    function logout() {
        // By setting the logout functions argument as 'TRUE', all browser sessions are logged out.

        $this->flexi_auth->logout(TRUE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect('usuario');
    }

    function change_password() {
        // If 'Update Password' form has been submitted, validate and then update the users password.
        if ($this->input->post('change_password')) {
            $this->load->model('usuario_model');
            $this->usuario_model->change_password();
        }

        // Set any returned status/error messages.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('usuarios/public/passupdate_public', $this->data);
    }

    function search_by() {
        if (!$this->flexi_auth->is_privileged('Buscar Tesis')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_public');
        }
        //si el boton submit buscar ha sido presionado, 
        //    $this->load->model('usuario_model');
        $this->load->view('usuarios/public/search_by');
    }

    function get_list_view() {

        $this->load->model('usuario_model');
        $this->data['title'] = 'Lista de Trabajos de Grado';
        $this->data['resultados'] = $this->usuario_model->show_all();
        $this->data['numpagina'] = $this->input->post('clave');
        $this->load->view('usuarios/tabla2', $this->data);
    }

    function buscar() {
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
        $this->data['resultados'] = $this->usuario_model->show_fichas($campos, $this->data['fila'], $this->data['regmax'] + 1);
        $this->load->view('usuarios/tabla2', $this->data);
    }

    function getbyId() {
        $this->load->model('usuario_model');
        $id = $this->input->post('claves');
        $this->data['ficha'] = $this->usuario_model->show_ficha_by_id($id);
        $this->load->view('usuarios/public/popup', $this->data);
    }

    function request_tg() {
        $this->load->model('usuario_model');
        $id = $this->input->post('claves');
        $this->data['user'] = $this->flexi_auth->get_user_by_identity_row_array();
        $this->data['ficha'] = $this->usuario_model->show_ficha_by_id($id);
        $this->load->view('usuarios/public/request', $this->data);
    }

    function crear_solicitud() {
        $this->load->model('usuario_model');
        // $datos['Id_user'] = $this->input->post('Id_user');
        $datos['Id_user'] = $this->flexi_auth->get_user_id();
        $datos['Id_ficha'] = $this->input->post('Id_ficha');
        $date = date('Y/m/d', time());
        $datos['Fecha'] = $date;
        $datos['Estado'] = 'pendiente';
        // aca modifique
        $datos['Paginas'] = $this->input->post('Paginas');
        //$this->usuario_model->insert_solicitud($datos);
        //aca modifique2
        $this->data['notificacion'] = $this->usuario_model->insert_solicitud($datos);
        $this->load->view('usuarios/public/notificacion', $this->data);
    }

    function get_request_status() {
        $this->load->model('usuario_model');
        $this->data['title'] = 'Mis solicitudes';
        $this->data['fila'] = $this->input->post('fila');
        $this->data['regmax'] = $this->input->post('regmax');
        $this->data['user'] = $this->flexi_auth->get_user_by_identity_row_array();
        $this->data['solicitudes'] = $this->usuario_model->get_solicitudes_by_user($this->data['user']['uacc_id'], $this->data['fila'], $this->data['regmax'] + 1);
        $this->load->view('usuarios/public/tablasolicitudes', $this->data);
    }

    function check_request_status() {
        if (!$this->flexi_auth->is_privileged('Consultar Estado de Solicitudes')) {
            $this->session->set_flashdata('message', '<p class="error_msg">No tienes los permisos suficientes para esta accion.</p>');
            redirect('usuario_public');
        }
        $this->load->view('usuarios/public/solicitudes');
    }

    function visualizar($id) {
        //$id = $this->input->post('idficha');
        $this->load->model('usuario_model');
        $this->data['id'] = $id;
        $this->data['ficha'] = $this->usuario_model->show_ficha_by_id($id);
        //  $this->load->view('fallo', $this->data);
        //  $this->push_file($this->data['ficha']['Path'], 'Ajedrez.pdf');
        $this->push_file($this->data['ficha']['Path'], 'temp.pdf');
    }

    function push_file($string, $name) {
        // make sure it's a file before doing anything!

        $path = utf8_decode($string);
        $directoriobase = "./application/tesis/";
        $path = $directoriobase . urldecode($path);


        //is_file($path)
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
            header('Content-Disposition: inline; filename="' . basename($name) . '"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        }
    }

    function viewpdf() {
        if ($this->input->post('idtg')) {
            $this->data['idtg'] = $this->input->post('idtg');

            $this->load->view('usuarios/public/verpdf', $this->data);
        } else {

            redirect(base_url() . "usuario_public/search_by");
        }
    }

    function pdfajax() {

        $idtg = $this->input->post('idtg');
        $pagina = $this->input->post('pagina');

        /*    $this->load->model('usuario_model');
          $ficha = $this->usuario_model->show_ficha_by_id($idtg);
          $string = $ficha['Path'];

          $path = utf8_decode($string); */
        //   $directoriobase = "./application/tesishojas/";
        //  $directoriobase = "C:/Users/Zamir/tesishojas/";
        $directoriobase = "/home/zamir/Documents/tesishojas/";
        $path = $directoriobase . $idtg . "/hoja-" . $pagina . ".pdf";

        //evaluar si existe la hoja en tesishojas original
        if (is_file($path)) {

            //  $nombre = basename($path, ".pdf");
            //  $tempPath = "./includes/pdftemp/" . $nombre . "-" . $pagina . ".pdf";
            // $this->load->library('fpdf/Pdf');
            // $this->load->library('pdfi/Pdfi');
            // $pageCount = $this->pdfi->setSourceFile($path);

            /*  if (!is_file($tempPath)) {

              $hey = $this->pdfi->importPage($pagina, '/MediaBox');
              $this->pdfi->AddPage();
              $this->pdfi->useTemplate($hey, 1, 1, 210);
              $this->pdfi->Output($tempPath, 'F');
              } */
            //despues de crear el archivo borrar el anterior
            //   $datos['path'] = "." . $tempPath;
            // $string = substr($tempPath, 2);
            //   $datos['path'] = $path;
            // $datos['totalpaginas'] = $pageCount;

            $foo = new FilesystemIterator(dirname($path), FilesystemIterator::SKIP_DOTS);
            $datos['npaginas'] = iterator_count($foo);

            //evaluar si existe la CARPETA id en el TEMPORAL
            if (!is_dir("./includes/pdftemp/" . $idtg)) {
                mkdir("./includes/pdftemp/" . $idtg, 0777, TRUE);
                $datos['msg'] = "se crea la carpeta id";
            }
            //evaluar si existe el ARCHIVO en la carpeta ID del TEMPORAL
            if (!is_file("./includes/pdftemp/" . $idtg . "/hoja-" . $pagina . ".pdf")) {

                copy($path, "./includes/pdftemp/" . $idtg . "/hoja-" . $pagina . ".pdf");

                $datos['msg2'] = "se copia el archivo";
            }
            $datos['existe'] = true;
            $datos['path'] = "../includes/pdftemp/" . $idtg . "/hoja-" . $pagina . ".pdf";
            echo json_encode($datos);
        } else {
            $datos['existe'] = false;
            echo json_encode($datos);
        }
    }

}
