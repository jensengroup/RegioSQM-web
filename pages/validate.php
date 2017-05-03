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

$hash = md5($smiles);

// $smiles = escapeshellarg($smiles);
// $smiles = escapeshellcmd($smiles);

if(is_dir('data/'.$hash))
{
    print $hash;
    exit();
}

# TODO Check for validation of SMILES

mkdir('data/'.$hash);
chdir('data/'.$hash);

file_put_contents('example.smiles', 'comp1  '.$smiles);

shell_exec(PEXE.' '.RPATH.'/RegioSQM1.py example.smiles');

print $hash;
exit();

