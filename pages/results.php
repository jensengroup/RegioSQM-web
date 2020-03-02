<article>
<?php
chdir('data/'.$hash);

$result_url = BASEURL."/data/".$hash;
$this_page = BASEURL."/results/".$hash;

$smiles = file_get_contents('example.smiles');
$smiles = str_replace("comp1 ", "", $smiles);

$error = False;

?>
<div class="long-text">
    <p class="center">
        <a href="<?php echo $this_page ?>"><?php echo $this_page ?></a>
        <br />
        <br />
        <br />
    </p>
</div>

<?php
// Check Status
$submitted = file_exists('example.csv');
$queued = file_exists('example.slurm');
$calculated = file_exists('example.svg');
$mopac_done = file_exists('mopac_done');


if(!$submitted){

    shell_exec(str_replace("{HASH}", $hash, EXE_SETUP).' > example.csv');

}else{

    $wc = shell_exec('wc -l example.csv');

    if($wc<2){
        $error=True;
        print "<h2>Could not protonate SMILES</h2>";
    }

}

$squeue = shell_exec(EXE_STATUS);
$squeue = explode("\n", $squeue);
$squeue = array_map('trim', $squeue);
$squeue = array_filter($squeue);

if(!$queued && !$error)
{

    if(count($squeue) > SET_MAX_CAL)
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

if(!$mopac_done && !$error)
{
    // Check if calculation is finished
    $slurm_id = file_get_contents('example.slurm');

    // Status
    $squeue = shell_exec(EXE_STATUS." | grep ".$slurm_id);

    if($squeue == "")
    {
        print("Should not happen. Please report.");
    }
    else
    {
?>
        <h1>Your calculation is running</h1>
        <h2><a href="<?php echo $this_page ?>">Refresh</a> this page in a few minutes.</h2>
        <!-- <p class="center"><?php echo $squeue ?></p> -->
<?php
    }
}
else
{

    if(!$calculated)
    {
        shell_exec(str_replace("{HASH}", $hash, EXE_ANALYSE)." >> example.log ");
        shell_exec(str_replace("{HASH}", $hash, EXE_ANALYSE_COLLECT)." >> example.log ");
        $calculated = True;
    }
}

?>


<div class="long-text">
    <h2><?php echo $smiles ?></h2>
</div>

<?php if($calculated && !$error):

?>

    <p class="center">
        <img src="<?php echo $result_url?>/example.svg" style="width:80%" />
    </p>

<?php endif; ?>

</article>

