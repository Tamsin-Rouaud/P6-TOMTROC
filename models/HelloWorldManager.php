<?php

class HelloWorldManager extends AbstractEntityManager {

    public function getHelloWorldMessage() :string {
        $sql = "SELECT * FROM hello_table LIMIT 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['message'] ?? 'Hello me (par défaut)';
    }

}




