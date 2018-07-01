
(function($){

	$.snScalingImage = {};

	$.fn.snScalingImage = function(config){

		// for IE which do not have MediaQueries.
		var msie = navigator.appVersion.toLowerCase();
		msie = (msie.indexOf('msie')>-1) ? parseInt(msie.replace(/.*msie[ ]/,'').match(/^[0-9]+/)) : 0;
		if(msie !== 0 && msie < 9) {
			this.addClass('noMediaQueries');
			return this;
		}
		// end for IE

		var defaults = $.fn.snScalingImage.defaults = {
			minHeight:	this.height() / 2,
			maxHeight:	this.height(),
			vertical:	'bottom'
		};

		var wrap = this;
		var img = this.find('img');

		var natural = {};

		var options = $.extend(defaults, config);

		var setStyle = $.snScalingImage.setStyle = function(config){

			options = $.extend(defaults, config);

			wrap.css({
				position: 'relative',
				overflow: 'hidden',
				height: options.maxHeight
			});

			var imgCss = { position: 'absolute', width: '100%', height: 'auto'};
			if(options.vertical === 'top'){
				imgCss.top = 0;
				imgCss.bottom = 'auto';
			} else{
				imgCss.top = 'auto';
				imgCss.bottom = 0;
			}
			img.css(imgCss);
			wrap.trigger('onSetNaturalSize');
		};

		var getLeft = function(wrap, target){
			return (wrap.width() - target.width()) / 2;
		};

		var setImageSize = $.snScalingImage.setImageSize = function(){
			var height = natural.height / (natural.width / wrap.width());

			if(height < options.minHeight){
				wrap.css({
					height: options.minHeight
				});
				img.css({
					width: 'auto',
					height: '100%'
				});
			} else if(height < options.maxHeight){
				wrap.css({
					height: height
				});
				img.css({
					width: '100%',
					height: 'auto'
				});
			} else{
				wrap.css({
					height: options.maxHeight
				});
				img.css({
					width: '100%',
					height: 'auto'
				});
			}
			//widthとheightを設定してからleftを計算する必要あり
			img.css({ left: getLeft(wrap, img) });
		};

		wrap.bind('onSetNaturalSize', function(){
			setImageSize();
			$(window).resize(setImageSize);
		});

		if(img.get(0).width === 0){
			img.load(function(){
				natural = $.snScalingImage.getNaturalSize(this);
				wrap.trigger('onSetNaturalSize');
			});
		} else{
			natural = $.snScalingImage.getNaturalSize(img.get(0));
			wrap.trigger('onSetNaturalSize');
		}

		setStyle(options);

		// for IE
		if(document.uniqueID){
			img.attr('src',img.attr('src')+ '?' + new Date().getTime());
		}

		return wrap;
	};

	$.snScalingImage.getNaturalSize = function(image){
		var w = image.width, h = image.height, mem = {};

		if(typeof image.naturalWidth !== 'undefined') { // for Firefox, Safari, Chrome
			w = image.naturalWidth;
			h = image.naturalHeight;

		} else if(typeof image.runtimeStyle !== 'undefined' ) { // for IE
			var run = image.runtimeStyle;
			mem = { w: run.width, h: run.height }; // keep runtimeStyle
			run.width  = "auto";
			run.height = "auto";
			w = image.width;
			h = image.height;
			run.width  = mem.w;
			run.height = mem.h;

		} else{ // for Opera
			mem = { w: image.width, h: image.height }; // keep original style
			image.removeAttribute("width");
			image.removeAttribute("height");
			w = image.width;
			h = image.height;
			image.width  = mem.w;
			image.height = mem.h;
		}
		return { width:w, height:h };
	}

})(jQuery);
