<form action="mgr/file/remove" method="post" class="modxminify-form">

	<h2>[[+modxminify.global.remove]] [[+modxminify.file]]</h2>

	<input type="hidden" name="id" value="[[+id]]" />

	<div class="form-group">
		<p>[[+modxminify.global.remove_confirm]] [[+modxminify.file:strtolower]]?</p>
		<p class="help-block"><i>[[+filename]]</i></p>
	</div>
	
	<button type="submit" class="danger">[[+modxminify.global.remove]]</button>
	<button type="button" data-form-cancel>[[+modxminify.global.cancel]]</button>

</form>