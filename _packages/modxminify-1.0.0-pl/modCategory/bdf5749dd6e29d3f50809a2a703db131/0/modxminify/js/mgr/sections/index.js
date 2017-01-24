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

    function ajaxConnector(url,formParams,callback)
    {
        var params = $.extend({},formParams,defaultParams);
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

    function renderOutput(element,output)
    {
        $(element).html(output);
        initDragDrop();
        setContentHeight();
    }

    function getGroupsFiles()
    {
        var params = {
            action       : 'mgr/group/getgroupsfiles'
        };
        ajaxConnector(mm_connector_url,params,function(response) {
            var element = '.groups-files';
            if($(element).length && response.success == true && response.html) {
                renderOutput(element,response.html);
            }
        });
    }

    function reOrderFiles(order)
    {
        var params = {
            action 	: 'mgr/file/reorderfiles',
            order 	: order
        };
        ajaxConnector(mm_connector_url,params,function(response) {
            if(response.success == true) {
                getGroupsFiles();
            }
        });
    }

    function initDragDrop()
    {
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

    function setContentHeight()
    {
        height = $(document).height() - $('#modx-header').height();
        $('#modx-content').height(height);
    }

    function openModal()
    {
        modalElement.show();
    }

    function closeModal()
    {
        // first empty the contents of the modal window
        modalContent.html('');
        modalElement.hide();
    }

    function loadModalContent(chunk = false, data = {}, includeObject = false)
    {
        if (chunk) {
            var params = {
                action       	: 'mgr/modal/loadcontent',
                chunk 		 	: chunk,
                data 		 	: data,
                includeObject	: includeObject
            };
            ajaxConnector(mm_connector_url,params,function(response)
            {
                if(response.success == true && response.html) {
                    modalContent.html(response.html);
                    openModal();
                }
            });
        } else {
            modalContent.html('');
        }
    }

    function getGroups(selected = false,callback)
    {
        var params = {
            action       : 'mgr/group/getlist'
        };
        ajaxConnector(mm_connector_url,params,function(response)
        {
            if (response.success == true && response.results) {
                response.output = '';
                $.each(response.results,function(index,value)
                {
                    var selectedElem = '';
                    if(selected && selected == value.id) {
                        selectedElem = 'selected';
                    }
                    response.output += '<option value="'+value.id+'" '+selectedElem+'>'+value.name+'</option>';
                });
                if (typeof callback == "function") {
                    callback(response);
                }
            }
        });
    }

    $(window).resize(function() {
        setContentHeight();
    });

    $(document).on('click','[data-add-group]',function() {
        loadModalContent('form_addgroup');
    });

    $(document).on('click','[data-update-group]',function() {
        loadModalContent('form_updategroup', { id: $(this).attr('data-update-group') }, 'modxMinifyGroup');
    });

    $(document).on('click','[data-remove-group]',function() {
        loadModalContent('form_removegroup', { id: $(this).attr('data-remove-group') }, 'modxMinifyGroup');
    });

    $(document).on('click','[data-add-file]',function() {
        getGroups(false,function(response) {
            loadModalContent('form_addfile', { groups: response.output});
        });
    });

    $(document).on('click','[data-update-file]',function() {
        var self = $(this);
        var parentGroup = self.parents('ul.files').parent().attr('data-id');
        getGroups(parentGroup,function(response) {
            loadModalContent('form_updatefile', { id: self.attr('data-update-file'), groups: response.output }, 'modxMinifyFile');
        });
    });

    $(document).on('click','[data-remove-file]',function() {
        loadModalContent('form_removefile', { id: $(this).attr('data-remove-file') }, 'modxMinifyFile');
    });

    $(document).on('click','.modal .close',function() {
        closeModal();
    });

    // Handle the form submits
    // Prevents the default form submit, and processes it with the processor defined in form action
    $(document).on('submit','.modxminify-form',function(e)
    {
        e.preventDefault();
        var form = $(this);
        // add action parameter from form into ajax parameters
        var formParams = { action: $(this).attr('action')};
        form.serializeArray().map(function(x){formParams[x.name] = x.value;});
        // merge form parameters with default params
        var params = $.extend({},formParams,defaultParams);

        ajaxConnector(mm_connector_url,params,function(response)
        {
            form.find('.field-error').remove();
            if (response.success == true) {
                closeModal();
                getGroupsFiles();
            } else {
                // get the form field(s) with error, show error(s) in form
                $.each(response.data,function(index,value)
                {
                    if (value.id)
                    {
                        if ($('[name="'+value.id+'"]').length > 0)
                        {
                            $('[name="'+value.id+'"]').parent().addClass('has-error').append('<p class="help-block field-error">'+value.msg+'</p>');
                        }
                    }
                });
            }
        });

    });

    $(document).on('click','[data-form-cancel]',function()
    {
        closeModal();
    });

    window.onclick = function(event)
    {
        if (event.target == modalElement[0]) {
            closeModal();
        }
    }

    // Initialize on page load
    initialize();

});