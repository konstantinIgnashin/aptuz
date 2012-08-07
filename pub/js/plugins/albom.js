interface.albom = (function(self, $){
	var _imageCollection = {};
	var _imageContent    = {};
	var _aImg     = 0;
	var _context = '#albomScroller2';
	var _showWindow = '#albomBigImg div';
	
	self.preload = function(){
		for(var i=-1;i<=1;i=i+2){
			if(_imageCollection[_aImg+i] && (_imageContent[_aImg+i]==undefined) ){
				_imageContent[_aImg+i] = new Image();
				_imageContent[_aImg+i].src = $('a',_imageCollection[_aImg+i]).attr('href');			
			}			
		}		
	}	
	self.findImages = function(){
		_imageCollection = $('li', _context);
	}
	
	self.show = function(a){
		var height = 400;
		var width  = 400;
		var image  = Image();
		image.src  = a.href;
		if(image.height>image.width){
			image.height = height;
		}
		else{
			image.width = width;
		}		
		$(_showWindow).html(image).css({width:image.width});		
	}	

	$(document).ready(function(){
		$('a',_context).hover(function(){
			_aImg = $('a',_context).index(this);
			self.preload();
			self.show(this);
			return false;
		}).click(function(){return false;});
		
		self.findImages();
		self.preload();
	});
	return self;
})(interface.albom || {}, jQuery);