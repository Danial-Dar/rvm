<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scorecard extends Model
{
    use HasFactory;

    protected $table = "scorecards";

    public function phrase()
    {
        return $this->belongsToMany(Phrase::class, 'scorecard_has_phrases');
    }
}
