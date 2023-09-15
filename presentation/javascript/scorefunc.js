function scorefunc() {}

		$(document).ready(function() {
			scorefunc();
			loadstation();
		});

		function loadstation() {
			$("#scoretable").load("scoretable.php");
			setTimeout(loadstation, 500);
		}