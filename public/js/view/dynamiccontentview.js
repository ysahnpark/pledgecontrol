
/**
 * DynamicContentView constructor
 */
var DynamicContentView = function(schema, template)
{
    this.schema = schema;
    this.template = template;

    /**
     * {
     *   "<collection_name>": {"schema":<schema-object>, "template": <template-function>}
     * }
     */
    this.collections = {};

    this.$form = null;
}

/**
 * Generates the content (either as editable form or read-only)
 *
 * @param {Object} model    The binding model
 * @param {bool}   readonly Wheter or not it is readonly. False will generate a input forms
 */
DynamicContentView.prototype.generate = function(model, readonly)
{
    if (readonly === undefined) {
        readonly = true;
    }
    var templateData = this.createTemplateData(model, readonly);
    var template = Handlebars.compile(this.template);
    var html = template(templateData);
    return html;
}

/**
 * Returns a data model that will be passed to the template
 * where the values are either HTML input tags or just data.
 *
 * @param {Object} model    The binding model
 * @param {bool}   readonly Wheter or not it is readonly. False will generate a input forms
 */
DynamicContentView.prototype.createTemplateData = function(model, readonly)
{
    var templateData = {};
    var fields = this.schema.fields;

    for(var i=0; i < fields.length; i++)
    {
        var field = fields[i];
        var fieldValue = (model) ? model[field.name]: null;

        // @TODO - extend to support multiple level of nested structure
        if (field.type === 'collection') {
            templateData[field.name] = this.createTemplateDataForCollection(field, fieldValue, readonly);
        } else {
            templateData[field.name] = this.genFieldWidget(readonly, field, fieldValue, readonly);
        }
        
    }
    return templateData;
}

/**
 * Creates form model's collection
 * called by createFormContentArr
 * @param {array} model the collection sub-model
 */
DynamicContentView.prototype.createTemplateDataForCollection = function(fieldSchema, collectionModel, readonly)
{
    var templateData = [];

    var parentName = fieldSchema.name;
    var fields = fieldSchema.fields;

    // For each index, create a tuple and add it to model
    var tuple = null;
    if (collectionModel) {
        for (var idx = 0; idx < collectionModel.length; idx++) {
            var collectionEntry = collectionModel[idx];
            tuple = this.createTemplateDataCollectionEntry(parentName, fields, collectionEntry, idx, readonly);

            templateData.push(tuple);
        }
    } else {
        // if collection model is empty, then just create one empty row
        tuple = this.createTemplateDataCollectionEntry(parentName, fields, null, 0, readonly);

        templateData.push(tuple);
    }

    return templateData;
}

/**
 * Creates form content's collection entry
 * called by createFormContentCollectionEntry
 *
 * @param string parentName  E.g. "items"
 * @param array  fields      The collection's schema
 * @param array  collectionEntry  The content row (which has actual values)  
 * @param int    idx         The current index of the collectionEntry
 */
DynamicContentView.prototype.createTemplateDataCollectionEntry = function(parentName, fields, collectionEntry, idx, readonly)
{
    var tuple = {};
    for(var i=0; i < fields.length; i++)
    {
        var field = fields[i];

        var fieldValue = null;  
        if (collectionEntry) {
            if (_.isArray(collectionEntry)) {
                fieldValue = (collectionEntry.length > i) ? collectionEntry[i] : '';
            } else {
                fieldValue = (collectionEntry) ? collectionEntry[field.name]: '';
            }
        }
        

        if (readonly) {
            tuple['_idx'] = idx + 1;
        } else {
            tuple['_idx'] = '<span class="text-warning glyphicon glyphicon-remove df-remove-tr"></span>';
        }
        
        tuple[field.name] = this.genFieldWidget(readonly, field, fieldValue, parentName, idx);
    }
    return tuple;
}

/**
 * Return the Html Widget based on 
 * @param field, 
 * @param fieldValue, 
 * @param readonly    
 * @param parentName  Name of the parent field (applicable only on collection)
 * @param idx         Index of the collection
 */
