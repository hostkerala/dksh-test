(function ($) {
	$.widget("custom.combobox", {
		options: {
			value: "",
			onSelect: null,
			params: null
		},
		_newItems: {},
		
		_create: function () {
			this.wrapper = $("<span>")
					.addClass("custom-combobox")
					.insertAfter(this.element);

			this.element.hide();
			this._createAutocomplete();
			this._createShowAllButton();
		},
		_createAutocomplete: function () {
			var selected = this.element.children(":selected"),
					value = selected.val() ? selected.text() : this.options.value;

			this.input = $("<input>")
					.appendTo(this.wrapper)
					.val(value)
					.attr("title", "")
					.attr("placeholder", this.element.children(":eq(0)").text() )
					.addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy(this, "_source")
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

			this._on(this.input, {
				autocompleteselect: function (event, ui) {
					ui.item.option.selected = true;
					this._trigger("select", event, {
						item: ui.item.option
					});
					this._callOnSelect( event, ui, $(ui.item.option).val() );
				},
				autocompletechange: "_addNewOption"
			});
			
			// prevent going to next element on "tab" and "enter"
			this.input.on('keydown', function(e){
				if( e.keyCode && (e.keyCode == 9 || e.keyCode == 13) ){
					e.preventDefault();
					$(this).trigger('blur');
				}
			})
		},
		_createShowAllButton: function () {
			var input = this.input,
					wasOpen = false;

			$("<a>")
					.attr("tabIndex", -1)
					.attr("title", "Show All Items")
					.tooltip()
					.appendTo(this.wrapper)
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass("ui-corner-all")
					.addClass("custom-combobox-toggle ui-corner-right")
					.mousedown(function () {
						wasOpen = input.autocomplete("widget").is(":visible");
					})
					.click(function () {
						input.focus();

						// Close if already visible
						if (wasOpen) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete("search", "");
					});
		},
		_source: function (request, response) {
			var combo = this;
			var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
			response(this.element.children("option").map(function () {
				var text = $(this).text();
				if (this.value && (!request.term || matcher.test(text)) && typeof(combo._newItems[this.value]) == 'undefined')
					return {
						label: text,
						value: text,
						option: this
					};
			}));
		},
		_addNewOption: function(event, ui){
			// Selected an item, nothing to do
			if (ui.item) {
				//console.log('ui.item present, return')
				return;
			}
			
			// Search for a match (case-insensitive)
			var value = $.trim( this.input.val() ),
					valueLowerCase = value.toLowerCase(),
					valid = false;
			
			if( value == '' ){
				//console.log('empty value');
				this._callOnSelect( event, ui, value );
				return;
			}
			
			this.element.children("option").each(function () {
				if ($(this).text().toLowerCase() === valueLowerCase) {
					this.selected = valid = true;
					
					ui.item = {option: this};
					return false;
				}
			});

			// Found a match, nothing to do
			if (valid) {
				//console.log('valid, return')
				this._callOnSelect( event, ui, value );
				return;
			}

			// insert new
			this.element.append('<option>').find('option:last').val( value ).text( value );
			this.element.val( value );
			
			ui.item = {option: this.element.find('option:last')};
			
			this._newItems[ value ] = value;
			this._callOnSelect( event, ui, value );
		},
		_callOnSelect: function( event, ui, value ){
			if( this.options.onSelect && typeof(this.options.onSelect) == 'function' ){
				this.options.onSelect.call(this, event, ui, value, this.options.params);
			}
		},
		_destroy: function () {
			this.wrapper.remove();
			this.element.show();
		}
	});
})(jQuery);
