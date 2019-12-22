<?php

$contents_list = array(
    "dtigxv",
    "oxyhbq",
    "vwnyom",
    "yfilpx",
    "unrip",
    "gxqgmt",
    "mxstffs",
    );
$path = "/var/www/";

$to = "example@example.com";
$subject = "Malware server";
$txt = "This email is coming because some infected files have been found on your web server\n\n";
$headers = "From: yourserver@example.com";

$delete = FALSE;


$pattern = implode('\|', $contents_list) ;
$command = "grep -rnwl '$pattern' $path";
$output = array();
$dirs = array();
exec($command, $output);

if (count ($output)) {
    $txt .= "=== Deleted files===\n\n";
}

foreach ($output as $match) {
    $msg = "removing ... > ".$match . "\n";
    echo $msg;
    $txt .= $msg;
    if ($delete) unlink($match);

    $dirs[dirname($match)] = $match;
}

if ($delete) {
    $txt .= " Files have been deleted.\n";
} else {
    $msg = " ATTENTION: Files have NOT been deleted.\n";
    echo $msg;
    $txt .= $msg;
}

if (count ($output)) {
    $txt .= "\n\n\n=== Infected Directory ===\n\n";
}

foreach (array_keys($dirs) as $dir) {
    $msg = "       > ".$dir . "\n"
    echo $msg;
    $txt .= $msg;
}


if (count ($output)) {
    mail($to,$subject,$txt,$headers);
}

