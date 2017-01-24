<form method="post" class="modxminify-form" action="mgr/file/createmultiple">
	
	<h2>[[+modxminify.global.add]] [[+modxminify.file]]</h2>

	<div class="form-group">
		<label for="group">[[+modxminify.group]]</label>
		<select class="form-control" name="group" id="group">
			[[+groups]]
		</select>
	</div>


	<div class="form-group">
		<label for="filename">[[+modxminify.file.name]]</label>
		<textarea name="filename" id="filename" rows="7" class="form-control" />
		<p class="help-block">[[+modxminify.file.name.description]]</p>
	</div>

	<button type="submit">[[+modxminify.global.save]]</button>

</form>