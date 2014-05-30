<? $this->extend("layout.html.php") ?>

<h1>Error!</h1>

<p>Try your request later :-)</p>

<? if ($application_errors) : ?>
<hr />
<pre style="border: solid 3px red; padding: 5px;"><?=$_vars["exception"] ?></pre>
<? endif ?>

