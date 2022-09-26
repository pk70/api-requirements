<?php

function jsonarray_decode_from_file(string $file_location): array
{
    $data = [];
    $collection = json_decode(file_get_contents($file_location), true);
    foreach ($collection as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $data[] = $value2;
        }
    }
    return $data;
}

