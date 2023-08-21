<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MyGroupNumber extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "my_group_numbers";

    public function my_group()
    {
        return $this->belongsTo(MyGroup::class,'my_group_id','id');
    }
}
