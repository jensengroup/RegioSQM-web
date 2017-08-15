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
    shell_exec(str_replace("{HASH}", $hash, EXE_REGIOSQM1).' > example.csv');

}else{

    $wc = shell_exec('wc -l example.csv');

    if($wc<2){
        $error=True;
        print "<h2>Could not protonate SMILES</h2>";
    }

}

if(!$queued && !$error)
{
    $squeue = shell_exec(EXE_STATUS);

    if($squeue != "")
    {
        echo "<h1>Queue is busy. Try again later</h1>";
        echo "<p class=\"center\">".$squeue."</p>";
        $error = True;
    }
    else
    {
        $slurm_id = shell_exec(str_replace("{HASH}", $hash, EXE_CALCULATE));
        file_put_contents('example.slurm', $slurm_id);
    }
}

if(!$calculated && !$error)
{
    // Check if calculation is finished
    $slurm_id = file_get_contents('example.slurm');

    // Status
    $squeue = shell_exec(EXE_STATUS." | grep ".$slurm_id);

    if($squeue == "")
    {

        shell_exec(str_replace("{HASH}", $hash, EXE_REGIOSQM2)." >> example.log ");
        shell_exec(str_replace("{HASH}", $hash, EXE_REGIOSQM2_COLLECT)." >> example.log ");

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