DynamicContentView.prototype.genFieldWidget = function(readonly, field, fieldValue, parentName, idx)
{
    if (parentName === undefined) {
        parentName = null;
    }
    if (idx === undefined) {
        idx = null;
    }

    var html = null;
    if (!readonly) {
        var fieldName = field.name;
        var fieldLen  = field.hasOwnProperty('length') ? field.length: null;

        var valueAttr = 'value="' + ((fieldValue) ? fieldValue : '') + '" ';
        var lenAttr = (fieldLen !== null) ? '' : 'maxlength="' + fieldLen + '" ';

        var dataAttr = '';
        if (parentName) {
            dataAttr = 'data-collection="' + parentName + '" data-collection-idx="' + idx + '"';
            fieldName = parentName + '(' + idx + ')/' + fieldName;
        }

        var validationAttribs = this.genValidationAttribs(field);

        html = '<input name="' + fieldName + '" ' + valueAttr + lenAttr + dataAttr + ' ' + validationAttribs + ' />';

    } else {
        html = fieldValue;
    } 

    return html;
}

/**
 * Generates Validation attributes
 * Validation attributes: http://parsleyjs.org/doc/index.html#psly-usage-form
 *
 * the field's validation follows the format from http://laravel.com/docs/validation
 * @param {form} $form  The form jQuery element
 */
DynamicContentView.prototype.genValidationAttribs = function(field)
{
    var validationCompiler = new ValidationCompiler();
    validationCompiler.initWithLaravelToParsley();
    
    return validationCompiler.compile(field.validation);
}


/**
 * Initializes the form with 
 * @param {form} $form  The form jQuery element
 */
DynamicContentView.prototype.initEditableForm = function($form)
{
    var _this = this;
    this.$form = $form;

    // Decorate collections
    var fields = this.schema.fields;

    for(var i=0; i < fields.length; i++)
    {
        var field = fields[i];
        // @TODO - extend to support multiple level of nested structure
        if (field.type === 'collection') {
            var templateText = this.getCollectionTemplate(field.name);
            var template = Handlebars.compile(templateText);

            this.collections[field.name] = {
                schema: field,
                template: template
            };
            this._decorateCollection(field.name, field.fields.length );

            (function(fieldName) {
                // Attach collection add button event handler
                var collectionNameUc = fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
                $form.on("click", "#button_add" + collectionNameUc + "Entry", function(event) {
                    _this.addCollectionEntry(fieldName, []);
                    event.preventDefault();
                    return false;
                });

                // bind to provide with 'this' context, and partial to provide the first argument.
                var itemAddCollection = _.partial(_this.addCollectionEntry, fieldName);
                var itemAddCollectionBound = _.bind(itemAddCollection, _this);
                
                // Attach collection import button event handler
                $form.on("click", "#button_import" + collectionNameUc, function(event) {
                    // The second parameter is defined in the _decorateCollection
                    _this.importCollection(fieldName, "file_import" + collectionNameUc, itemAddCollectionBound);
                    event.preventDefault();
                    return false;
                });
            })(field.name);
        }
    }



    /**
     * Attaches an event handler to the element with .df-remove-tr
     * This element must be a immediate child element of <td>
     */
    $form.on("click", ".df-remove-tr", function() {
        $(this).parent().parent().remove();
        return false;
    });

    /**
     * Intercepts form submission.
     * Piggybacks the collection element's indices to the form as a
     * hidden input with name "<collection-name>-indices"
     */
    $form.submit(function( event ) {
        //alert( "Handler for .submit() called." );
        _this.piggybackCollectionIndices($(this));
    });
}

/**
 * Returns the collection template (string)
 *
 * @param  {string} collectionName  The collection name
 * @return {string} the portion of the main template that belongs to the collection
 */
