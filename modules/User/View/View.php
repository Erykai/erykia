<?php

namespace Modules\User\View;

use Modules\User\View\ViewTrait\Read;
use Modules\User\View\ViewTrait\Store;
use Modules\User\View\ViewTrait\All;
use Modules\User\View\ViewTrait\Destroy;
use Modules\User\View\ViewTrait\Edit;
use Modules\User\View\ViewTrait\Trash;

class View extends Resource
{
    use Read;
    use Store;
    use Edit;
    use Trash;
    use Destroy;
    use All;
}