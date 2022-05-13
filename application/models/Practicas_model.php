<?php

class Practicas_Model extends CI_Model
{

    public function insertar($data)
    {
        //Inserta una practica en la base de datos con los valores del array
        $this->db->insert('practicas', $data);
    }

    public function get_todos($ret_type = false)
    {
        //Filtro para traer solo los campos que tengan eliminado a 0
        $this->db->where('eliminado', 0);

        //Retorna todas las practicas de la base de datos si la variable ret_type está a true devuelve un objeto sino un array
        $query = $this->db->get('practicas');

        if ($ret_type) {
            return $query->result();
        } else {
            return $query->result_array();
        }
    }

    public function get_id($id)
    {
        //Filtro
        $this->db->where('id', $id);

        //Filtro para traer solo los campos que tengan eliminado a 0
        $this->db->where('eliminado', 0);

        //Retorna la practica de la base de datos que tenga ese id
        $query = $this->db->get('practicas');

        return $query->result_array();
    }

    public function deletear($id)
    {
        // $this->db->delete('empleado', array('id' => $id));

        $this->db->where('id', $id);

        $this->db->set('eliminado', 1);

        return $this->db->update('practicas');
    }

    function updatear($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->set('id_alumno', $data['id_alumno']);
        $this->db->set('id_empresa', $data['id_empresa']);
        $this->db->set('sede', $data['sede']);
        $this->db->set('id_empleado', $data['id_empleado']);
        $this->db->set('id_tutor_centro', $data['id_tutor']);
        $this->db->set('seneca', $data['seneca']);
        $this->db->set('fecha_incorporacion', $data['fecha_incorporacion']);

        return $this->db->update('practicas');
    }
}