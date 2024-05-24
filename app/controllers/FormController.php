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
    }

    static function save()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            }

            $form->store_to_CSV();

            return render_template('form/index', [
                "title" => "Prueba Técnica",
                "success" => true
            ]);
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
}
