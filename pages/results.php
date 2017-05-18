<article>
<?php
chdir('data/'.$hash);

$result_url = BASEURL."/data/".$hash;
$this_page = BASEURL."/results/".$hash;

$smiles = file_get_contents('example.smiles');
$smiles = str_replace("comp1 ", "", $smiles);

$error = False;

?>
    <p class="center">
        <a href="<?php echo $this_page ?>"><?php echo $this_page ?></a>
        <br />
        <br />
        <br />
    </p>

<?php
// Check Status
$submitted = file_exists('example.csv');
$queued = file_exists('example.slurm');
$calculated = file_exists('example.svg');

if(!$submitted)
{
    shell_exec(PEXE.' '.RPATH.'/RegioSQM1.py example.smiles > example.csv');

}else{

    $wc = shell_exec('wc -l example.csv');

    if($wc<2){
        $error=True;
        print "<h2>Could not protonate SMILES</h2>";
    }

}

if(!$queued && !$error)
{
    $squeue = shell_exec('ssh -i /home/yensen/.ssh/id_rsa yensen@sunray "squeue | grep yensen"');

    if($squeue != "")
    {
        echo "<h1>Queue is busy. Try again later</h1>";
        echo "<p class=\"center\">".$squeue."</p>";
        $error = True;
    }
    else
    {
        shell_exec('ssh -i /home/yensen/.ssh/id_rsa yensen@sunray "mkdir data/'.$hash.'" > example.log');
        shell_exec('scp -i /home/yensen/.ssh/id_rsa *sdf *smiles *csv *mop yensen@sunray:data/'.$hash.' 2>> example.log >> example.log');
        $slurm_id = shell_exec('ssh -i /home/yensen/.ssh/id_rsa yensen@sunray "~/bin/submit_regiosqm '.$hash.'" 2>> example.log');

        file_put_contents('example.slurm', $slurm_id);
    }
}

if(!$calculated && !$error)
{
    // Check if calculation is finished
    $slurm_id = file_get_contents('example.slurm');

    // squeue -u yensen | grep 734327
    $squeue = shell_exec('ssh -i /home/yensen/.ssh/id_rsa yensen@sunray "squeue | grep '.$slurm_id.' "');

    if($squeue == "")
    {
        // shell_exec('scp -i /home/yensen/.ssh/id_rsa yensen@sunray:data/'.$hash.'/batch_mop_out.tar.gz . 2>> example.log >> example.log');
        // shell_exec('tar -xzvf batch_mop_out.tar.gz >> example.log 2>> example.log');

        # Analyse results
        // shell_exec(PEXE.' '.RPATH.'/RegioSQM2.py example.smiles example.csv 2>> example.log >> example.log');

        shell_exec('ssh -i /home/yensen/.ssh/id_rsa yensen@sunray "~/bin/analyse_regiosqm '.$hash.'" 2>> example.log');
        shell_exec('scp -i /home/yensen/.ssh/id_rsa yensen@sunray:data/'.$hash.'/example.svg . 2>> example.log >> example.log');

        $calculated = True;
    }
    else
    {
?>
        <h1>Your calculation is in queue or running</h1>
        <h2><a href="<?php echo $this_page ?>">Refresh</a> this page in a few minutes.</h2>
        <p class="center"><?php echo $squeue ?></p>
<?php
    }
}

?>


<h2><?php echo $smiles ?></h2>

<?php if($calculated && !$error):

?>

    <p class="center">
        <img src="<?php echo $result_url?>/example.svg" style="width:80%" />
    </p>

<?php endif; ?>

</article>

