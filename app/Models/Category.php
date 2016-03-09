<?php

namespace App\Models;

use Baum\Node;
use Stevebauman\Inventory\Traits\CategoryTrait;

class Category extends Node
{
    protected $table = 'categories';

    protected $scoped = ['belongs_to'];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'category_id');
    }
}
