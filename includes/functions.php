<?php

/**
 * pretty echo, for debugging
 */
function p_echo($var) {
    echo
    highlight_string('<?php ' . var_export($var, true) . '?>') 
    . '<br>';
}