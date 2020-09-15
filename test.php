<?php

require __DIR__ . '/vendor/autoload.php';

use PHPJasper\PHPJasper;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$input = __DIR__ . '/vendor/geekcom/phpjasper/examples/hello_world.jasper';  
$output = __DIR__ . '/vendor/geekcom/phpjasper/examples';    
$options = [ 
    'format' => ['pdf'] 
];

$jasper = new PHPJasper;

$jasper->process(
    $input,
    $output,
    $options
)->execute();

$filename = 'hello_world.pdf';
header('Content-Description: application/pdf');
header('Content-Type: application/pdf');
header('Content-Disposition:; filename=' . $filename);
readfile($output . '/' . $filename);
unlink($output . '/' . $filename);
flush();

?>
