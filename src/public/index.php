<?php
require '../bootstrap/autoload.php';

$app = require_once '../bootstrap/app.php';


require '../dependency/dependencyCenter.php';

require '../routers/routerGate.php';

$app->run();
