<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function d($data, $die = 1) {
    if (is_string($data)) {
        echo '<br>';
        echo $data;
    } else {
        echo '<pre>';
        print_r($data);
    }
    if ($die) {
        die();
    }
}
