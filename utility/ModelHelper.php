<?php

// app\utility\ModelHelper.php

namespace app\utility;

use yii\helpers\ArrayHelper;

class ModelHelper
{
    public static function fetchAndMapData($modelClass, $keyAttribute, $valueAttribute)
    {
        $data = $modelClass::find()->select([$keyAttribute, $valueAttribute])->asArray()->all();
        return ArrayHelper::map($data, $keyAttribute, $valueAttribute);
    }
}
