<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// But mass assignment opens the security holds that user can assign
// the values to some critical fields so we need additional setting to
// allow the fields that can be assigned by using mass assignment.
// • We have to set array of fillable fields name to protected property
// $fillable in Model, e.g.
class Product extends Model
{
    use HasFactory;
    protected $fillable =['code','name','category_id','price','description'];
    function shops() : BelongsToMany{
        return $this->belongsToMany(Shop::class)->withTimestamps();
    }
    function category() :BelongsTo{
        return  $this->BelongsTo(Category::class);
    }
}
