<?php
// models/EmployeeSelectionForm.php
namespace app\models;

use yii\base\Model;

class EmployeeSelectionForm extends Model
{
    public $selectEmployee;

    public function rules()
    {
        return [
            [['selectEmployee'], 'required', 'message' => 'Please select an employee.'],
            [['selectEmployee'], 'integer'],
        ];
    }
}
