(function(){function e(c,b){var d={};jQuery.each(b||[],function(b,a){a instanceof Array||(a=[a,a]);c.push([a[0],"get"+a[1]],[a[0],"set"+a[1]])});jQuery.each(c,function(b,a){var c=a;a instanceof Array&&(c=a[1],a=a[0]);d[c]=jQuery.Class.create({init:function(){var a=Array.prototype.slice.call(arguments);if(this.constructor==d[c])this.arguments=a;else return d[c].prototype.attach.apply(d[c],a)},arguments:[],attach:function(c){var b=arguments.length==1?this.arguments:Array.prototype.slice.call(arguments, 1);if(b.length){var d=b[b.length-1];typeof d=="function"&&(b[b.length-1]=function(){var a=Array.prototype.slice.call(arguments);return d.apply(this,[this].concat(a))})}return jQuery.fn[a].apply(jQuery(c),b)}})});return d}var f=!1,g=/xyz/.test(function(){xyz})?/\b_super\b/:/.*/;jQuery.Class=function(){};jQuery.Class.create=function(c){function b(){if(!f&&b.prototype.init)return b.prototype.init.apply(this,arguments)}var d=this.prototype;f=!0;var e=new this;f=!1;for(var a in c)e[a]="function"==typeof c[a]&& "function"==typeof d[a]&&g.test(c[a])?function(a,b){return function(){var c=this._super;this._super=d[a];var e=b.apply(this,arguments);this._super=c;return e}}(a,c[a]):c[a];b.prototype=e;b.prototype.constructor=b;b.extend=arguments.callee;return b};jQuery.querySelectorAll=function(){return jQuery.apply(jQuery,arguments)};jQuery.querySelector=function(){return jQuery.querySelectorAll.apply(jQuery,arguments)[0]};jQuery.fn.forEach=function(c){return this.each(function(b){c(this,b)})};jQuery.fn.attach= function(c){var b=c.attach||(new c).attach||function(){};return this.forEach(function(d){b.call(c,d)})};jQuery.DOM=e(["prepend","append",["before","insertBefore"],["after","insertAfter"],"wrap","wrapInner","wrapAll","clone","empty","remove","replaceWith",["removeAttr","removeAttribute"],["addClass","addClassName"],["hasClass","hasClassName"],["removeClass","removeClassName"],["offset","getOffset"]],[["text","Text"],["html","HTML"],["attr","Attribute"],["val","Value"],["height","Height"],["width", "Width"],["css","CSS"]]);jQuery.Traverse=e([["children","getChildElements"],["find","getDescendantElements"],["next","getNextSiblingElements"],["nextAll","getAllNextSiblingElements"],["parent","getParentElements"],["parents","getAncestorElements"],["prev","getPreviousSiblingElements"],["prevAll","getAllPreviousSiblingElements"],["siblings","getSiblingElements"],["filter","filterSelector"]]);jQuery.Events=e([["bind","addEventListener"],["unbind","removeEventListener"],["trigger","triggerEvent"],"hover", "toggle"]);jQuery.fn.buildAnimation=function(c){var b=this;return{start:function(){b.animate(c)},stop:function(){b.stop()}}};jQuery.Effects=e("show,hide,toggle,buildAnimation,queue,dequeue".split(","));jQuery.fn.ajax=jQuery.ajax;jQuery.Ajax=e([["ajax","request"],["load","loadAndInsert"],["ajaxSetup","setup"],["serialize","getSerializedString"],["serializeArray","getSerializedArray"]])})();
jQuery.fn.extend({show_overlay:function(){element=jQuery(this);element.data("old_position",element.css("position"));element.css("position","relative");var a=element.find(".overlay");0==a.size()&&(a=jQuery("<div>").addClass("overlay"),element.append(a))},hide_overlay:function(){element=jQuery(this);element.find(".overlay").remove();element.css("position",element.data("old_position"))}});

jQuery.extend({
    patch : function(){
        jQuery._grep = jQuery.grep;
        jQuery.grep = function(elems,callback,inv){
            return jQuery._grep.call(this, elems, function(element, key){
                return element.tagName.toLowerCase() !== 'script' ? callback(element, key) : false;
            }, inv);
        }
    },
    unpatch : function(){jQuery.grep = jQuery._grep;}
});

