<?php

namespace App\Modules\Incidents\Models;

class Incident extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ['id'];
    protected $table = 'incidents';
    protected $fillable = [
        'title', 'latitude', 'longitude', 'category_id', 'comments', 'incident_date'
    ];

    /**
     * Create One-to-One relationship between Incident and Category
     *
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return relationship object of category
     */
    public function incidentCategory()
    {
        return $this->hasOne(
            'App\Modules\Incidents\Models\Category',
            'id'
        );
    }

    /**
     * Create One-to-Many relationship between Clipart and
     *
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return relationship object of incident user relation
     */
    public function incidentUser()
    {
        return $this->hasMany(
            'App\Modules\Incidents\Models\UserIncidentRel',
            'incident_id'
        );
    }
}
