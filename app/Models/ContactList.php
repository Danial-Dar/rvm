<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contact_lists';
    // protected $with = ['contact'];

    protected $fillable = [
        'name',
        'user_id',
        'path',
        'total_contacts',
        'deleted_at',
        'updated_at',
        'created_at',
        'filename',
        'status',
        'company_id',
        'jobs',
        'job_status',
        'failed',
        'selected_phone_column',
        'reputation_check_status',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'contact_list_id', 'id');
    }
}
