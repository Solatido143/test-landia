<?php

namespace app\controllers;

use app\models\Attendances;
use app\models\Cities;
use app\models\Clusters;
use app\models\Employees;
use app\models\EmployeesStatus;
use app\models\Positions;
use app\models\Provinces;
use app\models\Regions;
use app\models\RegisterForm;
use app\models\Services;
use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
//    -- Attendance --
    public function actionAttendance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $queryParams = Yii::$app->request->queryParams;

        // Check for invalid query parameters
        foreach ($queryParams as $attribute => $value) {
            if (!in_array($attribute, ['id', 'fk_employee', 'date', 'sign_in', 'sign_out', 'remarks', 'sign_in_log', 'sign_out_log'])) {
                return [
                    'success' => false,
                    'error' => "Invalid query parameter: $attribute",
                ];
            }
        }

        // Initialize the query with the Attendances model
        $query = Attendances::find();

        // Apply conditions based on query parameters
        foreach ($queryParams as $attribute => $value) {
            $query->andWhere([$attribute => $value]);
        }

        // Sort the query by 'id' in descending order
        $query->orderBy(['id' => SORT_DESC]);

        // Execute the query to fetch attendance records
        $attendances = $query->all();

        if (empty($attendances)) {
            return [
                'success' => false,
                'error' => 'No attendance records found'
            ];
        }

        // Fetch the corresponding employee data for each attendance record
        foreach ($attendances as &$attendance) {
            // Retrieve the employee record based on the fk_employee value
            $employee = Employees::findOne($attendance->fk_employee);

            // If employee record is found, include the first name in the JSON response
            if ($employee !== null) {
                // Convert attendance record and include 'full_name' field
                $attendanceArray = $attendance->toArray();
                $attendanceArray['full_name'] = $employee->fname;
                unset($attendanceArray['fname']); // Remove 'fname' field if it exists
                $attendance = $attendanceArray; // Assign the modified array back to $attendance
            }
        }

        return $attendances;
    }

    public function actionCreateAttendance()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $fkEmployeeId = Yii::$app->request->getBodyParam('fk_employee_id');
        if ($fkEmployeeId === null) {
            return [
                'errors' => [
                    'fk_employee_id' => ['Fk Employee cannot be blank.']
                ]
            ];
        }
        $employee = Employees::findOne(['employee_id' => $fkEmployeeId]);
        if ($employee === null) {
            return [
                'success' => false,
                'name' => 'Employee Not Found',
                'message' => 'No employee found for fk_employee_id: ' . $fkEmployeeId
            ];
        }

        // Check if the employee has an attendance record for today with no sign-out time
        $existingAttendance = Attendances::find()
            ->where([
                'fk_employee' => $employee->id,
                'date' => date('m-d-Y'),
                'sign_out' => ''
            ])
            ->exists();

        if ($existingAttendance) {
            return [
                'success' => false,
                'message' => 'Employee already has an attendance record for today with no sign-out time.'
            ];
        }

        $attendances = new Attendances();
        $attendances->fk_employee = $employee->id;
        $attendances->date = date('m-d-Y');
        $attendances->sign_in = date('H:i');
        $attendances->sign_in_log = "Time In";
        $attendances->sign_out = "";
        $attendances->remarks = "";

        $attendances->load(Yii::$app->request->getBodyParams(), '');

        if ($attendances->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return ['success' => true];
        } else {
            return ['errors' => $attendances->errors];
        }
    }
    public function actionUpdateAttendance()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $fkEmployeeId = Yii::$app->request->getBodyParam('fk_employee_id');
        $employee = Employees::findOne(['employee_id' => $fkEmployeeId]);

        if ($employee === null) {
            return [
                'success' => false,
                'message' => 'Employee not found for fk_employee_id: ' . $fkEmployeeId
            ];
        }

        $attendances = Attendances::find()
            ->where(['fk_employee' => $employee->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if ($attendances === null) {
            return [
                'success' => false,
                'message' => 'No attendance record found for the employee.'
            ];
        }
        if (!empty($attendances->sign_out)) {
            return [
                'success' => false,
                'message' => 'Employee has already timed out.'
            ];
        }

        // Update sign_out and sign_out_log
        $attendances->sign_out = date('H:i:s');
        $attendances->sign_out_log = "Time Out";

        // Perform validation and save the updated record
        if ($attendances->save()) {
            return ['success' => true];
        } else {
            return ['errors' => $attendances->errors];
        }
    }
    public function actionViewAttendance($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if $id is provided
        if ($id === null) {
            return [
                'success' => false,
                'name' => 'Bad Request',
                'message' => 'Missing required parameter: id'];
        }

        $attendance = Attendances::findOne($id);
        if ($attendance === null) {
            return [
                'isAttendanceExist' => false,
                'message' => 'Attendance not found.' ];
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
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $employees = new Employees();

        $employees->logged_time = date('Y-m-d H:i:s');

        $employees->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($employees->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return ['success' => true];
        } else {
            return [
                'errors' => $employees->errors,
                'success' => false,
            ];
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
            return ['success' => true];
        } else {
            return [
                'success' => false,
                'errors' => $employees->errors,
                'message' => 'Failed to update employee.'
            ];
        }
    }
    private function getFormattedEmployee($employee)
    {
        return [
            'id' => $employee->id,
            'employee_id' => $employee->employee_id,
            'fk_position' => $employee->fk_position,
            'fname' => $employee->fname,
            'mname' => $employee->mname,
            'lname' => $employee->lname,
            'suffix' => $employee->suffix,
            'bday' => $employee->bday,
            'gender' => $employee->gender,
            'contact_number' => $employee->contact_number,
            'fk_cluster' => $employee->fk_cluster,
            'fk_region' => $employee->fk_region,
            'fk_region_area' => $employee->fk_region_area,
            'fk_city' => $employee->fk_city,
            'house_address' => $employee->house_address,
            'date_hired' => $employee->date_hired,
            'end_of_contract' => $employee->end_of_contract,
            'fk_employment_status' => $employee->fk_employment_status,
            'emergency_contact_persons' => $employee->emergency_contact_persons,
            'emergency_contact_numbers' => $employee->emergency_contact_numbers,
            'emergency_contact_relations' => $employee->emergency_contact_relations,
            'availability' => $employee->availability,
            'logged_by' => $employee->logged_by,
            'logged_time' => $employee->logged_time,
            'updated_by' => $employee->updated_by,
            'updated_time' => $employee->updated_time,
        ];
    }





//      -- CRPC ADDRESS --
//-- CLUSTER --
    public function actionCluster()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $queryParams = Yii::$app->request->queryParams;

        return Clusters::find()->all();
    }
//-- REGION --
    public function actionRegion()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch regions along with their associated clusters
        $regions = Regions::find()->with('fkCluster')->all();

        // Format the regions data
        $formattedRegions = [];
        foreach ($regions as $region) {
            $formattedRegion = [
                'id' => $region->id,
                'fk_cluster' => $region->fk_cluster,
                'region' => $region->region,
            ];
            $formattedRegions[] = $formattedRegion;
        }
        return $formattedRegions;
    }
