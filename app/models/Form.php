<?php

class Form {
    public $name;
    public $mail;
    public $region;
    public $comuna;

    public function store_to_CSV() 
    {   
        $this->name = clean_input($this->name);
        $this->mail = clean_input($this->mail);
        
        $ruta_archivo = ROOT_PATH . "/storage/datos.csv";
        $linea = "$this->name,$this->mail,$this->region,$this->comuna\n";
    
        file_put_contents($ruta_archivo, $linea, FILE_APPEND);
    }
}