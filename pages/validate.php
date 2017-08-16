<?php

if(!isset($_POST['smiles']))
{
    echo "No SMILES code given";
    exit();
}

$smiles = $_POST['smiles'];
$smiles = trim($smiles);

if($smiles == ""){
    print "No SMILES code given.";
    exit();
}

if ( strpos($smiles, '.') !== False )
{
    print "Only single molecules are allowed.";
    exit();
}

// $smiles = escapeshellcmd($smiles);
// $smiles = escapeshellarg($smiles);


$hash = md5($smiles);
if(is_dir('data/'.$hash))
{
    print $hash;
    exit();
}

mkdir('data/'.$hash);
chdir('data/'.$hash);

file_put_contents('example.smiles', 'comp1  '.$smiles);


// Check for validation of SMILES
// will return 1 if valid
$valid = shell_exec(str_replace("{HASH}", $hash, EXE_VALIDATE));
if($valid != 1)
{
    print "Could not genereate molecule. Is the SMILES input correct?";
    array_map('unlink', glob("$hash/*.*"));
    rmdir($hash);
    exit();
}

// shell_exec(PEXE.' '.RPATH.'/RegioSQM1.py example.smiles > example.csv');

print $hash;
exit();

