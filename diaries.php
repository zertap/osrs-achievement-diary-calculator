<pre>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//---------------------------------------//


$hiscoreURL = 'http://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player=';

$diary = array();
$diary['all'] = json_decode(file_get_contents('res/diary_all.json'), true);
// $diary['karamja'] = json_decode(file_get_contents('res/diary_karamja.json'));
// $diary['ardougne'] = json_decode(file_get_contents('res/diary_ardougne.json'));
// $diary['falador'] = json_decode(file_get_contents('res/diary_falador.json'));
// $diary['fremennik'] = json_decode(file_get_contents('res/diary_fremennik.json'));
// $diary['kandarin'] = json_decode(file_get_contents('res/diary_kandarin.json'));
// $diary['desert'] = json_decode(file_get_contents('res/diary_desert.json'));
// $diary['lumbridge-and-draynor'] = json_decode(file_get_contents('res/diary_lumbridge-and-draynor.json'));
// $diary['morytania'] = json_decode(file_get_contents('res/diary_morytania.json'));
// $diary['varrock'] = json_decode(file_get_contents('res/diary_varrock.json'));
// $diary['wilderness'] = json_decode(file_get_contents('res/diary_wilderness.json'));
// $diary['western-provinces'] = json_decode(file_get_contents('res/diary_western-provinces.json'));

$player = $_GET['rsn'] or die('rsn not specified.');
$diff = $_GET['diff'] or die('diff not specified.');
$request_diary = $_GET['diary'];
if (!array_key_exists($request_diary, $diary)) { die("Requested diary does not exist.");}

$api_stats = file_get_contents($hiscoreURL.$player);
$api_stats = explode(PHP_EOL, $api_stats);


# TESTING
// print_r($api_stats);
// echo($hiscoreURL.$player);

#####

$stat_names = "overall,attack,defence,strength,hitpoints,ranged,prayer,magic,cooking,woodcutting,fletching,fishing,firemaking,crafting,smithing,mining,herblore,agility,thieving,slayer,farming,runecraft,hunter,construction";

$stats = array();
$i = 0;
foreach (explode(',', $stat_names) as $skill) {
	$stats[$skill]['lvl'] = explode(',', $api_stats[$i])[1]; // Get i from api_stats and separate the rank,level,xp pick level ( second item in the array, [1] )
	$stats[$skill]['xp'] = explode(',', $api_stats[$i])[2]; // Get i from api_stats and separate the rank,level,xp, pick xp ( third item in the array, [2] )
	$i++;
}
foreach ($diary[$request_diary]['diary']['diff'][$diff]['skills'] as $skill => $lvl) {
	$lvls_left = ($lvl - $stats[$skill]['lvl']);
	if ($lvls_left > 0) {
		echo "You need $lvls_left more $skill level(s).<br>";
	} else {
		//echo "$skill done";
	}
}

?>
</pre>
