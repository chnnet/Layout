<?php
//		session_start();
		
	// ***** Session infos auslesen *****
		$host = $_SESSION['host'];
        $benutzer = $_SESSION['benutzer'];
        $passwort = $_SESSION['passwort'];
        $dbname = $_SESSION['dbname'];
        $keynr = $_SESSION['keynr'];


	// gewähltes Menü? wenn Paramter leer dann parent_id = 0
	// Fehler !!!
	if (isset($_GET['menu']))
	{
		$menu = $_GET['menu'];
		if ($menu)
		{
			if ( $menu == "standard" )
			{
				//$benutzer_id = "99999";
				$keynr = "99999";
			}
		}
	}
if (isset($_GET['parent_id']))
{
	$parent_id = $_GET['parent_id'];
}
else
{
	$parent_id = 0;
}

// DB-Connection
try {
	$con = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $benutzer, $passwort);

} catch (PDOException $ex) {
	die('Die Datenbank ist momentan nicht erreichbar!');
}

//Query
$result = $con->prepare("SELECT m.name,m.pfad_file,m.target,m.pfad_icon FROM menu m, benutzer_menu b WHERE m.menu_id=b.menu_id and b.benutzer_id = $keynr and b.parent_id =  $parent_id order by b.menu_order");
$result->execute(array($keynr, $parent_id));

// Home
echo "<li><a class=\"active\" href=\"http://localhost/layouttest/index.html\">Home</a></li>";

while ($row = $result->fetch()) {

		$icon = $row['pfad_icon'];
		$name = $row['name'];
		$pfadf = $row['pfad_file'];
		$target = $row['target'];

		echo "<li><a href=\"http://localhost/layouttest/" . $pfadf . "\" target=\"main\">" . $name . "</a></li>";
// 		echo "<li><a href=\"#\" onclick=\"loadDoc(" . $pfadf . ");return false;\">" . $name . "</a></li>";
		
}

//logout
echo "<li class=\"right\"><a href=\"http://localhost/layouttest/logout.php\">Logout</a></td>";
?>
