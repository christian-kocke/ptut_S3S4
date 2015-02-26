<?php
include_once "../core/init.php";
$user = new user();
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
$result = $db->get("reservation");
?>

<html>
<head>
	<title>Chef de salles</title>
</head>
<body>
	<div>
		<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
    </tbody>
</table>
	</div>
</body>
</html>

<?php include_once 'footer.php'; ?>