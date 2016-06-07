<li data-id="[[+id]]">
	<div class="name">
		<b>[[+name]]</b>
		<span class="block-actions">
			<a class="small" data-update-group="[[+id]]" href="javascript:void(0)" title="[[+modxminify.global.edit]] [[+modxminify.group:strtolower]] [[+name]]">
				<i class="fa fa-pencil" aria-hidden="true"></i> 
				[[+modxminify.global.edit]] [[+modxminify.group:strtolower]]
			</a>
			<a class="small remove" data-remove-group="[[+id]]" href="javascript:void(0)" title="[[+modxminify.global.remove]] [[+modxminify.group:strtolower]] [[+name]]">
				<i class="fa fa-times" aria-hidden="true"></i> 
				[[+modxminify.global.remove]] [[+modxminify.group:strtolower]]
			</a>
		</span>
	</div>
	[[+inner]]
</li>