<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  	<style type="text/css" media="screen">
  		table {
		  width: 50%;
		  border: 1px solid black;
		}

		th {
		  height: 50px;
		  text-align: left;
		}
		tr:hover {background-color: #f5f5f5;}
  	</style>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
