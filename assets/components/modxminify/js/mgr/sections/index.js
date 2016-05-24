$(document).ready(function() {

	function getAjaxResults(url,params,element) {
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: url,
			data: params,
			success: function(response) {
				if($(element).length && response.success == true) {
					parseResponse(response.results,element);
				} else {
					// element does not exist or success is false
					console.log(response);
				}
			}
		});
	}

	function parseResponse(data,element) {
		var output = '';
		$.each(data, function(key,values) {
			output += values.filename;
		});
		$(element).html(output);
	}

	if(mm_connector_url && http_modauth) {
		var params = {
			action       : 'mgr/file/getlist',
            HTTP_MODAUTH : http_modauth
		};
		getAjaxResults(mm_connector_url,params,'.groups-files');
	}
});