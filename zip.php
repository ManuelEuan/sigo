<?php
	$base_url="http://localhost/Sigov2/";
$zip = new ZipArchive;
$nomenclatura="archivos/documentosZip/".md5(time()).".zip";
if ($zip->open($nomenclatura, ZipArchive::CREATE) === TRUE)
{
    // Add files to the zip file
    //$zip->addFile('test.txt');
    //$zip->addFile('test.pdf');
 
    // Add random.txt file to zip and rename it to newfile.txt
    //$zip->addFile('random.txt', 'newfile.txt');
 
    // Add a file new.txt file to zip using the text specified
    $zip->addFromString('new.txt', 'text to be added to the new.txt file');
 
    // All files are added, so close the zip file.
    $zip->close();
}
echo $base_url.$nomenclatura;
?>