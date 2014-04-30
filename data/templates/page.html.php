<? $this->extend("layout.html.php") ?>

<p>Hello <?=$name ?>!</p>

<p>You are from <?=$city ?>.</p>

<?
global $bla;
$bla = 0;
?>

<p>Here come the loop:<br />
<?=$this->render("loop.html.php") ?>
</p>
