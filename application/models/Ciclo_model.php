<?php

class Ciclo_Model extends CI_Model
{

    public function insertar($data)
    {
        //Inserta una alumno en la base de datos con los valores del array
        $this->db->insert('ciclos', $data);
    }

    public function get_todos($ret_type = false)
    {
        //Retorna todas las alumnos de la base de datos si la variable ret_type está a true devuelve un objeto sino un array
        $query = $this->db->get('ciclos');

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

        //Retorna la alumno de la base de datos que tenga ese id
        $query = $this->db->get('ciclos');

        return $query->result_array();
    }

}