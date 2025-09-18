<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Single check box field.
 * This is a boolean field with null for false and the specified option for true
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @link        http://www.w3.org/TR/html-markup/input.checkbox.html#input.checkbox
 * @see         JFormFieldCheckboxes
 * @since       11.1
 */
class JFormFieldCkslider extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	public $type = 'Ckslider';

	/**
	 * Method to get the field input markup.
	 * The checked element sets the field to selected.
	 *
	 * @return  string   The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
	
		/*echo '<style type="text/css">
		.iPhoneCheckContainer{ position:relative; width:85px; height:27px; cursor:pointer; overflow:hidden;  }
.iPhoneCheckContainer input{ position:absolute; top:5px; left:30px;  }
.iPhoneCheckHandle{ display:block; height:27px; width:39px; cursor:pointer; position:absolute; top:0; left:0;  }
.iPhoneCheckHandle .iPhoneCheckHandleBG{ position:absolute; width:5px; height:100%; top:0; left:0; z-index:1;  }
.iPhoneCheckHandle .iPhoneCheckHandleSlider{ position:absolute; top:0; left:0; height:27px; width:39px; background:url(' . $this->getPathToImages() . '/images/iphone-slider.png) no-repeat; z-index:2;  }
label.iPhoneCheckLabelOn,label.iPhoneCheckLabelOff{ font-size:17px; line-height:17px; font-weight:bold; font-family:Helvetica Neue,Arial,Helvetica,sans-serif; text-transform:uppercase; cursor:pointer; display:block; height:22px; position:absolute; width:52px; top:0;visibility: visible !important;  }
label.iPhoneCheckLabelOn{ color:#fff; background:url(' . $this->getPathToImages() . '/images/iphone-on.png) no-repeat; text-shadow:0px 0px 2px rgba(0,0,0,0.6); left:0; padding:5px 0 0 8px;  }
label.iPhoneCheckLabelOff{ color:#8B8B8B; background:url(' . $this->getPathToImages() . '/images/iphone-off.png) no-repeat right 0; text-shadow:0px 0px 2px rgba(255,255,255,0.6); text-align:right; right:0; padding:5px 8px 0 0;  }
		</style>';*/
		
/*
		echo "<script>
		window.addEvent('domready',function(){
	(function($) {

		this.IPhoneCheckboxes = new Class({

			//implements
			Implements: [Options],

			//options
			options: {
				checkedLabel: 'ON',
				uncheckedLabel: 'OFF',
				background: '#fff',
				containerClass: 'iPhoneCheckContainer',
				labelOnClass: 'iPhoneCheckLabelOn',
				labelOffClass: 'iPhoneCheckLabelOff',
				handleClass: 'iPhoneCheckHandle',
				handleBGClass: 'iPhoneCheckHandleBG',
				handleSliderClass: 'iPhoneCheckHandleSlider',
				elements: 'input[type=checkbox].ckslider'
			},

			//initialization
			initialize: function(options) {
				//set options
				this.setOptions(options);
				//elements
				this.elements = $$(this.options.elements);
				//observe checkboxes
				this.elements.each(function(el) {
					this.observe(el);
				},this);
			},

			//a method that does whatever you want
			observe: function(el) {
				//turn off opacity
				el.set('opacity',0);
				//create wrapper div
				var wrap = new Element('div',{
					'class': this.options.containerClass
				}).inject(el.getParent());
				//inject this checkbox into it
				el.inject(wrap);
				//now create subsquent divs and labels
				var handle = new Element('div',{'class':this.options.handleClass}).inject(wrap);
				var handlebg = new Element('div',{'class':this.options.handleBGClass,'style':this.options.background}).inject(handle);
				var handleSlider = new Element('div',{'class':this.options.handleSliderClass}).inject(handle);
				var offLabel = new Element('label',{'class':this.options.labelOffClass,text:this.options.uncheckedLabel}).inject(wrap);
				var onLabel = new Element('label',{'class':this.options.labelOnClass,text:this.options.checkedLabel}).inject(wrap);
				var rightSide = wrap.getSize().x - 39;
				//fx instances
				el.offFx = new Fx.Tween(offLabel,{'property':'opacity','duration':200});
				el.onFx = new Fx.Tween(onLabel,{'property':'opacity','duration':200});
				//mouseup / event listening
				wrap.addEvent('mouseup',function() {
					var is_onstate = !el.checked; //originally 0
					var new_left = (is_onstate ? rightSide : 0);
					var bg_left = (is_onstate ? 34 : 0);
					handlebg.hide();
					new Fx.Tween(handle,{
						duration: 100,
						'property': 'left',
						onComplete: function() {
							handlebg.setStyle('left',bg_left).show();
						}
					}).start(new_left);
					//label animations
					if(is_onstate) {
						el.offFx.start(0);
						el.onFx.start(1);
					}
					else {
						el.offFx.start(1);
						el.onFx.start(0);
					}
					//set checked
					el.set('checked',is_onstate);
				});
				//initial load
				if(el.checked){
					offLabel.set('opacity',0);
					onLabel.set('opacity',1);
					handle.setStyle('left',rightSide);
					handlebg.setStyle('left',34);
				} else {
					onLabel.set('opacity',0);
					handlebg.setStyle('left',0);
				}
			}
		});

	})(document.id);


	var chx = new IPhoneCheckboxes();
});
</script>";*/
		$path = $this->getPathToElements() . '/ckslider/';
        JHTML::_('script', 'ckslider.js', $path);
		JHTML::_('stylesheet', 'ckslider.css', $path);
		
		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="ckslider ' . (string) $this->element['class'] . '"' : ' class="ckslider"';
		$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$checked = ((string) $this->element['value'] == $this->value) ? ' checked="checked"' : '';
                $styles = $this->element['styles'];
                
		// Initialize JavaScript field attributes.
		$onclick = $this->element['onclick'] ? ' onclick="' . (string) $this->element['onclick'] . '"' : '';

		return '<div style="'.$styles.'"><input type="checkbox" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'
			. htmlspecialchars((string) $this->element['value'], ENT_COMPAT, 'UTF-8') . '"' . $class . $checked . $disabled . $onclick . '/></div>';
	}
	
	protected function getPathToElements() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoimages;
    }

    protected function getLabel() {
        $label = '';
		$labelstyles = $this->element['labelstyles'];
        // Get the label text from the XML element, defaulting to the element name.
        $text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
        $text = JText::_($text);

        // Build the class for the label.
        $class = !empty($this->description) ? 'hasTip' : '';

        $label .= '<label id="' . $this->id . '-lbl" for="' . $this->id . '" class="' . $class . '"';

        // If a description is specified, use it to build a tooltip.
        if (!empty($this->description)) {
            $label .= ' title="' . htmlspecialchars(trim($text, ':') . '::' .
                            JText::_($this->description), ENT_COMPAT, 'UTF-8') . '"';
        }

        $label .= ' style="min-width:150px;max-width:150px;width:150px;display:block;float:left;padding:1px;'.$labelstyles.'">' . $text . '</label>';

        return $label;
    }
}
