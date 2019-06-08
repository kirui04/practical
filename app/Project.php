<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    protected $fillable = ['officer_id', 'readiness_id', 'readiness_type_id', 'amount', 'title', 'reference', 'end_date', 'start_date', 'status'];
    protected $with = ['officer', 'readiness','countries', 'readinessType', 'disbursements'];

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }

    public function readiness()
    {
        return $this->belongsTo(Readiness::class);
    }

    public function readinessType()
    {
        return $this->belongsTo(ReadinessType::class);
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class);
    }
}
