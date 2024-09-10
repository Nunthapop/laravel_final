<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// But mass assignment opens the security holds that user can assign
// the values to some critical fields so we need additional setting to
// allow the fields that can be assigned by using mass assignment.
// • We have to set array of fillable fields name to protected property
// $fillable in Model, e.g.
class Product extends Model
{
    use HasFactory;
    protected $fillable =['code','name','price','description'];
}
