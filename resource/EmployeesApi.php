<?php

namespace app\resource;

use app\models\Clusters;

class EmployeesApi extends \app\models\EmployeesApi
{
    public function fields()
    {
        return ['id', 'employee_id', 'fname', 'lname', 'contact_number'];
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