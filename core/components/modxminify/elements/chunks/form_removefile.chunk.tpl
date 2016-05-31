<form action="mgr/file/remove" method="post" class="modxminify-form">

	<input type="hidden" name="id" value="[[+id]]" />
	<div class="form-group">
		<p>[[+modxminify.global.remove_confirm]] [[+modxminify.file:strtolower]]?</p>
	</div>

	<div class="form-group">
		<p><i>[[+filename]]</i></p>
	</div>
	
	<div class="form-group">
		<button type="submit" class="danger">Yes</button>
		<button type="button" data-form-cancel>No</button>
	</div>
</form>