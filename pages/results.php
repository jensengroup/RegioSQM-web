<?php
chdir('data/'.$hash);

$result_url = BASEURL."/data/".$hash;
$this_page = BASEURL."/results/".$hash;

$smiles = file_get_contents('example.smiles');
$smiles = str_replace("comp1 ", "", $smiles);

// Check Status
$submitted = file_exists('example.csv');
$queued = file_exists('example.slurm');
$finished = "";
$calculated = file_exists('example.svg');

if(!$submitted)
{
    shell_exec(PEXE.' '.RPATH.'/RegioSQM1.py example.smiles > example.csv');
}

if(!$queued)
{
    shell_exec('for x in *.mop; do '.MOPAC.' $x; done');
    file_put_contents('34234', 'example.slurm');
}

if(!$calculated)
{
    shell_exec(PEXE.' '.RPATH.'/RegioSQM2.py example.smiles example.csv >> example.log');
}

?>
<article>

    <p class="center">
        <a href="<?php echo $this_page ?>"><?php echo $this_page ?></a>
        <br />
        <br />
        <br />
    </p>


    <!-- wait -->
    <!-- <h1>Your calculation is in queue</h1> -->
    <!-- <h2>You are number <strong>45</strong> in queue. <a href="<?php echo $this_page ?>">Refresh</a> this page in a few minutes.</h2> -->


    <!-- -->
    <h1><?php echo $smiles ?></h1>
    <p class="center">
        <img src="<?php echo $result_url?>/example.svg" />
    </p>





</article>

