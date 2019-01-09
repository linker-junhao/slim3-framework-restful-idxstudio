<?php
require '../bootstrap/autoload.php';

$app = require_once '../bootstrap/app.php';


require '../dependency/dependencyCenter.php';

require '../routers/web.php';
require '../routers/example.php';
require '../routers/tokenTransferApi.php';
require '../routers/yibanCrxToolBox.php';
require '../routers/yibanResetPass.php';

$app->run();
