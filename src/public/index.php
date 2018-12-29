<?php
require '../bootstrap/autoload.php';

$app = require_once '../bootstrap/app.php';


require '../dependency/dependencyCenter.php';

require '../routers/web.php';
require '../routers/api_v1.php';
require '../routers/tokenTransferApi.php';

$app->run();
