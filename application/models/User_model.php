<?php
    class User_model extends CI_Model
    {
        function get_user($email, $password)
        {
            $this->db->where('email', $email);
            $this->db->where('password', $password);
            $this->db->limit(1);
            $query = $this->db->get('users');
            return $query->row();
        }
        //==============================================================================        
        function insert_user($data)
        {
            return $this->db->insert('users', $data);
        }
        //==============================================================================    
        function update_user($name, $data)
        {
            $this->db->set($data);
            $this->db->where('name', $name);
            $this->db->limit(1);
            return $this->db->update('users', $data);
        }
        //==============================================================================    
        function remove_user($id_user)
        {
            $this->db->where('userID', $id_user);
            return $this->db->delete('users');
        }
        //==============================================================================    
        function extract_data($name = '', $id = -1)
        {
            if(!empty($name) && $id == -1) $this->db->where('name', $name);
            else $this->db->where('userID', $id);
            $this->db->limit(1);
            return $this->db->get('users')->row();
        }
    }
