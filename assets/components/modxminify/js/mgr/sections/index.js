$(document).ready(function() {

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
	}

	function getGroupsFiles() {

	}

	if(mm_connector_url && http_modauth) {
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
});