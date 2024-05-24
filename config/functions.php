<?php

function render_template (string $template, array $data = []) :void
{
    extract($data); // extrae todas las variables de un array asociativo
    require_once ROOT_PATH. "/app/views/layout.php";
    $content = require_once ROOT_PATH. "/app/views/$template.php";
}

function clean_input($data) :string
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function limpiar_session($method)
{
    if (empty($method)) {
        unset($_SESSION['success']);
        unset($_SESSION['errors']);
    }
}