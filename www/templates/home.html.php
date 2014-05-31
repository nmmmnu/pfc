<? $this->extend("layout.html.php") ?>

<h1>Hello World</h1>

<p>Click here to begin:<br />
<a href="<?=$_url("/show") ?>">show records</a></p>

<p>Click here to see complex response:<br />
<a href="<?=$_url("/complex") ?>">click here</a></p>

<p>UTF8 text here:<br />
<?=$utf8_test ?></p>
