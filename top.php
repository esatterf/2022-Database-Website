<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Team Manager</title>
	<meta name="author" content="Evan Satterfield">
	<meta name="description" content="SEE: https://moz.com/learn/seo/meta-description">
	<meta name="viewport" content="width=device-width, intial-scale=1.0">
	<link rel="stylesheet" type="text/css"
		  href="css/custom.css?version=<?php print time(); ?>">
	<link rel="stylesheet" type="text/css" media="(max-width: 800px)"
		  href="css/custom-tablet.css?version=<?php print time(); ?>">
	<link rel="stylesheet" type="text/css" media="(max-width: 600px)"
		  href="css/custom-phone.css?version=<?php print time(); ?>">
	<?php include 'lib/constants.php'; ?>
	<?php include 'lib/database.php'; ?>
</head>
<?php
print '<body class="' . PHP_SELF;
print '">' . PHP_EOL;
print '<!-- ################	Body element	################ --!>' . PHP_EOL;


print '<!-- Find Manager -->';

$netID = isset($_SERVER["REMOTE_USER"]) ? htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8") : '';

$managers = array('esatterf', 'rerickso', 'jcmcgowa', 'tallembe', 'idavis1');
 
$managerLoggedIn = in_array($netID, $managers) ? true : false;


//print 'ID: ' . $netID . PHP_EOL;

include 'connect-DB.php';
print PHP_EOL;
include 'header.php';
print PHP_EOL;
include 'nav.php';
print PHP_EOL;
include 'connect-DB.php';
print PHP_EOL;
?>
