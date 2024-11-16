<?php

require_once "config.php";

class ModelReviews
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . MYSQL_HOST .
                ";dbname=" . MYSQL_DB . ";charset=utf8",
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->_deploy();
    }

    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END

		END;
            $this->db->query($sql);
        }
    }

    public function getAllReviews($orderBy = false, $typeOfOrder){
        $sql = 'SELECT * FROM reseñas';


        if($orderBy) {
            switch($orderBy) {
                case 'titulo':
                    $sql .= ' ORDER BY titulo';
                    break;
                case 'descripcion':
                    $sql .= ' ORDER BY descripcion';
                    break;
                case 'valor':
                    $sql .= ' ORDER BY valor';
            }
            
            $sql .= " " . $typeOfOrder;
        }

       
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReview($id){
        $query = $this->db->prepare('SELECT * FROM reseñas where id= ?');
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function deleteReview($id){
        $query = $this->db->prepare('DELETE FROM reseñas where id = ?');
        $query->execute([$id]);
    }

    public function newReview($titulo, $descripcion, $valor){
        $query = $this->db->prepare('INSERT INTO reseñas (titulo, descripcion, valor) VALUES (?, ?, ?)');
        $query->execute([$titulo, $descripcion, $valor]);

        $id = $this->db->lastInsertId();

        return $id;

    }

    public function updateReview($titulo, $descripcion, $valor, $id){
        $query = $this->db->prepare('UPDATE reseñas SET titulo = ?,  descripcion = ?, valor = ? where id= ?');
        $query->execute([$titulo, $descripcion, $valor, $id]);
    }
}
