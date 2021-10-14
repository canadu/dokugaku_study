<?php
$array = array_chunk(array_slice($argv, 1), 2);
foreach ($array as $key => $value) {
    echo $key . ':' . $value . ' ';
}
