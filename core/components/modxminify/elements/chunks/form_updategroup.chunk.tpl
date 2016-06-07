<form method="post" class="modxminify-form" action="mgr/group/update">

	<h2>[[+modxminify.global.edit]] [[+modxminify.group]]</h2>

	<input type="hidden" name="id" value="[[+id]]" />

	<div class="form-group">
		<label for="name">[[+modxminify.group.name]]</label>
		<input type="text" name="name" id="name" class="form-control" value="[[+name]]" />
	</div>
	
	<div class="form-group">
		<label for="description">[[+modxminify.group.description]]</label>
		<textarea name="description" id="description" rows="4" class="form-control">[[+description]]</textarea>
	</div>

	<button type="submit">[[+modxminify.global.save]]</button>

</form>