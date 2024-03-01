<?php

namespace app\controllers;

use app\models\Attendances;
use app\models\Cities;
use app\models\Clusters;
use app\models\Employees;
use app\models\Positions;
use app\models\Provinces;
use app\models\Regions;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    // Disabling default CRUD actions
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['view'], $actions['update'], $actions['delete']);
        return $actions;
    }





//    -- Attendance --
    public function actionAttendance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $attendances = Attendances::find()->asArray()->all();

        return (json::encode($attendances));
    }
    public function actionCreateAttendance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $attendances = new Attendances();

        $attendances->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($attendances->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return $attendances;
        } else {
            return ['errors' => $attendances->errors];
        }
    }
    public function actionViewAttendance($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if $id is provided
        if ($id === null) {
            return ['success' => false, 'name' => 'Bad Request', 'message' => 'Missing required parameter: id'];
        }

        $attendance = Attendances::findOne($id);
        if ($attendance === null) {
            return [ 'isAttendanceExist' => false, 'message' => 'Attendance not found.' ];
        }

        return $attendance;
    }





//    -- EMPLOYEE'S --
    public function actionEmployees($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($id))
        {
            return $this->actionViewEmployee($id);
        }

        $employees = Employees::find()->with(
            'fkPosition',
            'fkEmploymentStatus',
            'fkCluster',
            'fkRegion',
            'fkRegionArea',
            'fkCity'
        )->all();

        // Transforming the result to the desired format
        $formattedEmployees = [];
        foreach ($employees as $employee) {
            $formattedEmployee = $this->getFormattedEmployee($employee);
            $formattedEmployees[] = $formattedEmployee;
        }
        return $formattedEmployees;
    }
    public function actionCreateEmployees()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $employees = new Employees();

        $employees->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($employees->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return $employees;
        } else {
            return ['errors' => $employees->errors];
        }
    }
    private function actionViewEmployee($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if $id is provided
        if ($id === null) {
            Yii::$app->response->statusCode = 400; // Bad Request
            return ['success' => false, 'error' => 'Missing required parameter: id'];
        }

        // Find the employee by ID
        $employee = Employees::findOne($id);

        // Check if the employee exists
        if ($employee === null) {
            Yii::$app->response->statusCode = 404; // Not Found
            return ['success' => false, 'error' => 'Employee not found.'];
        }

        // Return the formatted employee data
        return $this->getFormattedEmployee($employee);
    }
    public function actionUpdateEmployees($id = null)
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if ($id === null) {
            return [
                'success' => false,
                'error' => 'Missing parameter',
                'message' => 'The required parameter id is missing.'
            ];
        }

        $employees = Employees::findOne($id);
        if ($employees === null) {
            return [
                'success' => false,
                'error' => 'Employee not found',
                'message' => 'Employee not found for the given ID.'
            ];
        }
        $employees->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($employees->save()) {
            return $employees;
        } else {
            return [
                'success' => false,
                'errors' => $employees->errors,
                'message' => 'Failed to update product.'
            ];
        }
    }
    private function getFormattedEmployee($employee)
    {
        $formattedEmployee = [
            'id' => $employee->id,
            'employee_id' => $employee->employee_id,
            'fk_position' => $employee->fkPosition->position,
            'fname' => $employee->fname,
            'mname' => $employee->mname,
            'lname' => $employee->lname,
            'suffix' => $employee->suffix,
            'bday' => $employee->bday,
            'gender' => $employee->gender,
            'contact_number' => $employee->contact_number,
            'fk_cluster' => $employee->fkCluster->cluster,
            'fk_region' => $employee->fkRegion->region,
            'fk_region_area' => $employee->fkRegionArea->province,
            'fk_city' => $employee->fkCity->city,
            'house_address' => $employee->house_address,
            'date_hired' => $employee->date_hired,
            'end_of_contract' => $employee->end_of_contract,
            'fk_employment_status' => $employee->fkEmploymentStatus->status,
            'emergency_contact_persons' => $employee->emergency_contact_persons,
            'emergency_contact_numbers' => $employee->emergency_contact_numbers,
            'emergency_contact_relations' => $employee->emergency_contact_relations,
            'availability' => $employee->availability ? 'Active' : 'Inactive',
            'logged_by' => $employee->logged_by,
            'logged_time' => $employee->logged_time,
            'updated_by' => $employee->updated_by,
            'updated_time' => $employee->updated_time,
        ];
        return $formattedEmployee;
    }





//      -- ADDRESS --
//      -- CLUSTER --
    public function actionCluster()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cluster = Clusters::find()->all();

        return $cluster;
    }
//      -- REGION --
    public function actionRegion()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $region = Regions::find()->all();

        return $region;
    }
//      -- PROVINCE / REGION AREA --
    public function actionProvince()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $province = Provinces::find()->all();

        return $province;
    }
//      -- CITY --
    public function actionCity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cities = Cities::find()->all();

        return $cities;
    }
//      -- POSTION --
    public function actionPosition()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $position = Positions::find()->all();

        return $position;
    }
//      -- STATUS --
    public function actionStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $status = Positions::find()->all();

        return $status;
    }

}
