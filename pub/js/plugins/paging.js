interface.paging = function(data){	
	if(data.ns <= data.onPage) return '';
	var onPage = data.onPage>0 ? data.onPage : 1; // количество записей на одной странице
	var activePage = data.activePage>0 ? Number(data.activePage) : 0;
	var pages=Math.ceil(data.ns/onPage); // общее количество страниц
	var L = interface.user.lang;
	function findStartLink(activePage){			
		for(var i=activePage; i>(activePage-12); i--){
			if((RegExp('0$')).test(i)){
				return i;	
			}					
		}
	}	
	var p = [];
	this.tag = function(a){
	var r ='';
	for(var i=0; i<a.length; i++){
		if(a[i][0]!=activePage){
			r+='<a href="/page/'+a[i][0]+'" name="'+a[i][0]+'" class="pagination" title="'+a[i][1]+'">'+a[i][2]+'</a>';
		}
		else{
			r+='<span>'+ (a[i][0]+1) +'</span>';
		}
	}
	return r;
	}		
	var startLink = findStartLink(activePage);	
	if (activePage) { 		 
		p.push([0,L.first,'««'], [activePage-1,L.prev,'«']);				
	}	
	for (var i=startLink; i<Math.min(startLink+10, pages); i++) {			
		p.push([i,'',i+1]);		
	}
	if (activePage<(pages-1)) {			 
		 p.push([activePage+1,L.next,'»'], [pages-1,L.last,'»»']);			 
	}		
	return this.tag(p);		
};

interface.paging.keyboardBinds = function(el, c, f){
	$(el, c).focus(function(){				
		$(this).unbind('keypress').keypress(function(e){						
			var page =  parseInt($('.pages-box span',this).text());
			
			switch (e.keyCode) {
			  case 37:
			  	(function(){
					page = (page-2)<0 ? 0 : page;
					f.call(this,(page-2));					
				})();
			  break;
			  case 39:f.call(this, page);break;
			}
		}).addClass('focus');				
	}).blur(function(){
		$(this).removeClass('focus');	
	});
}