<?php
	if (!empty($errors)) {
?>
		<div id="errors" class="error">
<?php
		foreach($errors as $error) {
			echo $error;
		}
?>
		</div>
<?php
	}
?>