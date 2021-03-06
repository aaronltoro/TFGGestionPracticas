<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\IOFactory;

class Practicas_controller extends CI_Controller
{

    var $err;
    var $filt = array();
    var $alumno = array();
    var $empresa = array();
    var $empleado = array();
    var $tutor = array();

    public function search_filters()
    {

        //Recojo los parametros enviados por ajax y los meto en un array
        $res = array(
            'tipo' => $this->input->post('filter_by'),
            'filtro' => $this->input->post('filter')
        );

        //Cargo los modelos de todas las tablas con claves foráneas
        $this->load->model('Alumno_model', 'Alumno_model', true);
        $this->load->model('Empresa_model', 'Empresa_model', true);
        $this->load->model('Empleado_model', 'Empleado_model', true);
        $this->load->model('Tutor_centro_model', 'Tutor_centro_model', true);

        //Variable que contiene todos los datos de la tabla (SOLO PARA COMPARAR)
        $compare = $this->compare();
        $compareAlu = $this->Alumno_model->get_todos_dev();
        $compareEmp = $this->Empresa_model->get_todos_dev();
        $compareEmpl = $this->Empleado_model->get_todos_dev();
        $compareTut = $this->Tutor_centro_model->get_todos_dev();

        //Variable que comprueba si hay algún error en el filtro
        $is_err = true;

        switch ($res['tipo']) {
            case '-1':
                //Llamo al modelo y lo que me devuelve lo seteo en la variable $this->prac que se enviará a la view resultado
                $this->load->model('Practicas_model', 'Practicas_model', true);
                $this->prac = $this->Practicas_model->get_todos();

                //Solo intercambia los id por nombre cuando exista al menos 1 Practica
                if (sizeof($this->prac) > 0) {
                    foreach ($this->prac as $key => $prac) {
                        //Función que intercambia el id_alumno por su nombre
                        $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                        $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                        //Función que intercambia el id_empresa por su nombre
                        $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                        $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                        //Función que intercambia el id_empleado por su nombre
                        $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                        $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                        //Función que intercambia el id_tutor_centro por su nombre
                        $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                        $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                    }
                }

                $this->load->view('Resultado_Practicas');
                break;
            case 'a':
                //Si el campo filtro no está vacío recorro todos los datos de la tabla y si encuentra alguno con el mismo nombre que pasó el usuario significa que existe
                if ($res['filtro'] != '') {
                    foreach ($compareAlu as $comp) {
                        if (str_contains($comp['nombre'], $res['filtro'])) {
                            $is_err = false;
                        }
                    }
                } else {
                    //Si el campo filtro está vacío $is_err valdrá false y los traerá todos de la base de datos, luego detiene la ejecución
                    $is_err = false;
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_todos();

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                    break;
                }

                //Si la variable de errores es false significa que no hay errores y por lo tanto llamo al modelo y lo que me devuelve lo seteo en la variable $this->prac que se enviará a la view resultado
                if (!$is_err) {
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_alumno($res['filtro']);

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                } else {
                    //Importante! Doy valor a la variable $this->err que se va a pasar a la view en caso de error
                    $this->err = 'El filtro solicitado no existe';
                    $this->load->view('Error_practicas');
                }
                break;
            case 'e':
                //Si el campo filtro no está vacío recorro todos los datos de la tabla y si encuentra alguno con el mismo nombre que pasó el usuario significa que existe
                if ($res['filtro'] != '') {
                    foreach ($compareEmp as $comp) {
                        if (str_contains($comp['nombre'], $res['filtro'])) {
                            $is_err = false;
                        }
                    }
                } else {
                    //Si el campo filtro está vacío $is_err valdrá false y los traerá todos de la base de datos, luego detiene la ejecución
                    $is_err = false;
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_todos();

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                    break;
                }

                //Si la variable de errores es false significa que no hay errores y por lo tanto llamo al modelo y lo que me devuelve lo seteo en la variable $this->prac que se enviará a la view resultado
                if (!$is_err) {
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_empresa($res['filtro']);

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                } else {
                    //Importante! Doy valor a la variable $this->err que se va a pasar a la view en caso de error
                    $this->err = 'El filtro solicitado no existe';
                    $this->load->view('Error_practicas');
                }
                break;
            case 'empl':
                //Si el campo filtro no está vacío recorro todos los datos de la tabla y si encuentra alguno con el mismo nombre que pasó el usuario significa que existe
                if ($res['filtro'] != '') {
                    foreach ($compareEmpl as $comp) {
                        if (str_contains($comp['nombre'], $res['filtro'])) {
                            $is_err = false;
                        }
                    }
                } else {
                    //Si el campo filtro está vacío $is_err valdrá false y los traerá todos de la base de datos, luego detiene la ejecución
                    $is_err = false;
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_todos();

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                    break;
                }

                //Si la variable de errores es false significa que no hay errores y por lo tanto llamo al modelo y lo que me devuelve lo seteo en la variable $this->prac que se enviará a la view resultado
                if (!$is_err) {
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_empleado($res['filtro']);

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                } else {
                    //Importante! Doy valor a la variable $this->err que se va a pasar a la view en caso de error
                    $this->err = 'El filtro solicitado no existe';
                    $this->load->view('Error_practicas');
                }
                break;
            case 't':
                //Si el campo filtro no está vacío recorro todos los datos de la tabla y si encuentra alguno con el mismo nombre que pasó el usuario significa que existe
                if ($res['filtro'] != '') {
                    foreach ($compareTut as $comp) {
                        if (str_contains($comp['nombre'], $res['filtro'])) {
                            $is_err = false;
                        }
                    }
                } else {
                    //Si el campo filtro está vacío $is_err valdrá false y los traerá todos de la base de datos, luego detiene la ejecución
                    $is_err = false;
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_todos();

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                    break;
                }

                //Si la variable de errores es false significa que no hay errores y por lo tanto llamo al modelo y lo que me devuelve lo seteo en la variable $this->prac que se enviará a la view resultado
                if (!$is_err) {
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_tutor($res['filtro']);

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                } else {
                    //Importante! Doy valor a la variable $this->err que se va a pasar a la view en caso de error
                    $this->err = 'El filtro solicitado no existe';
                    $this->load->view('Error_practicas');
                }
                break;
            case 's':
                if ($res['filtro'] != '') {

                    //Cambiamos el valor del filtro Strings a los valores de la BBDD Integer para poder realizar la comparacion con el compare
                    if (str_contains($res['filtro'], "S") || str_contains($res['filtro'], "s")) {
                        $res['filtro'] = 1;
                    } else if (str_contains($res['filtro'], "N") || str_contains($res['filtro'], "n")) {
                        $res['filtro'] = 0;
                    }

                    foreach ($compare as $comp) {
                        if (str_contains($comp['seneca'], $res['filtro'])) {
                            $is_err = false;
                        }
                    }
                } else {
                    //Si el campo filtro está vacío $is_err valdrá false y los traerá todos de la base de datos, luego detiene la ejecución
                    $is_err = false;
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_todos();

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }

                    $this->load->view('Resultado_practicas');
                    break;
                }

                //Si la variable de errores es false significa que no hay errores y por lo tanto llamo al modelo y lo que me devuelve lo seteo en la variable $this->tutor_centro que se enviará a la view resultado
                if (!$is_err) {
                    $this->load->model('Practicas_model', 'Practicas_model', true);
                    $this->prac = $this->Practicas_model->get_seneca($res['filtro']);

                    //Solo intercambia los id por nombre cuando exista al menos 1 practica
                    if (sizeof($this->prac) > 0) {
                        foreach ($this->prac as $key => $prac) {
                            //Función que intercambia el id_alumno por su nombre
                            $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                            $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                            //Función que intercambia el id_empresa por su nombre
                            $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                            $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                            //Función que intercambia el id_empleado por su nombre
                            $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                            $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                            //Función que intercambia el id_tutor_centro por su nombre
                            $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                            $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
                        }
                    }
                    $this->load->view('Resultado_practicas');
                } else {
                    //Importante! Doy valor a la variable $this->err que se va a pasar a la view en caso de error
                    $this->err = 'El filtro solicitado no existe';
                    $this->load->view('Error_practicas');
                }
                break;
        }
    }

    public function add_practicas()
    {
        //Recojo los parametros enviados por ajax y los meto en un array
        $res = array(
            'id_alumno' => $this->input->post('idAlumno'),
            'id_empresa' => $this->input->post('idEmpresa'),
            'sede' => $this->input->post('sede'),
            'id_empleado' => $this->input->post('idEmpleado'),
            'id_tutor_centro' => $this->input->post('idTutor'),
            'seneca' => $this->input->post('activo'),
            'fecha_incorporacion' => $this->input->post('fecha_incorporacion')
        );

        //Llamo al modelo y añado la nueva Practica, después vuelvo a cargar la tabla con todos los campos
        $this->load->model('Practicas_model', 'Practicas_model', true);
        $this->Practicas_model->insertar($res);
        $this->tabla_ini();
    }

    public function modify_practicas()
    {
        //Recojo los parametros enviados por ajax y los meto en un array
        $res = array(
            'id_alumno' => $this->input->post('idAlumno'),
            'id_empresa' => $this->input->post('idEmpresa'),
            'sede' => $this->input->post('sede'),
            'id_empleado' => $this->input->post('idEmpleado'),
            'id_tutor' => $this->input->post('idTutor'),
            'seneca' => $this->input->post('activo'),
            'fecha_incorporacion' => $this->input->post('fecha_incorporacion')
        );

        //Llamo al modelo y modifico la Practica seleccionada, después vuelvo a cargar la tabla con todos los campos
        $this->load->model('Practicas_model', 'Practicas_model', true);
        $this->Practicas_model->updatear($this->input->post('id'), $res);
        $this->tabla_ini();
    }


    public function delete_practicas()
    {
        //Llamo al modelo y borro la Practica seleccionada, después vuelvo a cargar la tabla con todos los campos
        $this->load->model('Practicas_model', 'Practicas_model', true);
        $this->Practicas_model->deletear($this->input->post('id'));
        $this->tabla_ini();
    }

    public function tabla_ini()
    {
        //Función que carga la tabla completa al iniciar la página
        $this->load->model('Practicas_model', 'Practicas_model', true);
        $this->prac = $this->Practicas_model->get_todos();

        //Solo intercambia los id por nombre cuando exista al menos 1 Practica
        if (sizeof($this->prac) > 0) {
            foreach ($this->prac as $key => $prac) {

                //Función que intercambia el id_alumno por su nombre
                $this->load->model('Alumno_model', 'Alumno_model', true);
                $n_alumno = $this->Alumno_model->get_id($prac['id_alumno']);
                $this->prac[$key]['id_alumno'] = $n_alumno[0]['nombre'];

                //Función que intercambia el id_empresa por su nombre
                $this->load->model('Empresa_model', 'Empresa_model', true);
                $n_empresa = $this->Empresa_model->get_id($prac['id_empresa']);
                $this->prac[$key]['id_empresa'] = $n_empresa[0]['nombre'];

                //Función que intercambia el id_empleado por su nombre
                $this->load->model('Empleado_model', 'Empleado_model', true);
                $n_empleado = $this->Empleado_model->get_id($prac['id_empleado']);
                $this->prac[$key]['id_empleado'] = $n_empleado[0]['nombre'];

                //Función que intercambia el id_tutor_centro por su nombre
                $this->load->model('Tutor_centro_model', 'Tutor_centro_model', true);
                $n_tutor_centro = $this->Tutor_centro_model->get_id($prac['id_tutor_centro']);
                $this->prac[$key]['id_tutor_centro'] = $n_tutor_centro[0]['nombre'];
            }
        }

        $this->load->view('Resultado_practicas');
    }

    private function compare()
    {
        //Función que devuelve todos los datos de la tabla Practicas
        $this->load->model('Practicas_model', 'Practicas_model', true);
        return $this->Practicas_model->get_todos();
    }

    public function load_insert()
    {
        //Recojo los valores actuales del insert para que el usuario no los pierda al cambiar el select de empresa
        if ($this->input->post('idAlumno') != null) {
            $this->valoresActuales['idAlumno'] = $this->input->post('idAlumno');
        } else {
            $this->valoresActuales['idAlumno'] = null;
        }

        if ($this->input->post('idEmpleado') != null) {
            $this->valoresActuales['idEmpleado'] = $this->input->post('idEmpleado');
        } else {
            $this->valoresActuales['idEmpleado'] = null;
        }

        if ($this->input->post('idTutor') != null) {
            $this->valoresActuales['idTutor'] = $this->input->post('idTutor');
        } else {
            $this->valoresActuales['idTutor'] = null;
        }

        if ($this->input->post('activo') != null) {
            $this->valoresActuales['activo'] = $this->input->post('activo');
        } else {
            $this->valoresActuales['activo'] = null;
        }

        if ($this->input->post('fecha_incorporacion') != null) {
            $this->valoresActuales['fecha_incorporacion'] = $this->input->post('fecha_incorporacion');
        } else {
            $this->valoresActuales['fecha_incorporacion'] = null;
        }

        //Si idEmpresa existe es que lo hemos llamado desde ajax para updatear las sedes
        if ($this->input->post('idEmpresa') != null) {
            //Si idEmpresa no vale 'Sin Sedes' es que hay sedes
            if ($this->input->post('idEmpresa') != 'Sin Sedes') {
                $this->load->model('Empresa_model', 'Empresa_model', true);
                $this->sedesEmp = $this->Empresa_model->get_id($this->input->post('idEmpresa'));
            }
        } else {
            //Función que devuelve todos los datos de la tabla Empresa y luego solo se queda con la primera empresa no eliminada
            $this->load->model('Empresa_model', 'Empresa_model', true);
            $this->sedesEmp = $this->Empresa_model->get_todos();
            $this->sedesEmp = $this->sedesEmp[0];
            //Aquí hacemos que devuelva un array de array para que coincida con lo que se devuelve si idEmpresa existe
            $aux = array($this->sedesEmp);
            $this->sedesEmp = $aux;
        }

        //Función que devuelve todos los datos de la tabla Empresa
        $this->load->model('Empresa_model', 'Empresa_model', true);
        $this->empresa = $this->Empresa_model->get_todos();
        //Función que devuelve todos los datos de la tabla Alumno
        $this->load->model('Alumno_model', 'Alumno_model', true);
        $this->alumno = $this->Alumno_model->get_todos();
        //Función que devuelve todos los datos de la tabla Empleado
        $this->load->model('Empleado_model', 'Empleado_model', true);
        $this->empleado = $this->Empleado_model->get_todos();
        //Función que devuelve todos los datos de la tabla Tutor_centro
        $this->load->model('Tutor_centro_model', 'Tutor_centro_model', true);
        $this->tutor = $this->Tutor_centro_model->get_todos();

        $this->load->view('Insert_practicas');
    }

    public function load_modify()
    {
        //Recojo el valor actual de empresa en el update para que se actualice al cambiar el select de empresa
        if ($this->input->post('idEmpresa') != null) {
            $this->valoresActuales['idEmpresa'] = $this->input->post('idEmpresa');
        } else {
            $this->valoresActuales['idEmpresa'] = null;
        }

        //Recojo los valores actuales del insert para que el usuario no los pierda al cambiar el select de empresa
        if ($this->input->post('idAlumno') != null) {
            $this->valoresActuales['idAlumno'] = $this->input->post('idAlumno');
        } else {
            $this->valoresActuales['idAlumno'] = null;
        }

        if ($this->input->post('idEmpleado') != null) {
            $this->valoresActuales['idEmpleado'] = $this->input->post('idEmpleado');
        } else {
            $this->valoresActuales['idEmpleado'] = null;
        }

        if ($this->input->post('idTutor') != null) {
            $this->valoresActuales['idTutor'] = $this->input->post('idTutor');
        } else {
            $this->valoresActuales['idTutor'] = null;
        }

        if ($this->input->post('activo') != null) {
            $this->valoresActuales['activo'] = $this->input->post('activo');
        } else {
            $this->valoresActuales['activo'] = null;
        }

        if ($this->input->post('fecha_incorporacion') != null) {
            $this->valoresActuales['fecha_incorporacion'] = $this->input->post('fecha_incorporacion');
        } else {
            $this->valoresActuales['fecha_incorporacion'] = null;
        }

        //Función que carga la practica con el id que tiene la fila que ha pulsado el usuario
        $this->load->model('Practicas_model', 'Practicas_model', true);

        //Traigo la practica que se está modificando dependiendo de si es al modificar el select de empresa o si es la primera vez que le pulso
        if ($this->input->post('idPracticaModificada') != null) {
            $this->prac = $this->Practicas_model->get_id($this->input->post('idPracticaModificada'));
        } else {
            $this->prac = $this->Practicas_model->get_id($this->input->post('id'));
        }

        //Si idEmpresa existe es que lo hemos llamado desde ajax para updatear las sedes
        if ($this->input->post('idEmpresa') != null) {
            //Si idEmpresa no vale 'Sin Sedes' es que hay sedes
            if ($this->input->post('idEmpresa') != 'Sin Sedes') {
                $this->load->model('Empresa_model', 'Empresa_model', true);
                $this->sedesEmp = $this->Empresa_model->get_id($this->input->post('idEmpresa'));
            }
        } else {
            //Función que devuelve todos los datos de la tabla Empresa y luego solo se queda con la primera empresa no eliminada
            $this->load->model('Empresa_model', 'Empresa_model', true);
            $this->sedesEmp = $this->Empresa_model->get_id($this->prac[0]['id_empresa']);
        }

        //Función que devuelve todos los datos de la tabla Empresa
        $this->load->model('Empresa_model', 'Empresa_model', true);
        $this->empresa = $this->Empresa_model->get_todos();
        //Función que devuelve todos los datos de la tabla Alumno
        $this->load->model('Alumno_model', 'Alumno_model', true);
        $this->alumno = $this->Alumno_model->get_todos();
        //Función que devuelve todos los datos de la tabla Empleado
        $this->load->model('Empleado_model', 'Empleado_model', true);
        $this->empleado = $this->Empleado_model->get_todos();
        //Función que devuelve todos los datos de la tabla Tutor_centro
        $this->load->model('Tutor_centro_model', 'Tutor_centro_model', true);
        $this->tutor = $this->Tutor_centro_model->get_todos();

        $this->load->view('Update_practicas');
    }

    public function export_excel()
    {
        $this->load->model('Empresa_model', 'Empresa_model', true);
        $this->load->model('Alumno_model', 'Alumno_model', true);
        $this->load->model('Empleado_model', 'Empleado_model', true);
        $this->load->model('Tutor_centro_model', 'Tutor_centro_model', true);

        //Inicializo Array que contendrá todos los datos del programa
        $data = array();

        //Traemos los datos de todas las practicas
        $this->load->model('Practicas_model', 'Practicas_model', true);
        //Llamada a modelo que devuelve todos los datos de la tabla
        $data_practicas = $this->Practicas_model->get_todos();

        //Por cada practica coje todos sus datos adyacentes y los mete en un array
        foreach ($data_practicas as $practica) {
            //Función que devuelve todos los datos de la tabla Empresa
            $data_empresa = $this->Empresa_model->get_id($practica['id_empresa']);

            // CAMBIO EL ID DE LA SEDE PRINCIPAL POR SU NOMBRE EN CADA UNA DE LAS EMPRESAS
            //Separo el string direcciones en cada & y lo añado a un array de strings
            $res_direcciones = explode('&', $data_empresa[0]['direcciones']);

            //Vuelvo a separar cada valor del array por cada = y así obtener su valor original y meto cada uno en el array $array_direcciones (quito los vacíos)
            $count = 1;
            $array_direcciones = array();
            foreach ($res_direcciones as $rd) {
                if ($rd != '') {
                    $index = strval($count);
                    $valor = explode('=', $rd);
                    $array_direcciones['d' . $index] = $valor[1];
                    $count++;
                }
            }

            //Pinto el valor que coincida con el numero de la variable principal
            if (isset($array_direcciones['d' . $data_empresa[0]['principal']])) {
                $data_empresa[0]['principal'] = $array_direcciones['d' . $data_empresa[0]['principal']];
            } else {
                $data_empresa[0]['principal'] = 'No hay Sede Principal';
            }

            // CAMBIO EL ID DE CADA SEDE POR SU NOMBRE EN CADA UNA DE LAS EMPRESAS
            //Separo el string direcciones en cada & y lo añado a un array de strings
            $res_direcciones = explode('&', $data_empresa[0]['direcciones']);

            //Vuelvo a separar cada valor del array por cada = y así obtener su valor original y meto cada uno en el array $array_direcciones (quito los vacíos)
            $count = 1;
            $array_direcciones = array();
            foreach ($res_direcciones as $rd) {
                if ($rd != '') {
                    $index = strval($count);
                    $valor = explode('=', $rd);
                    $array_direcciones['d' . $index] = $valor[1];
                    $count++;
                }
            }

            $data_empresa[0]['direcciones'] = '';

            //Pinto los valores
            if (count($array_direcciones) > 0) {
                foreach ($array_direcciones as $dir) {
                    $data_empresa[0]['direcciones'] .= $dir . '  |  ';
                }
            } else {
                $data_empresa[0]['direcciones'] = 'No hay Sedes';
            }

            //Función que devuelve todos los datos de la tabla Alumno
            $data_alumno = $this->Alumno_model->get_id($practica['id_alumno']);

            //Función que intercambia el id_ciclo por su nombre
            $this->load->model('Ciclo_model', 'Ciclo_model', true);
            $n_ciclo = $this->Ciclo_model->get_id($data_alumno[0]['id_ciclo']);
            $data_alumno[0]['id_ciclo'] = $n_ciclo[0]['nombre_corto'];

            //Función que devuelve todos los datos de la tabla Empleado
            $data_empleado = $this->Empleado_model->get_id($practica['id_empleado']);

            //Función que intercambia el id_empresa por su nombre
            $this->load->model('Empresa_model', 'Empresa_model', true);
            $n_empresa = $this->Empresa_model->get_id($data_empleado[0]['id_empresa']);
            $data_empleado[0]['id_empresa'] = $n_empresa[0]['nombre'];

            //Función que intercambia el id_tipo por su nombre
            $this->load->model('Tipo_empleado_model', 'Tipo_empleado_model', true);
            $n_tipo = $this->Tipo_empleado_model->get_id($data_empleado[0]['id_tipo']);
            $data_empleado[0]['id_tipo'] = $n_tipo[0]['nombre'];

            //Función que devuelve todos los datos de la tabla Tutor_centro
            $data_tutor = $this->Tutor_centro_model->get_id($practica['id_tutor_centro']);

            //CAMBIO EL VALOR DE 0 O 1 DE LA COLUMNA ACTIVO POR SÍ O NO
            $data_tutor[0]['activo'] = ($data_tutor[0]['activo'] == 1) ? 'Sí' : 'No';

            //CAMBIO EL VALOR DE 0 O 1 DE LA COLUMNA SÉNECA POR SÍ O NO
            $practica['seneca'] = ($practica['seneca'] == 1) ? 'Sí' : 'No';

            //Introduzco la fila con sus datos correspondientes
            array_push($data, array('empresa' => $data_empresa, 'alumno' => $data_alumno, 'empleado' => $data_empleado, 'tutor' => $data_tutor, 'practica' => array('sede' => $practica['sede'], 'seneca' => $practica['seneca'], 'fecha_incorporacion' => $practica['fecha_incorporacion'])));
        }

        //Nombre del archivo que se va a descargar
        $nombre = 'Excel_Practicas.xlsx';

        //Funcion del modelo que crea el excel
        $spreadsheet = $this->Practicas_model->create_spreadsheet($data, 2);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
        header('Content-Disposition: attachment;filename="' . $nombre . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache*/

        $writer->save('php://output');
    }
}
