<?php

namespace app\controllers;

use app\models\Attendances;
use app\models\Bookings;
use app\models\BookingsStatus;
use app\models\Cities;
use app\models\Clusters;
use app\models\Customers;
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
    public function actionGetAttendance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $queryParams = Yii::$app->request->queryParams;
        $query = Attendances::find();
        $fields = ['id', 'fk_employee', 'date', 'sign_in', 'sign_out', 'remarks'];
        if (isset($queryParams['expand'])) {
            if ($queryParams['expand'] == 'all') {
                $fields = ['*'];
            } else {
                $expandFields = explode(',', $queryParams['expand']);
                foreach ($expandFields as $expandField) {
                    if (in_array($expandField, ['sign_in_log', 'sign_out_log'])) {
                        $fields[] = $expandField;
                    }
                }
            }
        }
        $query->select($fields);
        foreach ($queryParams as $key => $value) {
            if (in_array($key, ['id', 'fk_employee', 'date', 'sign_in', 'sign_out', 'remarks', 'sign_in_log', 'sign_out_log'])) {
                $query->andWhere([$key => $value]);
            }
        }
        $query->orderBy(['id' => SORT_DESC]);
        $attendances = $query->all();
        if (!empty($attendances)) {
            // Fetch the corresponding employee data for each attendance record
            foreach ($attendances as &$attendance) {
                // Retrieve the employee record based on the fk_employee value
                $employee = Employees::findOne($attendance->fk_employee);

                // If employee record is found, include the first name in the JSON response
                if ($employee !== null) {
                    // Convert attendance record and include 'full_name' field
                    $attendanceArray = $attendance->toArray();
                    $attendanceArray['full_name'] = $employee->fname . " " . $employee->lname;
                    $attendance = $attendanceArray; // Assign the modified array back to $attendance
                }
            }
            return $attendances;
        } else {
            Yii::$app->response->statusCode = 404; // Not Found
            return ['error' => 'No attendance found matching the provided criteria.'];
        }
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
        $attendances->sign_out = date('H:i');
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
    public function actionGetUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // Fetch the query parameters
        $queryParams = Yii::$app->request->queryParams;
        // Start building the query
        $query = User::find();
        // Select only specific fields
        $fields = ['id', 'username', 'fk_employee_id', 'email', 'status', 'user_access', 'availability'];

        // Check if the expand parameter is present and set to all
        if (isset($queryParams['expand'])) {
            if ($queryParams['expand'] == 'all') {
                $fields = ['*'];
            } else {
                $expandFields = explode(',', $queryParams['expand']);
                foreach ($expandFields as $expandField) {
                    if (in_array($expandField, ['password_reset_token', 'created_at', 'updated_at', 'auth_key', 'verification_token', 'managers_code'])) {
                        $fields[] = $expandField;
                    }
                }
            }
        }
        $query->select($fields);
        foreach ($queryParams as $key => $value) {
            // Only consider parameters that match column names in the Services model
            if (in_array($key, ['id', 'username', 'fk_employee_id', 'email', 'status', 'user_access', 'availability'])) {
                $query->andWhere([$key => $value]);
            }
        }
        // Execute the query
        $users = $query->all();
        // Return the results or an error if no users found
        if (!empty($users)) {
            return $users;
        } else {
            Yii::$app->response->statusCode = 404; // Not Found
            return ['error' => 'No users found.'];
        }
    }
    public function actionCreateUser()
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
    public function actionUpdateUser($id)
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
    public function actionUserLoginValidation($username, $password)
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





//  ----- SERVICES -----
    public function actionGetServices()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // Fetch the query parameters
        $queryParams = Yii::$app->request->queryParams;
        // Start building the query
        $query = Services::find();
        // Select only specific fields
        $fields = ['id', 'service_name', 'service_fee', 'completion_time', 'availability'];
        // Check if the expand parameter is present and set to all
        if (isset($queryParams['expand'])) {
            if ($queryParams['expand'] == 'all') {
                $fields = ['*'];
            } else {
                $expandFields = explode(',', $queryParams['expand']);
                foreach ($expandFields as $expandField) {
                    if (in_array($expandField, ['logged_by', 'logged_time', 'updated_by', 'updated_time'])) {
                        $fields[] = $expandField;
                    }
                }
            }
        }
        $query->select($fields);
        // Check each query parameter and apply it to the query if provided
        foreach ($queryParams as $key => $value) {
            // Only consider parameters that match column names in the Services model
            if (in_array($key, ['id', 'service_name', 'service_fee', 'completion_time', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'availability'])) {
                $query->andWhere([$key => $value]);
            }
        }
        // Execute the query
        $services = $query->all();
        // Return the results or an error if no services found
        if (!empty($services)) {
            return $services;
        } else {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'success' => false,
                'error' => 'No services found matching the provided criteria.'
            ];
        }
    }
    public function actionCreateService()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $services = new Services();

        $services->logged_time = date('H:i:s a');
        $services->updated_by = "";
        $services->updated_time = "";

        $services->load(Yii::$app->request->getBodyParams(), '');

        if ($services->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return [
                'success' => true
            ];
        } else {
            return [
                'errors' => $services->errors,
                'success' => false,
            ];
        }
    }
    public function actionUpdateService($id = null)
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id === null || $id === '') {
            Yii::$app->response->statusCode = 400; // Bad Request
            return [
                'success' => false,
                'message' => 'Missing required parameters: id',
            ];
        }

        $service = Services::findOne($id);

        if ($service === null) {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'success' => false,
                'message' => 'Service not found',
            ];
        }
        $service->load(Yii::$app->getRequest()->getBodyParams(), '');
        $service->updated_time = date('H:i:s');
        if ($service->save()) {
            return $service;
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update service',
                'errors' => $service->errors,
            ];
        }
    }





