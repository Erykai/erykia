<?php

namespace Modules\User\View;

use Modules\User\View\ViewTrait\All;
use Modules\User\View\ViewTrait\Destroy;
use Modules\User\View\ViewTrait\Edit;
class View extends Resource
{
    use Edit;
    use Destroy;
    use All;
}