<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $conn;
    private $table_name = "usuario";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function register($dni, $nombres, $apellidos, $fecha_nacimiento, $sexo, $email, $password, $telefono) {
        $query = "INSERT INTO " . $this->table_name . " (dni, nombres, apellidos, fecha_nacimiento, sexo, email, contraseña, telefono) 
              VALUES (:dni, :nombres, :apellidos, :fecha_nacimiento, :sexo, :email, :password, :telefono)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = hash('sha512', $password);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':telefono', $telefono);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            }
            throw $e;
        }
    }
    
    public function login($input, $password) {
        $is_email = filter_var($input, FILTER_VALIDATE_EMAIL);
        if ($is_email) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :input AND contraseña = :password";
        } else {
            $query = "SELECT * FROM " . $this->table_name . " WHERE dni = :input AND contraseña = :password";
        }
        $stmt = $this->conn->prepare($query);
        // Crea una variable para el hash de la contraseña
        $hashed_password = hash('sha512', $password);
        $stmt->bindParam(':input', $input);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getUserByDni($dni) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE dni = :dni";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    public function existsByDni($dni) {
        $query = "SELECT 1 FROM " . $this->table_name . " WHERE dni = :dni LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    public function existsByEmail($email) {
        $query = "SELECT 1 FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }    
    
    public function updateUser($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $fecha_nacimiento) {
        $query = "UPDATE " . $this->table_name . " SET 
                    nombres = :nombres, 
                    apellidos = :apellidos, 
                    email = :email, 
                    telefono = :telefono, 
                    departamento = :departamento, 
                    provincia = :provincia, 
                    ciudad = :ciudad, 
                    direccion = :direccion, 
                    sexo = :sexo, 
                    fecha_nacimiento = :fecha_nacimiento 
                  WHERE dni = :dni";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':dni', $dni);
    
        $stmt->execute();
    }    
}