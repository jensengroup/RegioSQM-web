<?php

if(!isset($_POST['smiles']))
{
    echo "No SMILES code given";
    exit();
}

if("" == trim($_POST['smiles'])){
    $smiles = '';

    print "No SMILES code given.";
    exit();
}
else
{
    $smiles = $_POST['smiles'];
}

$smiles = trim($smiles);

if ( strpos($smiles, '.') !== False )
{
    print "Only single molecules are allowed.";
    exit();
}

// $smiles = escapeshellcmd($smiles);
$safesmiles = escapeshellarg($smiles);

# Check for validation of SMILES
$valid = shell_exec(PEXE.' py/validate.py '.$safesmiles);
if($valid != 1)
{
    print "Could not genereate molecule. Is the SMILES input correct?";
    exit();
}

$hash = md5($smiles);
if(is_dir('data/'.$hash))
{
    print $hash;
    exit();
}

mkdir('data/'.$hash);
chdir('data/'.$hash);

file_put_contents('example.smiles', 'comp1  '.$smiles);

shell_exec(PEXE.' '.RPATH.'/RegioSQM1.py example.smiles > example.csv');

print $hash;
exit();

