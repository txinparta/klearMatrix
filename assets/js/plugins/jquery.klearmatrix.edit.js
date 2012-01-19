;(function load($) {

	this.count = this.count || 0;
	
	if (typeof $.klearmatrix.module != 'function') {
		if (++this.count == 10) {
			throw "JS Dependency error!";
		}
		setTimeout(function() {load($);},10);
		return;
	}
	
	$.widget("klearmatrix.edit", $.klearmatrix.module, {
		options: {
			data : null,
			moduleName: 'edit'
		},
		_super: $.klearmatrix.module.prototype,
		_create : function() {
			this._super._create.apply(this);
		},
		_init: function() {
			
			$.extend(this.options.data,{randIden:Math.round(Math.random(1000,9999)*100000)});
			
			var $appliedTemplate = this._loadTemplate("klearmatrixEdit");
			
			$(this.element.klearModule("getPanel")).append($appliedTemplate);
			
			this._applyDecorators()
				._registerBaseEvents()
				._registerEvents(); 
			
				
		},
		_registerEvents : function() {
			
			$(this.element.klearModule("getPanel")).on('submit','form.klearMatrix_edit',function() {
			
				
				
			});

		},
		_applyDecorators : function() {
			
			$(".generalOptionsToolbar button",this.element.klearModule("getPanel")).each(function() {
				$(this).button({
					icons: {
		                primary: $(this).data("icon")
		            },
		            text: $(this).data("text")
				})
			});
			return this;
		}
	});

	$.widget.bridge("klearMatrixEdit", $.klearmatrix.edit);

})(jQuery);
