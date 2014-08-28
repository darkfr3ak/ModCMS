<?php 
include 'application/bootstrap.php';

if(isset($_GET['userID'])){
    $userID = $_GET['userID'];
}else{
    $userID = 1;
}
$_SESSION['userID'] = 1;
$myACL = new ACL();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACL Test</title>
<link href="assets/css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header"></div>
<div id="adminButton"><a href="admin/">Admin Screen</a></div>
<div id="page">
	<h2>Permissions for <?php echo $myACL->getUsername($userID); ?>:</h2>
	<?php 
		$userACL = new ACL($userID);
		$aPerms = $userACL->getAllPerms('full');
		foreach ($aPerms as $k => $v)
		{
			echo "<strong>" . $v['Name'] . ": </strong>";
			echo "<img src='".$tmpl->getCurrentTemplatePath()."img/";
			if ($userACL->hasPermission($v['Key']) === true)
			{
				echo "allow.png";
				$pVal = "Allow";
			} else {
				echo "deny.png";
				$pVal = "Deny";
			}
			echo "' width=\"16\" height=\"16\" alt=\"$pVal\" /><br />";
		}
	?>
</div>
</body>
</html>