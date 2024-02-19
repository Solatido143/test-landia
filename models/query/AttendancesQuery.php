<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Attendances]].
 *
 * @see \app\models\Attendances
 */
class AttendancesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Attendances[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Attendances|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
