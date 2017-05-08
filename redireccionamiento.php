<html>
	<head>
		<title>SDV - SDHT</title>
	</head>
	<script type="text/javascript">
		function irA(){
			setTimeout( "location.href = 'https://<?php echo $_SERVER['HTTP_HOST']; ?>/sdv/index.php' " , 3000 );
		} 
	</script>
	<body onLoad="javascript: irA();">
		<?php
			$txtUrl = "https://";
			echo "<h1>ATENCION:</h1>";
			echo "<h3>SERA REDIRECCIONADO AL SITIO SEGURO</h3>";
			echo "Si no es redireccionado en 3 segundos haga click <a href='https://" . $_SERVER['HTTP_HOST'] . "/sipive/index.php'>Aqui</a>";
		?>
	</body>
</html>