function appendSmallCart()
{
	var new_checkoutajax_cart = jQuery('#checkoutajax').find('.jshop.cart');
	if(new_checkoutajax_cart.size() > 0)
	{
		jQuery('#checkoutajax_smallcart').empty().append(jQuery('.jshop.cart').parent());
		jQuery('#checkoutajax .jshop.cart').parent().remove();
	}
}

var CheckoutAjax = jQuery.Class.create({
    init : function(element){
        var self = this;
        this.element = element;
        this.element.delegate('.checkoutajax-title a','click',function(event){
            event.preventDefault();
            if(jQuery(this).is('.checkoutajax-disabled'))return false;
            self.refresh(jQuery(this).attr('href'));
        });
        this.setFormEvents();
		if (checkoutajax_show_small_cart) appendSmallCart();
    },
    refresh : function(url, data){
        var self = this;
        this.element.find('.checkoutajax-content').show_overlay();
        data = data || {};
        jQuery.ajax({
            data:data,url:url,type:'post',cache:false,dataType:'html',async:false,
            success : function(result, textStatus, jqXHR){                
                jQuery.patch();
                self.element.find('.checkoutajax-content').hide_overlay();
                var new_checkoutajax_element = jQuery(result).find('#checkoutajax');
                if(new_checkoutajax_element.size() > 0)
                {
                    self.element.find('#checkoutajax').replaceWith(new_checkoutajax_element);
                    self.executeScripts(new_checkoutajax_element.find('script'));
                    self.setFormEvents();
                }
                else document.location.reload();
				if (checkoutajax_show_small_cart) appendSmallCart();
				jQuery.unpatch();
            },
            error : function(){self.element.find('.checkoutajax-content').hide_overlay();}
        });
    },
    submitForm : function(form){
        var data = {};
        var inputs = form.find('input,textarea,select');
        inputs.each(function(key,input){
            if(input.name)
            {
                var flag = jQuery.inArray(input.type, ['radio','checkbox']) != -1;
                if(!flag || flag && jQuery(input).is(':checked'))data[input.name] = input.value;
            }
        });
        this.refresh(form[0].action, data);
    },
    setFormEvents : function(){
        var self = this;
        var registration_button = this.element.find('.register_block [type=button]');
        if(registration_button.size() > 0)registration_button[0].onclick = function(){
            self.refresh(checkoutajax_registration_url);
        };
        this.element.find('form').not('[name=form_finish]').each(function(key,form){
            form.submit = function(){self.submitForm(jQuery(this));};
            form._onsubmit = form.onsubmit;
            form.onsubmit = function(event){
                if(!this._onsubmit || this._onsubmit(event))self.submitForm(jQuery(this));
                return false;
            };
        });
        if(checkoutajax.states_plugin_enabled && typeof getState == 'function')
        {
            getState("country", jQuery('#country').val());
            getState("d_country", jQuery('#d_country').val());
            jQuery('#country').bind("change", function(){
                getState(this.id, this.value);                
            });
            jQuery('#d_country').bind("change", function(){
                getState(this.id, this.value);
            });
        }
    },
    executeScripts : function(scripts, index){
        var self = this;
        if(index === undefined)index = 0;
        if(scripts[index])
        {
            if(scripts[index].src)
            {
                jQuery.ajax({url:scripts[index].src,async:false,dataType:'script',
                    success:function(){self.executeScripts(scripts, index+1);}
                });
            }
            else
            {
                jQuery.globalEval((scripts[index].text || scripts[index].textContent || scripts[index].innerHTML || "").replace(/^\s*<!(?:\[CDATA\[|\-\-)/, "/*$0*/"));
                this.executeScripts(scripts, index+1);
            }
        }        
        else if(typeof InitKlarnaInvoiceElements == 'function' && klarna_config)
        {
            InitKlarnaInvoiceElements('klarna_invoice', klarna_config.eid, 'de', klarna_config.pay_price);           
        }
    }
});
jQuery(document).ready(function(){new CheckoutAjax(jQuery('#checkoutajax-wrapper'));});