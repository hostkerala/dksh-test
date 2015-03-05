
// custom forms plugin
(function(jQuery){
	// custom checkboxes module
	jQuery.fn.customCheckbox = function(_options){
		var _options = jQuery.extend({
			checkboxStructure: '<div></div>',
			checkboxDisabled: 'disabled',
			checkboxDefault: 'checkboxArea',
			checkboxChecked: 'checkboxAreaChecked'
		}, _options);
		return this.each(function(){
			var checkbox = jQuery(this);
			if(!checkbox.hasClass('outtaHere') && checkbox.is(':checkbox')){
				var replaced = jQuery(_options.checkboxStructure);
				this._replaced = replaced;
				if(checkbox.is(':disabled')) replaced.addClass(_options.checkboxDisabled);
				else if(checkbox.is(':checked')) replaced.addClass(_options.checkboxChecked);
				else replaced.addClass(_options.checkboxDefault);

				replaced.click(function(){
					if(checkbox.is(':checked')) checkbox.removeAttr('checked');
					else checkbox.attr('checked', 'checked');
					changeCheckbox(checkbox);
				});
				checkbox.click(function(){
					changeCheckbox(checkbox);
				});
				replaced.insertBefore(checkbox);
				checkbox.addClass('outtaHere');
			}
		});
		function changeCheckbox(_this){
			_this.change();
			if(_this.is(':checked')) _this.get(0)._replaced.removeClass().addClass(_options.checkboxChecked);
			else _this.get(0)._replaced.removeClass().addClass(_options.checkboxDefault);
		}
	}

	// custom radios module
	jQuery.fn.customRadio = function(_options){
		var _options = jQuery.extend({
			radioStructure: '<div></div>',
			radioDisabled: 'disabled',
			radioDefault: 'radioArea',
			radioChecked: 'radioAreaChecked'
		}, _options);
		return this.each(function(){
			var radio = jQuery(this);
			if(!radio.hasClass('outtaHere') && radio.is(':radio')){
				var replaced = jQuery(_options.radioStructure);
				this._replaced = replaced;
				if(radio.is(':disabled')) replaced.addClass(_options.radioDisabled);
				else if(radio.is(':checked')) replaced.addClass(_options.radioChecked);
				else replaced.addClass(_options.radioDefault);
				replaced.click(function(){
					if($(this).hasClass(_options.radioDefault)){
						radio.attr('checked', 'checked');
						changeRadio(radio.get(0));
					}
				});
				radio.click(function(){
					changeRadio(this);
				});
				replaced.insertBefore(radio);
				radio.addClass('outtaHere');
			}
		});
		function changeRadio(_this){
			$(_this).change();
			$('input:radio[name="'+$(_this).attr("name")+'"]').not(_this).each(function(){
				if(this._replaced && !$(this).is(':disabled')) this._replaced.removeClass().addClass(_options.radioDefault);
			});
			_this._replaced.removeClass().addClass(_options.radioChecked);
		}
	}

	// custom selects module
	jQuery.fn.customSelect = function(_options) {
		var _options = jQuery.extend({
			selectStructure: '<div class="selectArea"><span class="left"></span><span class="center"></span><a href="#" class="selectButton"></a><div class="disabled"></div></div>',
			hideOnMouseOut: false,
			copyClass: true,
			selectText: '.center',
			selectBtn: '.selectButton',
			selectDisabled: '.disabled',
			optStructure: '<div class="optionsDivVisible"><div class="select-top"></div><div class="select-center"><ul></ul><div class="select-bottom"></div></div>',
			optList: 'ul'
		}, _options);
		return this.each(function() {
			var select = jQuery(this);
			if(!select.hasClass('outtaHere')) {
				if(select.is(':visible')) {
					var hideOnMouseOut = _options.hideOnMouseOut;
					var copyClass = _options.copyClass;
					var replaced = jQuery(_options.selectStructure);
					var selectText = replaced.find(_options.selectText);
					var selectBtn = replaced.find(_options.selectBtn);
					var selectDisabled = replaced.find(_options.selectDisabled).hide();
					var optHolder = jQuery(_options.optStructure);
					var optList = optHolder.find(_options.optList);
					if(copyClass) optHolder.addClass('drop-'+select.attr('class'));

					if(select.attr('disabled')) selectDisabled.show();
					select.find('option').each(function(){
						var selOpt = $(this);
						var _opt = jQuery('<li><a href="#">' + selOpt.html() + '</a></li>');
						if(selOpt.attr('selected')) {
							selectText.html(selOpt.html());
							_opt.addClass('selected');
						}
						_opt.children('a').click(function() {
							optList.find('li').removeClass('selected');
							select.find('option').removeAttr('selected');
							$(this).parent().addClass('selected');
							selOpt.attr('selected', 'selected');
							selectText.html(selOpt.html());
							select.change();
							optHolder.hide();
							return false;
						});
						optList.append(_opt);
					});
					replaced.width(select.outerWidth());
					replaced.insertBefore(select);
					optHolder.css({
						width: select.outerWidth(),
						display: 'none',
						position: 'absolute'
					});
					jQuery(document.body).append(optHolder);

					var optTimer;
					replaced.hover(function() {
						if(optTimer) clearTimeout(optTimer);
					}, function() {
						if(hideOnMouseOut) {
							optTimer = setTimeout(function() {
								optHolder.hide();
							}, 200);
						}
					});
					optHolder.hover(function(){
						if(optTimer) clearTimeout(optTimer);
					}, function() {
						if(hideOnMouseOut) {
							optTimer = setTimeout(function() {
								optHolder.hide();
							}, 200);
						}
					});
					selectBtn.click(function() {
						if(optHolder.is(':visible')) {
							optHolder.hide();
						}
						else{
							if(_activeDrop) _activeDrop.hide();
							optHolder.children('ul').css({height:'auto', overflow:'hidden'});
							optHolder.css({
								top: replaced.offset().top + replaced.outerHeight(),
								left: replaced.offset().left,
								display: 'block'
							});
							if(optHolder.children('ul').height() > 200) optHolder.children('ul').css({height:200, overflow:'auto'});
							_activeDrop = optHolder;
						}
						return false;
					});
					replaced.addClass(select.attr('class'));
					select.addClass('outtaHere');
				}
			}
		});
	}
	
	//Custom input file
	jQuery.fn.customFile = function(options){
		var options = jQuery.extend({
			btnText: "Upload",
			defaultText: "",
			fullActive: false
		}, options);
		return this.each(function(){
			var jsEl = this;
			var jqEl = $(this);
			var row = jqEl.parent();
			var fileField = $('<div class="cstFileField"><div class="cstFileTxt">'+options.defaultText
				+'</div><div class="cstFileBtn">'+options.btnText+'</div></div>');
			var fileBtn = fileField.children('.cstFileBtn');
			var fileTxt = fileField.children('.cstFileTxt');
			var ie = $.browser.msie;
			
			if (!jqEl.hasClass('outtaHere')) {
				
				//Prepare
				row.css({'position': 'relative'}).append(fileField);
				jqEl.addClass('outtaHere');
				
				//Handlers
				fileBtn.unbind('click').click(function(){
					jqEl.trigger('click');
				});
				
				if (options.fullActive) {
					fileTxt.unbind('click').click(function(){
						jqEl.trigger('click');
					});
				}
				
				if (!ie) jqEl.change(function(){changeHandler(this)});	
				else jsEl.attachEvent('onpropertychange', function() {changeHandler(this)});
				
				//Functions
				function changeHandler(el) {
					var thisEl = $(el);
					var splitArr = jqEl.val().split('\\');
					fileName = splitArr[splitArr.length - 1];
					trimLine(fileTxt, fileName);
				}
				
				function trimLine(el, str) {
					var trimSpan = $('<span style="position:absolute; zoom:1; white-space:nowrap;"></span>');
					el.html(trimSpan);
					var defWidth = el.width();
					var newStr = "";
					
					
					for (var i = 0; i < str.length; i++) {
						trimSpan.append(str.charAt(i));
						newStr += str.charAt(i);
						if(trimSpan.width() > defWidth) {
							el.html(newStr.slice(0, newStr.length - 3) + "..");
							break;
						}
					}
					el.html(el.text());
				}
			}
		});
	}

	// event handler on DOM ready
	var _activeDrop;
	jQuery(function(){
		jQuery('body').click(hideOptionsClick)
		jQuery(window).resize(hideOptions)
	});
	function hideOptions() {
		if(_activeDrop && _activeDrop.length) {
			_activeDrop.hide();
			_activeDrop = null;
		}
	}
	function hideOptionsClick(e) {
		if(_activeDrop && _activeDrop.length) {
			var f = false;
			$(e.target).parents().each(function(){
				if(this == _activeDrop) f=true;
			});
			if(!f) {
				_activeDrop.hide();
				_activeDrop = null;
			}
		}
	}
})(jQuery);