<?php

namespace Modules\Example\View;

use Modules\Example\View\ViewTrait\Read;
use Modules\Example\View\ViewTrait\Store;
use Modules\Example\View\ViewTrait\All;
use Modules\Example\View\ViewTrait\Destroy;
use Modules\Example\View\ViewTrait\Edit;
use Modules\Example\View\ViewTrait\Trash;

class View extends Resource
{
    use Read;
    use Store;
    use Edit;
    use Trash;
    use Destroy;
    use All;
}