<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $primaryKey = 'detail_id';

    protected $fillable = ['user_id', 'mobile', 'department', 'enrollment_no'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
