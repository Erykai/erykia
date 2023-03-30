<?php

namespace Source\Controller\System;

use Source\Controller\System\UserTrait\Destroy;
use Source\Controller\System\UserTrait\Edit;
use Source\Controller\System\UserTrait\Read;
use Source\Controller\System\UserTrait\Store;

class UserController extends Resource
{
    use Store;
    use Edit;
    use Read;
    use Destroy;
}