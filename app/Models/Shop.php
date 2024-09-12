<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Shop extends Model
{
    use HasFactory;
    protected $fillable =['code','name','owner','latitude','longitude','address'];
     function products() :BelongsToMany{
        return $this->BelongsToMany(Product::class)->withTimestamps();
     }
}
