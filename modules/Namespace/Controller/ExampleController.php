<?php


namespace Modules\Namespace\Controller;

use Modules\Namespace\Controller\ExampleTrait\Destroy;
use Modules\Namespace\Controller\ExampleTrait\Edit;
use Modules\Namespace\Controller\ExampleTrait\Read;
use Modules\Namespace\Controller\ExampleTrait\Store;
use Source\Core\Auth;
use Source\Core\Controller;
//dependencies for traits
use Modules\Namespace\Model\Example;
use Source\Core\Response;
use Source\Core\Upload;

//Namespace examples Example example
class ExampleController extends Controller
{
    use Auth;
    use Store;
    use Read;
    use Edit;
    use Destroy;
}