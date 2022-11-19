<?php

use PelFramework\IoC\EntityManager;

include("./ClassInformation.php");
include("./EntityManager.php");
include("./test/testClass.php");
include("./Exceptions/IoCClassNotFoundException.php");
include("./Exceptions/IoCConstructorParametersException.php");

$entitys = new EntityManager();
$class = $entitys->create("myClass","PelFramework\\IoC\\test\\testClass",[]);