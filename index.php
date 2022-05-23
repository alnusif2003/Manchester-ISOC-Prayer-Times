<?php

error_reporting(0);
include('functions.php');






if ($_SERVER['REQUEST_METHOD'] == "GET") {

    echo main();
}
