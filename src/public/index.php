<?php
require '../bootstrap/autoload.php';

$app = require_once '../bootstrap/app.php';


require '../dependency/dependencyCenter.php';
//
//require '../routers/yibanAppCollection.php';
//require '../routers/tokenTransfer.php';
//require '../routers/yibanCrxToolBox.php';
//require '../routers/yibanResetPass.php';
require '../routers/routerGate.php';

$app->run();
