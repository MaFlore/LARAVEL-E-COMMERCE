<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getPrix()
    {
        $prix = $this->prix / 100;

        return number_format($prix, 2, ',', ' ') . ' €';

    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
