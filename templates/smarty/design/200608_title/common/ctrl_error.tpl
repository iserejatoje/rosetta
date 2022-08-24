<script language="javascript">{literal}
	$(document).keypress(function(event){
		if((event.ctrlKey) && ((event.keyCode==10)||(event.keyCode==13))) 
		{
			if (document.getSelection)
			{ 
				txt = document.getSelection(); 
			} 
			else 
				if (document.selection) 
				{ 
					txt = document.selection.createRange().text; 
				}
				
			var len = txt.toString().length;
			
			if (len == 0)
				return true;
				
			if (len < 10 || len > 500)
			{
				alert("Чтобы мы быстрее исправили ошибку, выделенный вами текст должен быть не менее 10 и не более 500 знаков.");
				return false;
			}
						
			var errorWnd = window.open("http://{/literal}{if !empty($CURRENT_ENV.site.regdomain) && in_array($CURRENT_ENV.regid, array('02', '16', '24', '34', '55', '59', '61', '63', '72', '74'))}{$CURRENT_ENV.site.regdomain}{else}rugion.ru{/if}{literal}/feedback/error.html?text="+escape(txt)+"&referer="+document.location.href, "", "menubar=no,location=yes,resizable=no,scrollbars=no,status=yes,width=480,height=600");
			return false;
		}
		return true;
	});{/literal}
</script>