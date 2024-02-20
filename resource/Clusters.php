<?php

namespace app\resource;

class Clusters extends \app\models\Clusters
{
    public function fields()
    {
        return [
            'id',
            'cluster',
        ];
    }

    public function extraFields()
    {
        return [
            'employees',
        ];
    }

    public function getEmployees()
    {
        return $this->hasMany(EmployeesApi::class, ['fk_cluster' => 'id']);
    }

}