<?php

function getPrix($prix)
{
    $prix = floatval($prix) / 100;

    return number_format($prix, 2, ',', ' ') . ' €';
}