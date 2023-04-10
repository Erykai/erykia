<?php

namespace Modules\Example\Controller;

use Modules\Example\Controller\ExampleTrait\Destroy;
use Modules\Example\Controller\ExampleTrait\Edit;
use Modules\Example\Controller\ExampleTrait\Read;
use Modules\Example\Controller\ExampleTrait\Store;
use Source\Controller\System\Resource; // This is the class that extends the Controller class

class ExampleController extends Resource
{
    use Store;
    use Edit;
    use Read;
    use Destroy;
}