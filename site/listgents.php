<?php
$descr = array(
    0 => array(
        'pipe',
        'r'
    ) ,
    1 => array(
        'pipe',
        'w'
    ) ,
    2 => array(
        'pipe',
        'w'
    )
);
$pipes = array();
//$cwd = '/var/ossec/bin';
//Limpiar archivo creación de agente.
//$process = proc_open("cat /dev/null > /var/ossec/newagent.tmp", $descr, $pipes);
//$process = proc_open("sudo /var/ossec/bin/manage_agents -f /newagent.tmp", $descr, $pipes,$cwd);
if (is_resource($process)) {
    while ($f = fgets($pipes[1])) {
        echo "-pipe 1--->";
        echo $f . '</br>';
    }
    fclose($pipes[1]);
    while ($f = fgets($pipes[2])) {
        echo "-pipe 2--->";
        echo $f;
    }
    fclose($pipes[2]);
    proc_close($process);
}
?>