//  ----- BOOKINGS -----
    public function actionGetBookings()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $bookings = Bookings::find()->all();

        if (!empty($bookings))
        {
            return $bookings;
        } else {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'bookings' => $bookings,
                'success' => false,
                'error' => 'No bookings found'
            ];
        }
    }
    public function actionCreateBooking()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $booking = new Bookings();
        $booking->logged_time = date('Y-m-d H:i:s');
        $booking->fk_booking_status = 1;
        $booking->load(Yii::$app->request->getBodyParams(), '');
        if ($booking->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return ['success' => true];
        } else {
            return [
                'errors' => $booking->errors,
                'success' => false
            ];
        }
    }
    public function actionUpdateBooking($id = null){
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id === null) {
            Yii::$app->response->statusCode = 400; // Bad Request
            return [
                'success' => false,
                'message' => 'Missing required parameter: id',
            ];
        }

        $booking = Bookings::findOne($id);

        if ($booking === null) {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'success' => false,
                'message' => 'Service not found',
            ];
        }

        // Check if $booking->fk_booking_status is equal to 3 or 4
        if ($booking->fk_booking_status == 3 || $booking->fk_booking_status == 4) {
            Yii::$app->response->statusCode = 403; // Forbidden
            return [
                'success' => false,
                'message' => 'Cannot update booking with status Complete or Cancelled',
            ];
        }

        $booking->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($booking->save()) {
            $booking->updated_time = date('Y-m-d H:i:s');
            return $booking;
        } else {
            return [
                'message' => 'Failed to update service',
                'success' => false,
                'errors' => $booking->errors,
            ];
        }
    }
//  ----- CUSTOMER -----
    public function actionGetCustomers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $queryParams = Yii::$app->request->queryParams;
        // Start building the query
        $query = Customers::find();
        // Select only specific fields
        $fields = ['id', 'customer_name', 'contact_number'];
        if (isset($queryParams['expand'])) {
            if ($queryParams['expand'] == 'all') {
                $fields = ['*'];
            } else {
                $expandFields = explode(',', $queryParams['expand']);
                foreach ($expandFields as $expandField) {
                    if (in_array($expandField, ['logged_by', 'logged_time', 'updated_by', 'updated_time'])) {
                        $fields[] = $expandField;
                    }
                }
            }
        }
        $query->select($fields);
        // Check each query parameter and apply it to the query if provided
        foreach ($queryParams as $key => $value) {
            // Only consider parameters that match column names in the Services model
            if (in_array($key, ['id', 'customer_name', 'contact_number', 'logged_by', 'logged_time', 'updated_by', 'updated_time'])) {
                $query->andWhere([$key => $value]);
            }
        }
        // Execute the query
        $customers = $query->all();
        // Return the results or an error if no services found
        if (!empty($customers)) {
            return $customers;
        } else {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'success' => false,
                'error' => 'No services found matching the provided criteria.'
            ];
        }
    }
    public function actionCreateCustomers()
    {
        date_default_timezone_set('Asia/Manila');
        Yii::$app->response->format = Response::FORMAT_JSON;

        $customer = new Customers();
        $customer->load(Yii::$app->request->getBodyParams(), '');
        $customer->logged_time = date('m-d-Y H:i:s');
        $customer->updated_by = '';
        $customer->updated_time = '';
        if ($customer->save())
        {
            Yii::$app->response->setStatusCode(201);
            return [
                'success' => true,
            ];
        } else {
            return [
                'errors' => $customer->errors,
                'success' => false,
            ];
        }
    }
    public function actionUpdateCustomers($id = null)
    {
        date_default_timezone_set('Asia/Manila');

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id === null) {
            Yii::$app->response->statusCode = 400; // Bad Request
            return [
                'success' => false,
                'message' => 'Missing required parameter: id',
            ];
        }
        $customer = Customers::findOne($id);

        if ($customer === null) {
            Yii::$app->response->statusCode = 404; // Not Found
            return [
                'success' => false,
                'message' => 'Customer not found',
            ];
        }

        $customer->load(Yii::$app->getRequest()->getBodyParams(), '');
        $customer->updated_time = date('Y-m-d H:i:s');
        if ($customer->save()) {
            return $customer;
        } else {
            return [
                'errors' => $customer->errors,
                'success' => false,
                'message' => 'Failed to update customer',
            ];
        }
    }
//  ----- BOOKING STATUS -----
    public function actionGetBookingStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return BookingsStatus::find()->all();
    }

}
