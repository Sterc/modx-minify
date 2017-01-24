<li data-id="[[+id]]">
	<div class="name">
		<b>[[+name]]</b> <small>(#[[+id]])</small>
		<span class="block-actions">
			<a class="small" data-update-group="[[+id]]" href="javascript:void(0)" title="[[+modxminify.global.edit]] [[+modxminify.group:strtolower]] [[+name]]">
				<i class="icon icon-pencil" aria-hidden="true"></i> 
				[[+modxminify.global.edit]] [[+modxminify.group:strtolower]]
			</a>
			<a class="small remove" data-remove-group="[[+id]]" href="javascript:void(0)" title="[[+modxminify.global.remove]] [[+modxminify.group:strtolower]] [[+name]]">
				<i class="icon icon-times" aria-hidden="true"></i> 
				[[+modxminify.global.remove]] [[+modxminify.group:strtolower]]
			</a>
		</span>
	</div>
	[[+inner]]
</li>