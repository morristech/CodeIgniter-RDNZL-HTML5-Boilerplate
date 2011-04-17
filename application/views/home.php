
<?php echo $page_copy; ?>

<hr/>

<h1>AJAX Demo</h1>

<div id="update">
	<p>This should populate with AJAX content 1.5s after page the onload event occurs.</p>
    <p>See the <pre>application/controllers/ajax</pre> folder, and the <pre>application/views/ajax</pre> folder for reverse-engineering fun.</p>
</div>

<script>
	// the self-executing, recursive, AJAX_Friendly closure pattern. 
	// oughta look up who's responsible for this awesomeness. i think Paul Irish
	// had something to do with planting this seed.
	(function updater(window, document, undefined){
		setTimeout(function(){
				$('#update').load('/ajax/update', function(){ updater() });
			}, 1500);
	})();
</script>