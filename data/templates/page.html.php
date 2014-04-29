<? $this->extend("layout.html.php") ?>

<p>Hello <?=$name ?>!</p>

<p>You are from <?=$city ?>.</p>

<p>Here come the loop:<br />
<?=$this->render("loop.html.php") ?>
</p>
