<form method="post" class="modxminify-form" action="mgr/file/update">
	
	<h2>[[+modxminify.global.edit]] [[+modxminify.file]]</h2>

	<input type="hidden" name="id" value="[[+id]]" />

	<div class="form-group">
		<label for="group">[[+modxminify.group]]</label>
		<select class="form-control" name="group" id="group">
			[[+groups]]
		</select>
	</div>


	<div class="form-group">
		<label for="filename">[[+modxminify.file.name]]</label>
		<input type="text" name="filename" id="filename" class="form-control" value="[[+filename]]" />
		<p class="help-block">[[+modxminify.file.name.description]]</p>
	</div>

	<button type="submit">[[+modxminify.global.save]]</button>

</form>