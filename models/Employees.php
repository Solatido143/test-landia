<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $employee_id
 * @property int $fk_position
 * @property string $fname
 * @property string|null $mname
 * @property string $lname
 * @property string|null $suffix
 * @property string $bday
 * @property string $gender
 * @property string $contact_number
 * @property int $fk_cluster
 * @property int $fk_region
 * @property int $fk_region_area
 * @property int $fk_city
 * @property string $house_address
 * @property string $date_hired
 * @property string|null $end_of_contract
 * @property int $fk_employment_status
 * @property string|null $emergency_contact_persons
 * @property string|null $emergency_contact_numbers
 * @property string|null $emergency_contact_relations
 * @property int $availability
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $updated_by
 * @property string|null $updated_time
 *
 * @property Attendances[] $attendances
 * @property EmployeesServices[] $employeesServices
 * @property Cities $fkCity
 * @property Clusters $fkCluster
 * @property EmployeesStatus $fkEmploymentStatus
 * @property Positions $fkPosition
 * @property Regions $fkRegion
 * @property Provinces $fkRegionArea
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'fk_position', 'fname', 'lname', 'bday', 'gender', 'contact_number', 'fk_cluster', 'fk_region', 'fk_region_area', 'fk_city', 'house_address', 'date_hired', 'fk_employment_status', 'logged_by', 'logged_time'], 'required'],
            [['fk_position', 'fk_cluster', 'fk_region', 'fk_region_area', 'fk_city', 'fk_employment_status', 'availability'], 'integer'],
            [['gender', 'house_address'], 'string'],
            [
                ['contact_number'],
                'match',
                'pattern' => '/^(?:\+639|09)\d{9}$|^\d{3}-\d{4}$|^\d{4}-\d{4}$|^\d{7}$|^\d{8}$|^(\d{4}\s\d{4})$/',
                'message' => 'Please enter a valid contact number',
            ],
            [['employee_id'], 'string', 'max' => 30],
            [['fname', 'mname', 'lname'], 'string', 'max' => 50],
            [['suffix'], 'string', 'max' => 10],
            [['bday', 'contact_number', 'date_hired', 'end_of_contract', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'string', 'max' => 100],
            [['emergency_contact_persons', 'emergency_contact_numbers', 'emergency_contact_relations'], 'string', 'max' => 255],
            [['fk_cluster'], 'exist', 'skipOnError' => true, 'targetClass' => Clusters::class, 'targetAttribute' => ['fk_cluster' => 'id']],
            [['fk_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['fk_region' => 'id']],
            [['fk_region_area'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::class, 'targetAttribute' => ['fk_region_area' => 'id']],
            [['fk_city'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['fk_city' => 'id']],
            [['fk_position'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::class, 'targetAttribute' => ['fk_position' => 'id']],
            [['fk_employment_status'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeesStatus::class, 'targetAttribute' => ['fk_employment_status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'fk_position' => 'Position',
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'lname' => 'Last Name',
            'suffix' => 'Suffix',
            'bday' => 'Birthday',
            'gender' => 'Gender',
            'contact_number' => 'Contact Number',
            'fk_cluster' => 'Cluster',
            'fk_region' => 'Region',
            'fk_region_area' => 'Province',
            'fk_city' => 'City',
            'house_address' => 'House Address',
            'date_hired' => 'Date Hired',
            'end_of_contract' => 'End Of Contract',
            'fk_employment_status' => 'Employment Status',
            'emergency_contact_persons' => 'Emergency Contact Persons',
            'emergency_contact_numbers' => 'Emergency Contact Numbers',
            'emergency_contact_relations' => 'Emergency Contact Relations',
            'availability' => 'Availability',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * Gets query for [[AttendancesSearch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendances::class, ['fk_employee' => 'id']);
    }

    /**
     * Gets query for [[EmployeesServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesServices()
    {
        return $this->hasMany(EmployeesServices::class, ['fk_employee' => 'id']);
    }

    /**
     * Gets query for [[FkCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'fk_city']);
    }

    /**
     * Gets query for [[FkCluster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkCluster()
    {
        return $this->hasOne(Clusters::class, ['id' => 'fk_cluster']);
    }

    /**
     * Gets query for [[FkEmploymentStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkEmploymentStatus()
    {
        return $this->hasOne(EmployeesStatus::class, ['id' => 'fk_employment_status']);
    }

    /**
     * Gets query for [[FkPosition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkPosition()
    {
        return $this->hasOne(Positions::class, ['id' => 'fk_position']);
    }

    /**
     * Gets query for [[FkRegion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'fk_region']);
    }

    /**
     * Gets query for [[FkRegionArea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkRegionArea()
    {
        return $this->hasOne(Provinces::class, ['id' => 'fk_region_area']);
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }
}
