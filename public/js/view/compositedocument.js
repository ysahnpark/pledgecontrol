
/**
 * View for document with multiple children documents
 * Each of the child document is rendered in a Tab
 *
 * @param {string} docViewSelector  The selector wthin the tab that defines the view of a doucment
 *  
 */
var CompositeDocumentView = function(masterModel, masterDocType, tabId, docViewSelector, opt_readonly)
{
	this.docViewSelector = docViewSelector;
	this.readonly = (opt_readonly) ? opt_readonly : false;
	this.model = masterModel;
	this.documentType = masterDocType;
	this.tabId = tabId;

	this.tabs = [];

	// Initialize this.tabs
	this.tabs.push({ model : this.model, document_type: this.documentType});

	// Create tabs model
	var $documentTabs = $("#" + this.tabId);

	var i=0;
	if (this.documentType.children && this.documentType.children.length > 0) {
		for(i=0; i < this.documentType.children.length; i++ ) {
			var childDocumentType = this.documentType.children[i];

			this.tabs.push( { model: null, document_type: childDocumentType});
		}
	} else {
		$documentTabs.hide();
	}
	// } Create tabs model

}

// Should be called at Angular's on document ready 
CompositeDocumentView.prototype.init = function() {
        // Initilize Bootstrap tab 
		$('#' + this.tabId + ' a').click(function (e) {
		    console.log("Tab clicked");
		    e.preventDefault();
		    $(this).tab('show');
		});
		// Select the tab and activate the div
		$('#' + this.tabId + ' a:first').tab('show'); 
		$('.tab-pane:first').addClass('active'); 

		// Bind master's model
		this.tabs[0].view = this._bindContentView(this.documentType, this.model);
};

CompositeDocumentView.prototype.activateTab = function(type_sid)
{
	var tab = this._getTabByDocTypePK(type_sid);

	if (!tab.model) {
		// Retrieve from server and initialize the contentView

		var childModelPk = this._getChildDocumentPk(type_sid);

		var returnUrl = '/document_types/' + this.documentType.sid + '/documents/' + this.model.sid + '/edit';
		
		if (childModelPk === null) {
			// this model has not been inserted yet.
			var newChildModel = {
				masterdoc_type_sid: this.documentType.sid, 
				masterdoc_sid: this.model.sid, 
				content: null
			};

			tab.view = this._bindContentView(tab.document_type, newChildModel);
			// The $scopeEl is a $(form).
			// Change the action, and the _method, which should be POST instead of PUT
			tab.view.$scopeEl.attr('action', '/document_types/' + type_sid + '/documents');
			tab.view.$scopeEl.prepend('<input type="hidden" name="_return_url" value="' + returnUrl + '" />');
			tab.view.$scopeEl.find('input[name="_method"]').val("POST");
			return;
		}

		var childDocUrl = '/api/document_types/' + type_sid + '/documents/' + childModelPk;

		var this_ = this;
		$.ajax({
			type: "GET",
			url: childDocUrl,
			dataType: 'json'
		}).done(function(data, textStatus, jqXHR) {
			// model was found, it is an edit
			tab.model = data;
			tab.view = this_._bindContentView(tab.document_type, tab.model);
			tab.view.$scopeEl.attr('action', '/document_types/' + tab.document_type.sid + '/documents/' + tab.model.sid);
			tab.view.$scopeEl.prepend('<input type="hidden" name="_return_url" value="' + returnUrl + '" />');
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert ("Error retrieving child document");
		});
	}

}


/**
 * Binds model data to the view. 
 * In this case a view is tied to a tab 
 */
CompositeDocumentView.prototype._bindContentView = function(documentType, model)
{
	//var content = (model) ? model.content : null;

	var $currTab = $('#tab_' + documentType.id )
	var $currContentEl = $currTab.find('#doc_content');
	var $form = $currTab.find( this.docViewSelector );

	var docView = new GenericModelView($form);

	var _this = this;
	docView.addCustomPropertyBinder('tags',
		function($scopeEl, model, value) {
			var $widget = $scopeEl.find("#tags");
			if (_this.readonly) {
				$widget.val(value);
			} else {
				// Render the tags using tagsinput plugin
				$widget.tagsinput('add', value);
			}
		});
	docView.addCustomPropertyBinder('content',
		function($scopeEl, model, value) {
			// Render the main content {
			var contentView = new DynamicContentView(JSON.parse(documentType.schema), documentType.form_template);
			$currContentEl.html(contentView.generate(value, _this.readonly));

			if (!_this.readonly) {
				contentView.initEditableForm($form);

				// Enable validation
				$form.parsley({
		            successClass: 'success',
		            errorClass: 'error',
		            errors: {
		                classHandler: function(el) {
		                    return $(el).closest('.control-group');
		                },
		                errorsWrapper: '<span class=\"help-inline\"></span>',
		                errorElem: '<span></span>'
		            }
		        });
			}
			// } Render content
		});
	docView.bindModel(model);

	return docView;
}

CompositeDocumentView.prototype._getChildDocumentPk = function(documentTypeSid)
{
	/*
	 * children_refs: [
	 * 		{type_pk:doctype1, document_pk:doc1}, ...
	 *	]
	*/
	if (this.model.hasOwnProperty('children_refs') &&
		this.model.children_refs)
	{
		for (var i=0; i < this.model.children_refs.length; i++)
		{
			var childrenEntry = this.model.children_refs[i];
			if (childrenEntry.type_pk === documentTypeSid)
			{
				return childrenEntry.document_pk;
			}
		}
	}
	return null;
}

CompositeDocumentView.prototype._getTabByDocTypePK = function(documentTypeSid)
{
	for(i=0; i < this.tabs.length; i++ ) {
		var aTab = this.tabs[i];
		if (aTab.document_type.sid === documentTypeSid) {
			return this.tabs[i];
		}
	}
}