DynamicContentView.prototype.getCollectionTemplate = function(collectionName) {
    var reStart = new RegExp('{{#\\s*' + collectionName + '+\\s*}}', 'g');
    var matchStart = reStart.exec(this.template);
    var reEnd = new RegExp('{{\\/\\s*' + collectionName + '+\\s*}}', 'g');
    var matchEnd = reEnd.exec(this.template);

    var collTemplate = null;
    if (matchStart && matchEnd) {
        collTemplate = this.template.substring(matchStart.index + matchStart[0].length, matchEnd.index).trim() ; 
    }
    
    return collTemplate;
}


/**
 * Imports a collection from uploaded CSV file
 *
 * @param collectionName - Eg. 'items'
 * @param fileInputId    - Eg. 'file_importItems'
 * @param addEntryFunc   - Function that adds the entries. 
 *                         Signature: fn(array)
 */
DynamicContentView.prototype.importCollection = function(collectionName, fileInputId, addEntryFunc) {
    // Check for the various File API support.
    if (window.File && window.FileReader && window.FileList && window.Blob) {
      // Great success! All the File APIs are supported.
    } else {
      alert('The File APIs are not fully supported in this browser.');
    }

    //var files = document.getElementById(fileInputId).files;
    var files =  this.$form.find('#'+fileInputId).get(0).files;
    if (!files.length) {
        alert('Please select a file!');
        return false;
    }
    var file = files[0];
    var start = 0;
    var stop = file.size - 1;

    var reader = new FileReader();

    // If we use onloadend, we need to check the readyState.
    reader.onloadend = function(evt) {
        if (evt.target.readyState == FileReader.DONE) { // DONE == 2
            var csvText = evt.target.result;
            var csv_arrs = $.csv.toArrays(csvText);

            for(var i=0; i < csv_arrs.length; i ++)
            {
                addEntryFunc(csv_arrs[i]);
            }
        }
    };

    var blob = file.slice(start, stop + 1);
    reader.readAsText(blob);
}

/**
 * Intercepts form submission.
 * Piggybacks the collection element's indices to the form as a
 * hidden input with name "<collection-name>-indices"
 *
 * @param $form to form which contains the content and is being submitted
 */
DynamicContentView.prototype.piggybackCollectionIndices = function($form)
{
    // select list of all elemeentis in this form which as 'data-collection' attribute
    var dataCollection = $form.find('[data-collection]');

    // Map<string, Array<number>>, where [key] = collection name, and
    //                                   [value] is an array of indexes
    var collectionIndicesMap = {};

    // Iteratee over data-collection and create a map of indices
    dataCollection.each(function( index ) { 
        var coll = $( this ).data('collection');
        var collIdx = $( this ).data('collectionIdx');

        if (!collectionIndicesMap.hasOwnProperty(coll)) {
            collectionIndicesMap[coll] = [];
        }

        var inArray = $.inArray(collIdx, collectionIndicesMap[coll]);
        if (inArray === -1) {
            collectionIndicesMap[coll].push(collIdx)
        }
        
        console.log( index + ": " + coll + "[" + collIdx + "]" );
    });

    console.log( "indexes " + JSON.stringify(collectionIndicesMap) );

    // append hidden input with the indices
    for (var key in collectionIndicesMap) {
        var collectionIndices = collectionIndicesMap[key];
        var indicesInput = document.createElement( 'input' );
        indicesInput.setAttribute('name', key + '-indices');
        indicesInput.setAttribute('type', 'hidden');
        indicesInput.setAttribute('value', collectionIndices.join(','));
        $form.prepend(indicesInput);
    }
}

/**
 * Adds an entry to a collection
 * @param {string} collectionName  The name of the collection
 * @param {array}  values          The array of value
 */
DynamicContentView.prototype.addCollectionEntry = function(collectionName, values)
{
    var $collTable = this.$form.find( '#_' + collectionName );
    var lastRowInput = $collTable.find("[data-collection]:last" );
    var idx = lastRowInput.data("collectionIdx") + 1;
    var collectionInfo = this.collections[collectionName];
    
    var fields = collectionInfo.schema.fields;
    var templateData = this.createTemplateDataCollectionEntry(collectionName, fields, values, idx, false);

    var html = collectionInfo.template(templateData);
    this.$form.find( '#_' + collectionName + ' > tbody:last' ).append(html);
    
}

