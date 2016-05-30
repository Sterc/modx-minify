$(document).ready(function() {

	function initialize() {
		getGroupsFiles();
		setContentHeight();
	}

	function ajaxConnector(url,params,callback) {
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: url,
			data: params,
			success: function(response) {
				if (typeof callback == "function") callback(response);
			}
		});
	}

	function parseOutput(data,placeholders) {
		var output = '';
		$.each(data, function(key,values) {
			output += values.name;
		});
		return output;
	}

	function renderOutput(element,output) {
		$(element).html(output);
		initDragDrop();
		setContentHeight();
	}

	function getGroupsFiles() {
		var params = {
			action       : 'mgr/group/getgroupsfiles',
            HTTP_MODAUTH : http_modauth
		};
		ajaxConnector(mm_connector_url,params,function(response) {
			var element = '.groups-files';
			if($(element).length && response.success == true && response.html) {
				renderOutput(element,response.html);
			}
		});
	}

	function initDragDrop() {
		$('ul.files').each(function(i,element){
			Sortable.create(element, {
				// handle: '.handle',
				animation: 150,
				filter: '.buttons',
			    store: {
			    	get: function (sortable) {
			            var order = localStorage.getItem(sortable.options.group);
			            return order ? order.split('|') : [];
			        },
			    	set: function (sortable) {
			            var order = sortable.toArray();
			            // todo: run processor to reorder the file positions
			        }
			    }
			});
		})
	}

	function setContentHeight() {
		height = $(document).height() - $('#modx-header').height();
		$('#modx-content').height(height);
	}

	$(window).resize(function() {
		setContentHeight();
	});

	// Initialize on page load
	initialize();

});