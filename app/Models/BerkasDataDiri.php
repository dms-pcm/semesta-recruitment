<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class BerkasDataDiri extends Model
{
    use HasFactory, SoftDeletes, Userstamps;
    protected $guarded = ['id'];
    protected $table = 'berkas_data_diri';

    public function participant2()
    {
        return $this->belongsTo('App\Models\Participants', 'id', 'participant_id');
    }
}
