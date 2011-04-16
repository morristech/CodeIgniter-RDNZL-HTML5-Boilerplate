
<h1>Welcome to the Home Page</h1>

<p>This project is by <a href="http://wesbroadway.com">Wes Broadway</a>. The goal of this project is to be a base <a href="http://codeigniter.com/">Codeigniter</a> install, with the following features:</p>
<ul>
	<li>Base HTML is the awesome <a href="http://html5boilerplate.com">HTML5 Boilerplate</a>, including the &quot;good&quot; Javascript:
<ul>
      <li><a href="http://www.modernizr.com/">Modernizer</a></li>
      <li><a href="http://jquery.com">jQuery</a></li>
      <li><a href="http://jqueryui.com/">jQuery UI</a> (included theme: Pepper. You can add your own)</li>
      </ul>
    </li>
	<li>An demo AJAX Controller/View/Usage scenario to get people started on that path.</li>
	<li>Access control by <a href="http://www.konyukhov.com/soft/tank_auth/">Tank Auth</a> for access control (to a non-existent backend currently, sorry)</li>
	<li>CodeIgniter's <a href="http://codeigniter.com/user_guide/libraries/parser.html">Template Parser</a></li>
</ul>
<p>Future goals include enhancing the access control feature, and some sort of snap-in-able Admin area. Also, a blog Model built-in, so you don't have to download/type the tutorials.</p>

<h1>AJAX Demonstration</h1>

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