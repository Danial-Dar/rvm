<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyNumber extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "my_numbers";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function my_group_number()
    {
        return $this->belongsTo(MyGroupNumber::class, 'id', 'my_number_id');
    }
}
