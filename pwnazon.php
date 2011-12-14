<?php
/*
pwnazon.php - Serves Amazon Kindle formatted ads randomly selected from an images folder
Copyright (C) 2011 Michael Shepard
Email: joelisester@gmail.com

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; version 2 ONLY.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

$tempdir = 'pwnazon_tmp/';
$imagesdirpath = 'pwnazon_images/';

#load the dir into an array
$handle = opendir($imagesdirpath);
$imagesdir = array();
while (false !== ($file = readdir($handle))) {
    $imagesdir[] = $file;
}
    # Select a random banner, extract shortname
$fileselect = $imagesdir[array_rand(preg_grep('/_advert/',$imagesdir))];
$imagepath = $imagesdirpath . $fileselect . '/';
$adid = $_GET['adid'] or $adid = 1234567890123;
# create ad directory
$addir = $tempdir . $adid;
mkdir($addir);
#copy ad + other junk to ad directory
$files = array('screensvr.png', 'banner.gif', 'snippet.json', 'thumb.gif', 'details.html');
foreach($files as $filename) {
    if(file_exists($imagepath . $filename)) {
        copy($imagepath . $filename, $addir . '/' . $filename);
    }
    else {
        copy($imagesdirpath . 'default/' . $filename, $addir . '/' . $filename);
    }
}
#Create ad manifest
$admanifest = '{"encoding":"ad-units-package-3.0","ad-units":[{"assets":[{"filename":"screensvr.png","creative-id":"4990767082435","checksum":"' . md5_file($addir . '/screensvr.png') . '"},{"filename":"details.html","creative-id":"7097082962289","checksum":"' . md5_file($addir . '/details.html') . '"},{"filename":"banner.gif","creative-id":"8908001221594","checksum":"' . md5_file($addir . '/banner.gif') . '"},{"filename":"thumb.gif","creative-id":"3674714958127","checksum":"' . md5_file($addir . '/thumb.gif') . '"},{"filename":"snippet.json","creative-id":"3674714958127","checksum":"' . md5_file($addir . '/snippet.json') . '"}],"ad-type":"AD","start":"' . date('r') . '","priority":100,"remove-after":"' . date('r',strtotime('+365 day')) . '","ad-id":"' . $adid . '","end":"' . date('r',strtotime('+365 day')) . '","version":20111019203526}]}';
$admanifest = str_replace('-0400','GMT',$admanifest);
$admanifestfile = fopen($tempdir . 'ad-manifest.json', 'w');
fwrite($admanifestfile, $admanifest);
fclose($admanifestfile);
chdir($tempdir);
shell_exec("zip advert$adid.apg -r $adid ad-manifest.json");
shell_exec("rm -r $adid ad-manifest.json");

#Send the final file
    $adfile = "advert$adid.apg";
    header('x-amz-id-2: btOnjDPjc6CFjsCDc3EwERObf8iwIbFF7gSNijBcx4uYcvtQ+gPOFuKeTXmxXPld');
    header('x-amz-request-id: 23B54F17F3191750');
    header('Date: ' . date('r'));
    header('Last-Modified: ' . date('r'));
    header('ETag: ' . md5_file($adfile));
    header('Accept-Ranges: bytes');
    header('Content-Type: application/x-apg-zip');
    header('Content-Length: ' . filesize($adfile));
    header('Server: AmazonS3');
    ob_clean();
    flush();
    readfile($adfile);
    shell_exec("rm $adfile");
    exit;
?>
