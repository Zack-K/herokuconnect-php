<?
$db = parse_url(getenv("DATABASE_URL"));
$db["path"] = ltrim($db["path"], "/");

$conn = pg_connect(getenv("DATABASE_URL"));

$db = parse_url(getenv("DATABASE_URL"));

$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

try{
	$sql = "SELECT id, name, phone  FROM salesforce.contact";
	$stmh = $pdo->prepare($sql);
	$stmh->execute();
}catch (PDOException $Exception){
	die('接続エラー: '.$Exception->getMessage());
}
?>

<table><tbody>
    <tr><th>ID</th><th>取引先責任者</th></tr>
<?php
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
?>
    <tr>
        <th><?=htmlspecialchars($row['id'])?></th>
        <th><?=htmlspecialchars($row['name'])?></th>
    </tr>
<?php
    }
    $pdo = null;
?>
</tbody></table>