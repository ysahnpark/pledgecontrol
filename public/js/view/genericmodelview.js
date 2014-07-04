
/**
 * Form constructor
 * 
 * @param {Element} $scopeEl The scope in which the  
 */
var GenericModelView = function($scopeEl)
{
    /*
    {
        propName: function($scopeEl, value);
    }
    */
    this._customPropertyBinder = {};

    this.$scopeEl = $scopeEl;
}

/**
 *
 */
GenericModelView.prototype.addCustomPropertyBinder = function(propName, handler)
{
    this._customPropertyBinder[propName] = handler;
}

/**
 * Binds the model to HTML.
 * @param {Object}  model
 */
GenericModelView.prototype.bindModel = function(model)
{
    for(var prop in model)
    {
        var value = model[prop];
        if (this._customPropertyBinder.hasOwnProperty(prop)) {
            // execute custom property handler
            this._customPropertyBinder[prop](this.$scopeEl, model, value);
        } else {
            var $widget = this.$scopeEl.find("#"+prop);

            if ($widget.length == 0)
                continue;
            
            if ($widget.is("input")) {
                var inputType = $widget.attr('type');
                if (inputType === 'text' || inputType === 'hidden' ) {
                    $widget.val(value);
                } else if (inputType === 'checkbox') {
                } else if (inputType === 'file') {
                } else if (inputType === 'radio') {
                }
            } else if ($widget.is("textarea")) {
                $widget.val(value);
            } else if ($widget.is("select")) {

            } 
            // Read only view
            else if ($widget.is("div")) {
                $widget.html(value);
            } else if ($widget.is("span")) {
                $widget.html(value);
            } else if ($widget.is("dd")) {
                $widget.html(value);
            } else if ($widget.is("td")) {
                $widget.html(value);
            }
        }
    }
}