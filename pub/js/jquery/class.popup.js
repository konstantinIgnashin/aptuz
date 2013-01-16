function Popup(tpl,opts) {
  var defaults = {speed: 500, maskClose:true, mask:'ppp-mask', body:'ppp-body', close:'.ppp-close'};       
  this.opts    = $.extend({}, defaults, opts);
	this.modal   = $('<div class="'+this.opts.body+'"></div>').appendTo('body');
	this.modalBG = $('<div class="'+this.opts.mask+'"></div>').insertAfter(this.modal);	
	this.busy    = false;	
	this.show(tpl);	
}
Popup.prototype.unlock = function(){
	this.busy   = false;
}

Popup.prototype.bind =function (func, thisValue) {       
     return function(){
       	return func.apply(thisValue, arguments);  
    }   
}

Popup.prototype.open = function(){	
	this.modalBG.unbind('click');
	$(this.opts.close).unbind('click');	
	if(!this.busy) {
		this.busy = true;			
		this.scrollBox();
		this.modalBG.fadeIn(this.opts.speed/2);
		this.modal.css({opacity:0}).delay(this.opts.speed/2).animate({opacity:1}, this.opts.speed, this.bind(this.unlock, this));				
	}
	return this;
}

Popup.prototype.close = function(){	
	if(!this.busy) {
		this.busy = true;							
		this.modalBG.delay(this.opts.speed).fadeOut(this.opts.speed);
		this.modal.animate({opacity:0}, this.opts.speed, this.bind(function() {
			this.modal.css({opacity:1});
			this.unlock();
			$('.'+this.opts.body+', .'+this.opts.mask).remove();
		}, this));						
	}
	return false;
}
Popup.prototype.getViewport = function() {		
		return [$(window).width(), $(window).height(), $(document).scrollLeft(), $(document).scrollTop() ];
};

Popup.prototype.scrollBox = function() {		
	var p = this.getViewport();
	var w = this.modal.width(),  h = this.modal.height();		
	this.modal.css('left', ((w	+ 10) > p[0] ? p[2] : p[2] + Math.round((p[0] - w - 10)	/ 2)));
	this.modal.css('top',  ((h	+ 14) > p[1] ? p[3] : p[3] + Math.round((p[1] - h - 14) / 2)));
	return this;
};

Popup.prototype.handlers = function(p) {	
	$(p.opts.close).click(function(){p.close();});			
	if(p.opts.maskClose)p.modalBG.click(function(){p.close();});		
	$('body').keyup(function(e){
		(e.which===27)?p.close():'';
	});		
	$(window).bind("resize scroll", function(){p.scrollBox();});	    
}
Popup.prototype.show = function(tpl){
	$(tpl).appendTo(this.modal);	
	this.open().handlers(this);		
}
Popup.prototype.replace = function(tpl){
	$(this.modal).html(tpl); 
	this.scrollBox();
	this.handlers(this);		
} 