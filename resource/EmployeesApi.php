<?php

namespace app\resource;

class EmployeesApi extends \app\models\EmployeesApi
{
    public function fields()
    {
        return [
            'id',
            'employee_id',
            'fname',
            'lname',
            'fk_cluster',
            'fkCluster',
        ];
    }

    public function extraFields()
    {
        return ['fkCluster'];
    }

    public function getFkCluster()
    {
        return $this->hasOne(Clusters::class, ['id' => 'fk_cluster']);
    }
}