$(document).ready(function() {

	var modalElement = $('#modxminify-modal');

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

	}

	function removeFile(fileId) {
		var params = {
			action       : 'mgr/file/remove',
            HTTP_MODAUTH : http_modauth,
            id 			 : fileId
		};
		ajaxConnector(mm_connector_url,params,function(response) {
			if(response.success == true) {
				closeModal();
				getGroupsFiles();
			}
		});
	}

	function reOrderFiles(order) {
		var params = {
			action       : 'mgr/file/reorderfiles',
            HTTP_MODAUTH : http_modauth,
            order: order
		};
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
		modalElement.find('.modal-content p').html('');
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
					modalElement.find('.modal-content p').html(response.html);
					openModal();
				}
			});
		} else {
			modalElement.find('.modal-content p').html('');
		}
	}

	function handleForm() {

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

	$(document).on('submit','.modxminify-form',function(e){
		e.preventDefault();
		var fileId = $(this).find('input[name="id"]').val();
		if(fileId) {
			removeFile(fileId);
		}

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