<?php

require_once('pclzip.lib.php');
$zip = new PclZip('Backup_sipive_ftpsite_20141222.zip');

$zip->create('../../sipive_bck/sipiveMon12222014.sql');
?>