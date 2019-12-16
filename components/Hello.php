<?php

namespace app\components;

use yii\base\BaseObject;
use yii\db\Connection;

class Hello extends BaseObject
{

    private $db;

    public function __construct(Connection $db, $config = [])
    {
        $this->db = $db;
        parent::__construct($config);
    }

}
