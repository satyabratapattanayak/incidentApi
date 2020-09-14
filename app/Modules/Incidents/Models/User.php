<?php

namespace App\Modules\Incidents\Models;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ['id'];
    protected $table = 'users';
    protected $fillable = [
        'name', 'role_id'
    ];

    /**
     * Create One-to-Many relationship between Incident to User
     *
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return relationship object of category
     */
    public function userIincident()
    {
        return $this->hasMany(
            'App\Modules\Incidents\Models\UserIncidentRel',
            'user_id'
        );
    }

    /**
     * Return role id and name
     *
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return relationship object of category
     */
    public function role()
    {
        return $this->hasOne(
            'App\Modules\Incidents\Models\Role', 'id', 'role_id'
        )->select(
            'id', 'name'
        );
    }
}
