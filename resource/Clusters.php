<?php

namespace app\resource;

use app\models\EmployeesApi;

class Clusters extends \app\models\Clusters
{
    public function fields()
    {
        return [ 'id', 'cluster'];
    }

    public function getEmployees()
    {
        return $this->hasMany(EmployeesApi::class, ['fk_cluster' => 'id']);
    }

}