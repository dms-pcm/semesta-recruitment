<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Recruitment extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $guarded = ['id'];

    public function participant()
    {
        return $this->hasMany('App\Models\Participants', 'recruitment_id', 'id');
    }

    public function persyaratan()
    {
        return $this->hasMany('App\Models\PersyaratanRecruitment', 'recruitment_id', 'id');
    }
}
