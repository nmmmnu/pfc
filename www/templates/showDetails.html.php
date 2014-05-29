<? $this->extend("layout.html.php") ?>

<? if ($row) : ?>

<table border="1">
	<tr><td>ID:	</td><td><?=$row["id"]		?></td></tr>
	<tr><td>Name:	</td><td><?=$row["name"]	?></td></tr>
	<tr><td>Age:	</td><td><?=$row["age"]		?></td></tr>
</table>

<? else : ?>
<p>No data found...</p>
<? endif ?>

<hr />

<p><a href="/show">go back</a></p>
