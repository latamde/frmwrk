<?php

require_once ROOT_PATH . "/config/Database.php";

class Form {
    private $db;
    public $name;
    public $mail;
    public $region;
    public $comuna;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function save()
    {
        $this->name = clean_input($this->name);
        $this->mail = clean_input($this->mail);

        try {
            $stmt = $this->db->prepare("INSERT INTO forms (name, mail, region, comuna) VALUES (?, ?, ?, ?)");
            $stmt->execute([$this->name, $this->mail, $this->region, $this->comuna]);
            return true;
        } catch(PDOException $e) {
            echo "Error al insertar datos: " . $e->getMessage();
            return false;
        }
    }

    public function store_to_CSV() 
    {   
        $this->name = clean_input($this->name);
        $this->mail = clean_input($this->mail);
        
        $ruta_archivo = ROOT_PATH . "/storage/datos.csv";
        $linea = "$this->name,$this->mail,$this->region,$this->comuna\n";
    
        file_put_contents($ruta_archivo, $linea, FILE_APPEND);
    }

    public function validate_mail() 
    {
        try {
            $stmt = $this->db->prepare("SELECT 1 FROM forms WHERE mail = ?");
            $stmt->execute([$this->mail]); 
            $res = $stmt->fetchColumn();

            return $res == '1';
        } catch(PDOException $e) {
            echo "Error al validar el correo electrónico: " . $e->getMessage();
            return false;
        }
    }
}