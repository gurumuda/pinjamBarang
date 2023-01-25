<?php

function nomor($currentPage, $perPage)
{
    if (is_null($currentPage)) {
        $nomor = 1;
    } else {
        $nomor = 1 + ($perPage * ($currentPage - 1));
    }
    return $nomor;
}
