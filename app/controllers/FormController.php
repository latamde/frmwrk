<?php

require_once ROOT_PATH . "/app/models/Form.php";
require_once ROOT_PATH . "/config/functions.php";

session_start();

class FormController
{
    static function index()
    {
        render_template('form/index', [
            "title" => "Prueba Técnica"
        ]);
        unset($_SESSION['success']);
    }

    static function save()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            unset($_SESSION['success']);
            $form = new Form();
            $form->name = $_POST["name"];
            $form->mail = $_POST["mail"];
            $form->region = isset($_POST["region"]) ? $_POST["region"] : "";
            $form->comuna = isset($_POST["comuna"]) ? $_POST["comuna"] : "";

            list($errors, $data)  = self::validar_formulario($form->name, $form->mail, $form->region, $form->comuna);

            if (!empty($errors)) {
                return render_template('form/index', [
                    "title" => "Prueba Técnica",
                    "errors" => $errors,
                    "data" => $data,
                ]);
                 
                exit();
            }

            try {
                $form->store_to_CSV();
                $form->save();
                $_SESSION['success'] = "Inscrito correctamente!!";

            } catch (\Throwable $th) {

            }

            header("Location: /");
            exit();
        }
    }
     
    static function descargarCSV()
    {
        $ruta_archivo = ROOT_PATH . "/storage/datos.csv";
            if (!file_exists($ruta_archivo)) {
                header("Location: index.php?status=false");
                exit();
            }
        
            $csv_file = fopen($ruta_archivo, "r");
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=datos.csv');
            fpassthru($csv_file);
            fclose($csv_file);
            exit();
    }

    static function validar_formulario($name, $mail, $region, $comuna)
    {
        $errors = [];
        $data = [];

        $validMail = Self::verificar_mail($mail);
        
        if ($validMail) {
            $errors['mail'] = "El mail ingresado ya existe, porfavor interar con otro";
        }

        if (empty($name)) {
            $errors['name'] = "Por favor ingresa tu nombre";
        } elseif (!preg_match("/^[a-zA-Z\s]*$/", $name)) {
            $errors['name'] = "Solo se permiten letras y espacios en blanco en el nombre";
        } else {
            $data['name'] = $name;
        }

        if (empty($mail)) {
            $errors['mail'] = "Por favor ingresa tu correo electrónico";
        } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Introduce un formato de email válido";
        } else {
            $data['mail'] = $mail;
        }

        if ($region == "Seleccioné una región" || $region == "") {
            $errors['region'] = "Por favor selecciona una región";
        }

        if ($comuna == "Seleccioné una comuna" || $comuna == "") {
            $errors['comuna'] = "Por favor selecciona una comuna";
        }

        return [$errors, $data];
    }
    
    static function show($var)
    {
        // echo $var["id"];
        var_dump($var);
    }

    static function verificar_mail($mail)
    {
        $form = new Form();
        $form->mail = $mail;
        return $form->validate_mail();
    }
}
