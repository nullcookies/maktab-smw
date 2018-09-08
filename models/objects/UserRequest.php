<?php

namespace models\objects;

use \system\ActiveRecord;

class UserRequest extends ActiveRecord
{

    const STATUS_PENDING    = 0;
    const STATUS_ACCEPTED   = 1;
    const STATUS_REJECTED   = -1;

    const TYPE_ADD_USER_STUDENT = 'add student to user';

}
