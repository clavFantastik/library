<?php
    function render($template, $context) {
        foreach ($context as $key => $el) {
            $template = str_replace('{{ '.$key.' }}', $el, $template);
            $template = str_replace('{{'.$key.'}}', $el, $template);
        }
        return $template;
    }

    function getDataBase() {
        return new PDO('mysql:host=localhost;dbname=u1203611_dbtable;charset=UTF8', 'root', '');
    }
?>