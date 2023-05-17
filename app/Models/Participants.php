<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Participants extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $guarded = ['id'];

    public function berkas()
    {
        return $this->hasMany('App\Models\Files', 'participant_id', 'id');
    }

    public function berkasDiri()
    {
        return $this->hasMany('App\Models\BerkasDataDiri', 'participant_id', 'id');
    }

    public function rekrut()
    {
        return $this->hasMany('App\Models\Recruitment', 'id', 'recruitment_id');
    }
}
