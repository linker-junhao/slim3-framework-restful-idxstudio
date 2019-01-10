<?php
require '../bootstrap/autoload.php';

$app = require_once '../bootstrap/app.php';


require '../dependency/dependencyCenter.php';

require '../routers/appCenter.php';
require '../routers/tokenTransfer.php';
require '../routers/yibanCrxToolBox.php';
require '../routers/yibanResetPass.php';

$app->run();
