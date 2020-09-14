<?php

namespace App\Modules\Incidents\Controllers;

use App\Modules\Incidents\Models\Category;
use App\Modules\Incidents\Models\Incident;
use App\Modules\Incidents\Models\User;
use App\Modules\Incidents\Models\Role;
use App\Modules\Incidents\Models\UserIncidentRel;
use Carbon\Carbon;

class IncidentsController
{
    /**
     * Global Json respose array
     */
    private $jsonResponse;

    /**
     * Initialize Constructer
     */
    public function __construct()
    {
        $this->jsonResponse = [
            'status' => 0,
            'data' => [],
        ];
    }

    /**
     * Get all Incident Categories
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function getCategories($request, $response, $args)
    {
        $serverStatusCode = OPERATION_OKAY;
        $categoryInit = new Category();
        $getCategories = $categoryInit->get();
        if ($getCategories->count() > 0) {
            $this->jsonResponse = [
                'status' => 1,
                'data' => $getCategories->toArray(),
            ];
        }

        return response(
            $response, ['data' => $this->jsonResponse, 'status' => $serverStatusCode]
        );
    }

    /**
     * Save Single Incident
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function saveIncident($request, $response)
    {
        $serverStatusCode = OPERATION_OKAY;
        $allPostVars = $request->getParsedBody();
        if (isset($allPostVars['data']) && $allPostVars['data'] != "") {
            $getAllFormData = json_decode($allPostVars['data'], true);
            $missingParam = [];
            if (empty($getAllFormData['location'])) {
                $missingParam[] = 'Please provide a valid location';
            }
            if (!empty($getAllFormData['location'])) {
                if (!empty($getAllFormData['location']['latitude']) && $getAllFormData['location']['longitude']) {
                    $islocationValid = $this->isGeoValid($getAllFormData['location']['longitude'], $getAllFormData['location']['latitude']);
                    if (!$islocationValid) {
                        $missingParam[] = 'Please provide a valid location';
                    }
                }
            }
            if (empty($getAllFormData['category'])) {
                $missingParam[] = 'Please provide a valid category';
            }
            if (empty($getAllFormData['incidentDate'])) {
                $missingParam[] = 'Please provide a valid Incident Date';
            }
            if (!empty($getAllFormData['incidentDate'])) {
                if (strtotime(date('Y-m-d H:i:s')) < strtotime($getAllFormData['incidentDate'])) {
                    $missingParam[] = 'Please provide a valid Incident Date';
                }
            }
            
            if (empty($missingParam)) {
                $saveIncidentDetails = [
                    'title' => $getAllFormData['title'],
                    'latitude' => $getAllFormData['location']['latitude'],
                    'longitude' => $getAllFormData['location']['longitude'],
                    'category_id' => $getAllFormData['category'],
                    'comments' => $getAllFormData['comments'],
                    'incident_date' => $getAllFormData['incidentDate'],
                    'created_at' => !empty($getAllFormData['createDate']) ? $getAllFormData['createDate'] : date('Y-m-d h:i:s'),
                    'updated_at' => !empty($getAllFormData['modifyDate']) ? $getAllFormData['modifyDate'] : date('Y-m-d h:i:s'),
                ];
                try {
                    $IncidentInit = new Incident($saveIncidentDetails);
                    if($IncidentInit->save()) {
                            $incidentId = $IncidentInit->id;
                            if (!empty($getAllFormData['people'])) {
                                $this->saveInvolver($getAllFormData['people'], $incidentId);
                            }
                        $this->jsonResponse = [
                            'status' => 1,
                            'message' => 'Incident is saved successfully'
                        ];
                    }
                } catch (\Exception $e) {
                    $this->jsonResponse = [
                        'status' => 1,
                        'message' => 'Something went Wrong',
                        'exception' => $e->getMessage(),
                    ];
                }                
            } else {
                $this->jsonResponse = [
                    'status' => 0,
                    'message' => implode(',', $missingParam),
                ];
            }
        }

        return response(
            $response, ['data' => $this->jsonResponse, 'status' => $serverStatusCode]
        );
    }

    /**
     * Checking latitude and longitude
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return boolean
     */
    private function isGeoValid($longitude, $latitude)
    {
        $validLongPattern = '/^(\+|-)?(?:180(?:(?:\.0{1,8})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/';
        $validLatPattern = '/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/';

        if (preg_match($validLongPattern, $longitude) && preg_match($validLatPattern, $latitude)) {
            return true;
        }
        return false;
    }


