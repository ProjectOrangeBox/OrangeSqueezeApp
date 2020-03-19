	<!-- js variables -->
	<script>
		<?= pear::html('js_variables') ?>
	</script>
	<script>
		<?= pear::html('script') ?>
		document.addEventListener("DOMContentLoaded", function(e) {
			<?= pear::html('domready') ?>
		});
	</script>
	<?= pear::html('js') ?>
	</body>

	</html>
