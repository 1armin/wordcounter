<?php
// Include utility files
require_once 'config.php';

ini_set('max_execution_time', 0);
$txt = " _ ";
$filename = "wordsfile.txt";
$similarwordscount = 0;
$allwordscount = 0;
$f100w = 0;
$f200w = 0;
$f300w = 0;
$f500w = 0;
$f1000w = 0;
$f100wp = 0;
$f200wp = 0;
$f300wp = 0;
$f500wp = 0;
$f1000wp = 0;


function writetotxt($filename,$txt)
{
	$txtfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($txtfile, $txt);
	fclose($txtfile);
}



try
{
	$obj_connect= new PDO(DSN,DBUSER,DBPASS);

	$words = $obj_connect->query("select * from wordscount ORDER BY count DESC")->fetchAll(PDO::FETCH_ASSOC);

	foreach ($words as $key => $value) {
		$txt = $txt.$key." : ".$value["word"]."=>".$value["count"]."\n _ ";
		$similarwordscount ++;
		$allwordscount += $value["count"];

		if ($similarwordscount <= 100) {
			$f100w += $value["count"];
		}
		if ($similarwordscount <= 200) {
			$f200w += $value["count"];
		}
		if ($similarwordscount <= 300) {
			$f300w += $value["count"];
		}
		if ($similarwordscount <= 500) {
			$f500w += $value["count"];
		}
		if ($similarwordscount <= 1000) {
			$f1000w += $value["count"];
		}
	}

writetotxt($filename,$txt);
if ($allwordscount != 0) {

$f100wp  = ($f100w  / $allwordscount) * 100;
$f200wp  = ($f200w  / $allwordscount) * 100;
$f300wp  = ($f300w  / $allwordscount) * 100;
$f500wp  = ($f500w  / $allwordscount) * 100;
$f1000wp = ($f1000w / $allwordscount) * 100;
}


print("all words count = ".$allwordscount."<br>similar words count = ".$similarwordscount);

print("<br>first 100 words count  = ".$f100w." that is %".$f100wp." of the all words.");
print("<br>first 200 words count  = ".$f200w." that is %".$f200wp." of the all words.");
print("<br>first 300 words count  = ".$f300w." that is %".$f300wp." of the all words.");
print("<br>first 500 words count  = ".$f500w." that is %".$f500wp." of the all words.");
print("<br>first 1000 words count = ".$f1000w." that is %".$f1000wp." of the all words.");

print("<br><a href='".SITE_URL."/".$filename."'>view words file</a>");
print("<br><a href='".SITE_URL."'>Back To Home</a>");

}
catch( Exception $e )
{
	//catch any exceptions and report the problem
    print $e->getMessage();
}
exit();