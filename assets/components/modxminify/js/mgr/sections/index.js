$(document).ready(function() {

	var modalElement = $('#modxminify-modal');
	var modalContent = modalElement.find('.modal-content p');

	var defaultParams = {
		HTTP_MODAUTH: http_modauth
	}

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

	function addGroup(name,description) {

	}

	function addFile(filename,groupId) {
		var formParams = {
			action       : 'mgr/file/createmultiple',
            group 		 : groupId
		};
		var params = $.extend({},formParams,defaultParams);
		ajaxConnector(mm_connector_url,params,function(response) {
			closeModal();
			if(response.success == true) {
				getGroupsFiles();
			}
		});
	}

	function reOrderFiles(order) {
		var formParams = {
			action       : 'mgr/file/reorderfiles',
            order: order
		};
		var params = $.extend({},formParams,defaultParams);
        ajaxConnector(mm_connector_url,params,function(response) {
			if(response.success == true) {
				getGroupsFiles();
			}
		});
	}

	function initDragDrop() {
		$('ul.files').each(function(i,element){
			Sortable.create(element, {
				animation: 100,
				filter: '.file-actions',
			    store: {
			    	get: function (sortable) {
			            var order = localStorage.getItem(sortable.options.group);
			            return order ? order.split('|') : [];
			        },
			    	set: function (sortable) {
			            var order = sortable.toArray();
			            // process the new order of files
			            reOrderFiles(order);
			        }
			    }
			});
		})
	}

	function setContentHeight() {
		height = $(document).height() - $('#modx-header').height();
		$('#modx-content').height(height);
	}

	function openModal() {
		modalElement.show();
	}

	function closeModal() {
		// first empty the contents of the modal window
		modalContent.html('');
		modalElement.hide();
	}

	function loadModalContent(chunk = false, data = {}) {
		if(chunk) {
			var params = {
				action       : 'mgr/modal/loadcontent',
	            HTTP_MODAUTH : http_modauth,
	            chunk 		 : chunk,
	            data 		 : data
			};
	        ajaxConnector(mm_connector_url,params,function(response) {
				if(response.success == true && response.html) {
					modalContent.html(response.html);
					openModal();
				}
			});
		} else {
			modalContent.html('');
		}
	}

	$(window).resize(function() {
		setContentHeight();
	});

	$(document).on('click','button[data-add-group]',function(){
		loadModalContent('form_addgroup');
	});

	$(document).on('click','button[data-add-file]',function(){
		loadModalContent('form_addfile');
	});

	$(document).on('click','a[data-update]',function(){
		openModal();
	});

	$(document).on('click','a[data-remove]',function(){
		loadModalContent('form_removefile',{ id: $(this).attr('data-remove') });
	});

	$(document).on('click','.modal .close',function(){
		closeModal();
	});

	// Handle the form submits
	// Prevents the default form submit, and processes it with the processor defined in form action
	$(document).on('submit','.modxminify-form',function(e){
		e.preventDefault();
		// add action parameter from form into ajax parameters
		var formParams = { action: $(this).attr('action')};
		$(this).serializeArray().map(function(x){formParams[x.name] = x.value;});
		// merge form parameters with default params
		var params = $.extend({},formParams,defaultParams);
		ajaxConnector(mm_connector_url,params,function(response) {
			if(response.success == true) {
				closeModal();
				getGroupsFiles();
			} else {
				// get the form field(s) with error, show error(s) in form
			}
		});

	});

	$(document).on('click','button[data-form-cancel]',function(){
		closeModal();
	});

	window.onclick = function(event) {
	    if (event.target == modalElement[0]) {
	        closeModal();
	    }
	}

	// Initialize on page load
	initialize();

});