/**
 * Adds "add" and "import" buttons
 * Precondition: the content form must have been rendered.
 */
DynamicContentView.prototype._decorateCollection = function(collectionName, collectionSize)
{
    var collectionNameUc = collectionName.charAt(0).toUpperCase() + collectionName.slice(1);
    var colspan = collectionSize + 1;
    var buttonAddItemsEntry = '<tfoot><tr><td colspan="' + colspan + '"><button id="button_add' + collectionNameUc + 'Entry" value="addItemsEntry" ><span class="glyphicon glyphicon-plus"></span> Add</button></td></tr>' +
                              '<tr><td colspan="' + colspan + '">Import items from CSV: <input type="file" id="file_import' + collectionNameUc + '" style="display: inline" /><button id="button_import' + collectionNameUc + '" ><span class="glyphicon glyphicon-import"></span> Import</button></td></tr></tfoot>';

    this.$form.find( "#_" + collectionName + " > tbody" ).after(buttonAddItemsEntry);
}

//////////

var ValidationCompiler = function()
{
    this.functions = {};

    this.parserFunc = null;

    this.ruleDelimiter = '|';

}

/**
 * Function is of 
 * @param {string} name   The name of the validation 
 * @param {Function} func The function with signature func({string} param)
 */
ValidationCompiler.prototype.addFunction = function(name, func)
{
    this.functions[name] = func;
}

/**
 *
 */
ValidationCompiler.prototype.compile = function(rulesText)
{
    var result = [];
    var validationRules = (rulesText) ? rulesText.split(this.ruleDelimiter) : null;

    if (!rulesText)
        return '';

    for (var i=0; i < validationRules.length; i++)
    {
        var ruleInfo = this.parserFunc(validationRules[i]);

        var validAttr = this.exec(ruleInfo.name, ruleInfo.params)
        if (validAttr) {
            result.push(validAttr);
        }
    }
    return result.join(' ');
}

ValidationCompiler.prototype.exec = function(name, param)
{
    if (this.functions.hasOwnProperty(name))
        return this.functions[name](param);
    return null;
}

ValidationCompiler.prototype.initWithLaravelToParsley = function()
{
    this.parserFunc = function(ruleText)
    {
        var ruleInfo = {
            name:'',
            params: null
        };

        var colonPos = ruleText.indexOf(':');
        if (colonPos  > -1) {
            ruleInfo.name = ruleText.substr(0, colonPos);
            ruleInfo.params = ruleText.substr(colonPos+1);
        } else {
            ruleInfo.name = ruleText;
        }
        return ruleInfo;
    }

    this.addFunction('active_url', function(param) {
        return 'data-parsley-type="url"';
    });

    this.addFunction('alpha', function(param) {
        return 'data-parsley-type="alphanum"';
    });

    this.addFunction('alpha_num', function(param) {
        return 'data-parsley-type="alphanum"';
    });

    this.addFunction('between', function(param) {
        var range = param.split(',');
        return 'data-parsley-length="[' + range[0] + ',' + range[1] + ']"';
    });
    
    this.addFunction('email', function(param) {
        return 'data-parsley-type="email"';
    });

    this.addFunction('integer', function(param) {
        return 'data-parsley-type="integer"';
    });

    this.addFunction('max', function(param) {
        return 'data-parsley-max="' + param + '"';
    });

    this.addFunction('min', function(param) {
        return 'data-parsley-min="' + param + '"';
    });

    this.addFunction('numeric', function(param) {
        return 'data-parsley-type="number"';
    });
   
    this.addFunction('regex', function(param) {
        return 'pattern="' + param +'"';
    });

    this.addFunction('required', function(param) {
        return 'required';
    });

    this.addFunction('same', function(param) {
        return 'data-parsley-equalto="#'+ param + '"';
    });

}