    /**
     * Save incident involver
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return boolean
     */
    private function saveInvolver($peopleDetails, $incidentId) {
        if (!empty($peopleDetails)) {
            foreach ($peopleDetails as $detailsKey => $people) {
                $roleId = $this->getRoleDetails($people['type']);
                $condition = [
                    'name' => $people['name'],
                    'role_id' => $roleId,
                ];
                $userObj = new User();
                $users = $userObj->where($condition);
                if ($users->count() == 0) {
                    $userObj = new User($condition);
                    $userObj->save();
                    $userID = $userObj->id;
                } else {
                    $getUserDetails = $users->select('id')
                        ->first();
                    $userID = $getUserDetails['id'];
                }
                if (!empty($userID)) {
                    $relCondition = [
                        'user_id' => $userID,
                        'incident_id' => $incidentId,
                    ];
                    $userRelObj = new UserIncidentRel();
                    $relCount = $userRelObj->where($relCondition);
                    if ($relCount->count() == 0) {
                        $relInit = new UserIncidentRel(
                            [
                                'user_id' => $userID,
                                'incident_id' => $incidentId,
                            ]
                        );
                        $relInit->save();
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get Role Id from role name
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return int
     */
    private function getRoleDetails($roleName) {
        if (!empty($roleName)) {
            $roleInit = new Role();
            $roleId = $roleInit->select('id')->where('name', $roleName)->first();
            return $roleId->id;
        }
    }

    /**
     * Get All Incidents
     * 
     * @author satyabrata4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function getIncidents($request, $response)
    {
        $serverStatusCode = OPERATION_OKAY;
        $incidentInit = new Incident();
        $getIncidents = $incidentInit->orderBy('id', 'DESC');
        if (!empty($getIncidents->count())) {
            $getIncidents = $getIncidents->with('incidentCategory', 'incidentUser.user', 'incidentUser.user.role')->get()->toArray();
            foreach ($getIncidents as $incidentKey => $incidents) {
                $people = [];
                if (!empty($incidents['incident_user'])) {
                    foreach ($incidents['incident_user'] as $userKey => $user) {
                        $people[] = [
                            'name'=> $user['user']['name'],
                            'type'=> $user['user']['role']['name'],
                        ];
                    }
                }
                $incident[$incidentKey] = [
                    'id' => $incidents['id'],
                    'location' => [
                        'latitude' => $incidents['latitude'],
                        'longitude' => $incidents['longitude'],
                    ],
                    'title' => $incidents['title'],
                    'category' => !empty($incidents['category_id']) ? $incidents['category_id'] : '',
                    'people' => $people,
                    'comments' => $incidents['comments'],
                    'incidentDate' => Carbon::createFromFormat('Y-m-d H:i:s', $incidents['incident_date'])->toIso8601String(),
                    'createDate' => Carbon::createFromFormat('Y-m-d H:i:s', $incidents['created_at'])->toIso8601String(),
                    'modifyDate' => Carbon::createFromFormat('Y-m-d H:i:s', $incidents['updated_at'])->toIso8601String()
                ];
            }
            $this->jsonResponse = [
                'status' => 1,
                'data' => $incident,
            ];
        }
        return response(
            $response, ['data' => $this->jsonResponse, 'status' => $serverStatusCode]
        );
    }
}
