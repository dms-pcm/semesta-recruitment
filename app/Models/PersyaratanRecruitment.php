<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PersyaratanRecruitment extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $table = 'persyaratan_recruitment';
    protected $guarded = ['id'];

    public function rekrutmen()
    {
        return $this->belongsTo('App\Models\Recruitment', 'id', 'recruitment_id');
    }
}
