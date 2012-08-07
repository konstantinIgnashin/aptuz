T.comments = (function(self, $){				  
	var _callBack = {
		c:'#content',
		comments:function(){
			$('.edit','tr').click(function(e){				
				var tr = $(this).parents('tr');
				$(T.tmpl("#commentEditTpl",{
								 author:$('.author',tr).text(),
								 text:$('.text',tr).text(),
								 id:self.getCommentId(this)
								 })).appendTo('#content');
				$('.comment-edit').css({'top':e.pageY});
				
				$('.submit').click(function(){					
					T.loader.getJSON('/admin/comment_edit/',$('form','.comment-edit').serialize(), function(){						
						$('.author',tr).text($('.author','.comment-edit').val());
						$('.text',tr).html($('.text','.comment-edit').val());						
						$('.comment-edit').remove();
					});
					return false;
				});
				$('.close','.comment-edit').click(function(){
					$('.comment-edit').remove();
				});
				//
				$('#markItUp').markItUp(mySettings).css('width','110px;');		
				return false;
			});
			$('.accept','tr').click(function(){
				var tr = $(this).parents('tr');
				T.loader.getJSON('/admin/comments_status/?status=0&id='+self.getCommentId(this), function(){			
					$('.status img', tr).attr('src','/pub/images/ok.png');					
				});
				return false;
			});
			$('.decline','tr').click(function(){
				var tr = $(this).parents('tr');
				T.loader.getJSON('/admin/comments_status/?status=1&id='+self.getCommentId(this), function(){			
					$('.status img', tr).attr('src','/pub/images/er.png');					
				});
				return false;
			});
				$('.s_status').click(function(){
				$('.s_status').removeClass('active');
				$(this).addClass('active');
			});	
			$('.pagination, .s_btn','.summary-log').click(function(){				
				return self.start(this.name);				
			});					
			T.paging.keyboardBinds(".summary-comments", this.c, self.start);
			$(".summary-comments", this.c).focus();	
		}
		
	}; 
	self.getCommentId = function(el){
		return $(el).parents('tr').attr('v');
	}
	
	self.start = function(page){
		var add='';
		if($('.active','.settings').attr('name')){
			add+='&disable='+ $('.active','.settings').attr('name');
		}
		if($('.s_text').val()){
			add+='&sword=' + $('.s_text').val();
		}
		T.loader.getJSON('/admin/comments/?page='+page+add, function(data){			
			$('#content').html(T.tmpl("#indexCommentsTpl",data.success));
			_callBack.comments();
		});
		return false;
	};	
	
	$(document).ready(function(){self.start(0);});		
	return self;
})(T.comments || {}, jQuery);

