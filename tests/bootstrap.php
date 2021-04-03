<?php
if (!($omekaDir = getenv('OMEKA_DIR'))) {
    $omekaDir = dirname(dirname(dirname(__FILE__))) . "/omeka";
}

require_once "{$omekaDir}/application/tests/bootstrap.php";
require_once 'S8F_Test_AppTestCase.php';