//-- PROVINCE / REGION AREA --
    public function actionProvince()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $provinces = Provinces::find()->with('fkRegion')->all();

        // Format the provinces data
        $formattedProvinces = [];
        foreach ($provinces as $province) {
            $formattedProvinces[] = [
                'id' => $province->id,
                'fk_region' => $province->fk_region,
                'province' => $province->province,
            ];
        }
        return $formattedProvinces;
    }
//-- CITY --
    public function actionCity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cities = Cities::find()->with('fkProvince')->all();

        // Format the cities data
        $formattedCities = [];
        foreach ($cities as $city) {
            $formattedCities[] = [
                'id' => $city->id,
                'fk_province' => $city->fk_province,
                'city' => $city->city,
            ];
        }

        return $formattedCities;
    }
//-- POSTION --
    public function actionPositions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Positions::find()->all();
    }
//-- STATUS --
    public function actionStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return EmployeesStatus::find()->all();
    }




//  ----- User Accounts -----
    public function actionUserList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch query parameters
        $queryParams = Yii::$app->request->queryParams;

        // Check if expand parameter is set
        $expandFields = [];
        if (isset($queryParams['expand'])) {
            $expandFields = explode(',', $queryParams['expand']);
            unset($queryParams['expand']);
        }

        // Initialize the query with the User model
        $query = User::find()->select(['username', 'fk_employee_id', 'email', 'user_access']);

        // Include expanded fields in the query
        foreach ($expandFields as $field) {
            $query->addSelect($field);
        }

        // Apply conditions based on query parameters
        foreach ($queryParams as $attribute => $value) {
            $query->andWhere([$attribute => $value]);
        }

        // Execute the query to fetch users
        $users = $query->all();

        return $users;
    }
    public function actionCreateUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new RegisterForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate()) {
            if ($model->register()) {
                Yii::$app->getResponse()->setStatusCode(201); // Created
                Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                return $model;
            } else {
                Yii::$app->getResponse()->setStatusCode(500); // Internal Server Error
                return ['error' => 'Failed to register user.', 'success' => false];
            }
        } else {
            $errors = $model->errors;
            if (isset($errors['username']) && strpos($errors['username'][0], 'This username has already been taken.') !== false) {
                Yii::$app->getResponse()->setStatusCode(400); // Bad request
                return ['error' => 'Username already exists.', 'success' => false];
            } elseif (isset($errors['email']) && strpos($errors['email'][0], 'is not a valid email address.') !== false) {
                Yii::$app->getResponse()->setStatusCode(400); // Bad request
                return ['error' => 'Invalid email address.', 'success' => false];
            } else {
                Yii::$app->getResponse()->setStatusCode(422); // Unprocessable Entity
                return ['errors' => $errors];
            }
        }
    }
    public function actionUpdateUsers($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = User::findOne($id);
        if ($model === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'User not found.'
            ];
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } else {
            return ['errors' => $model->errors];
        }
    }
    public function actionDeleteUsers($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = User::findOne($id);
        if ($model === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'User not found.'
            ];
        }
        $model->delete();
        Yii::$app->getResponse()->setStatusCode(204); // No content
    }
    public function actionValidateLogin($username, $password)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Find the user by username
        $user = User::findOne(['username' => $username]);
        if ($user !== null) {
            // Validate the password
            if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
                // Password is correct
                return ['success' => true];
            }
        }
        return ['success' => false];
    }

    public function actionServices()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $queryParams = Yii::$app->request->queryParams;

        $services = Services::find()->all();

        if ($services) {
            return $services;
        } else {
            return ['error' => 'No services found.'];
        }
    }
    public function actionCreateService()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $services = new Services();

        $services->logged_time = date('h:i:s a');
        $services->updated_by = "";
        $services->updated_time = "";

        $services->load(Yii::$app->request->getBodyParams(), '');

        if ($services->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return ['success' => true];
        } else {
            return [
                'errors' => $services->errors,
                'success' => false,
            ];
        }
    }

}
