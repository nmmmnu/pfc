<? $this->extend("layout.html.php") ?>

<table border="1">
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Age</th>
		<th></th>
	</tr>
<? foreach($rows as $row): ?>
	<tr>
		<td><?=$row["id"]	?></td>
		<td><?=$row["name"]	?></td>
		<td><?=$row["age"]	?></td>
		<td><a href="<?=$_url("/show/x", array("id" => $row["id"]) ) ?>">show record</a></td>
	</tr>
<? endforeach ?>

</table>

<p>Same data in <a href="<?=$_url("/json") ?>">JSON Format</a>.</p>

