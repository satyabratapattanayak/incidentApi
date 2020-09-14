<?php

namespace App\Modules\Incidents\Models;

class UserIncidentRel extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'user_incident_rel';
    protected $fillable = [
        'user_id', 'incident_id'
    ];
    public $timestamps = false;

    /**
     * Return user id, name and role id
     *
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return relationship object of category
     */
    public function user()
    {
        return $this->hasOne(
            'App\Modules\Incidents\Models\User', 'id', 'user_id'
        )->select(
            'id', 'name', 'role_id'
        );
    }
}
