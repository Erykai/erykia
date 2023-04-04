<?php

namespace Modules\User\Controller;

use Modules\User\Controller\UserTrait\Destroy;
use Modules\User\Controller\UserTrait\Edit;
use Modules\User\Controller\UserTrait\Read;
use Modules\User\Controller\UserTrait\Store;
use Source\Controller\System\Resource; // This is the class that extends the Controller class

class UserController extends Resource
{
    use Store;
    use Edit;
    use Read;
    use Destroy;
}