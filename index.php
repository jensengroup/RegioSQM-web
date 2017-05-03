<?php

$protocol = 'http';
$servername = $_SERVER['SERVER_NAME'];
$serverport = ($_SERVER['SERVER_PORT'] == '80') ? '' : ':' . $_SERVER['SERVER_PORT'];
$path = dirname($_SERVER["SCRIPT_NAME"]);
$path = str_replace('\\', '/', $path); // helps with windows
$base = $protocol . '://' . preg_replace('/\/+/', '/', $servername . $serverport . $path);
$base = preg_replace('/application/','', $base); // remove 'application'

define('BASEURL', preg_replace("/\/$/i", '', $base)); // no trailing slashes


// path to the system folder
$system_path = '.';
if (realpath($system_path) !== FALSE)
{
    $system_path = realpath($system_path).'/';
}


// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';


// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));


// Check if call is ajax type
define('AJAX', isset($_POST['ajax']));


// Load config
$ini = parse_ini_file("settings.ini");

define('RPATH', $ini['regiopath']);
define('PEXE', $ini['pythonenv']);
define('MOPAC', $ini['mopacpath']);

// Parse the request
if(isset($_GET['request']))
{
    $request = explode('/', $_GET['request']);
}
else
{
    $request = array(0 => '');
}

if($request[0] == '')
{
    $view = 'frontpage';
}
else
{
    $view = $request[0];
}

if(isset($request[1]))
{
    $hash = $request[1];
    if(!is_dir('data/'.$hash)) $view = '404';
}

if(!file_exists('pages/'.$view.'.php')) $view = "404";

if(AJAX)
{
    include('pages/'.$view.'.php');
    exit();
}
else
{
    include('template.php');
}
