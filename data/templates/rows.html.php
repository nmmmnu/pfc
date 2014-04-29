<? $this->extend("layout.html.php") ?>

<table border="1">
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Age</th>
	</tr>
	<? foreach($rows as $r) : ?>

	<tr>
		<td><?=$r["id"] ?></td>
		<td><?=$r["name"] ?></td>
		<td><?=$r["age"] ?></td>
	</tr>
	<? endforeach ?>

</table>

