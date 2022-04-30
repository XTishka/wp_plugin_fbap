<?php

class Parser {

    public function sourceSelector () {
        echo '<pre>';
        print_r($_POST['url']);
        echo '</pre>';
    }
}

$data = new Parser();
$data->sourceSelector();