interface.wiki = (function(self, $){				  
	var _callBack = {
		classes:function(){
			$('.get-propetries').click(function(){
				interface.loader.getJSON('/wiki/getpropetries?pid='+this.name).success(_h.getPropetries);
				return false;
			});
			$('.getfile').click(function(){				
				var url = '/wiki/getfile?filepath=' + self.config.mqlpath + this.name;
				$.ajax({dataType:"html", url:url, title:this.name,success:_h.getFile});
				//interface.loader.getJSON().success(_h.getFile);				
				return false;
			});
		}
	}; 
	var _h = {			
		start:function(data){
			$("#content").html($("#wikiTpl").tmpl(data.success).html());
			_callBack.classes();
		},
		getPropetries:function(data){
			$(".propetries-box").html($("#wikiGetPropetriesTpl").tmpl(data.success).html());
		},
		getFile:function(data){			
			$(".propetries-box").html($("#wikiPopupTpl").tmpl({d:data,t:this.title}).html());
			//self.popup({text:data});
			//alert(data.success);
		}
	}
	
	self.popup = function(opts){
		var options = {tpl:'#wikiPopupTpl',	text:'',create:function(){$('body').append($(this.tpl).tmpl({d:this.text}).html());}}
		$.extend(options, opts);
		options.create();	
	}
	
	self.start = function(){		
		interface.loadScript('/pub/js/plugins/config.wiki.js');
		interface.loader.getJSON('/wiki').success(_h.start);		
	}	
	$(document).ready(self.start);		
	return self;
})(interface.wiki || {}, jQuery);

