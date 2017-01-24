<form method="post" class="modxminify-form" action="mgr/group/remove">

	<h2>[[+modxminify.global.remove]] [[+modxminify.group]]</h2>

	<input type="hidden" name="id" value="[[+id]]" />

	<div class="form-group">
		<p>
			[[+modxminify.global.remove_confirm]] [[+modxminify.group:strtolower]]?
			<br>
			<b>[[+name]]</b>
		</p>
	</div>
	
	<button type="submit" class="danger">[[+modxminify.global.remove]]</button>
	<button type="button" data-form-cancel>[[+modxminify.global.cancel]]</button>

</form>