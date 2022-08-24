<? if (!empty($vars['current']) && is_array($vars['rubrics'])): ?>

<?
	$max_in_column = 20;	

	//строит путь для default рубрик
	function get_default_path($rubric){
	
		if(!isset($rubric['default']))
			return "/";
			
		return "/".$rubric['default'].get_default_path($rubric['subrubrics'][$rubric['default']]);
	}

	//строит url для рубрик
	function create_urls(&$rubrics, $key = null, $prefix = null){			
		
		if (!empty($key))
			foreach($rubrics as $k=>$rubric){
				
				if(empty($prefix))
					$rubrics[$k]['url'] = '/'.App::$Env['section'].'/'.$key."/";
				else 
					$rubrics[$k]['url'] = '/'.App::$Env['section'].'/'.$prefix."/".$key."/";
					
				if(!empty($k))
					$rubrics[$k]['url'].= $k."/";
				
				if(!empty($rubric['subrubrics']))
					create_urls($rubrics[$k]['subrubrics'], $key."/".$k, $prefix);
			}
		else
			foreach($rubrics as $k=>$rubric){
				
				if(empty($prefix))
					$rubrics[$k]['url'] = '/'.App::$Env['section'].'/'.$k.get_default_path($rubric);
				else 	
					$rubrics[$k]['url'] = '/'.App::$Env['section'].'/'.$prefix.'/'.$k.get_default_path($rubric);					
					
				if(!empty($rubric['subrubrics']))
					create_urls($rubrics[$k]['subrubrics'], $k, $prefix);
			}
	}

	//формирует структуру "хлебных крошек"
	function fill_level($rubrics, &$currents, $level, &$crumbs){
					
		if(!is_array($rubrics) || !is_array($crumbs))
			return false;
			
		foreach ( $rubrics as $k => $l ) {
						
				$crumbs[$level][]= array(
					'title' 	=> $l['title'],
					'url'	=> $l['url'],
					'active'	=> ($k == $currents[$level]),
				);					
		
			if(($k == $currents[$level]) && is_array($l['subrubrics']) && !empty($currents[$level+1])) 
				fill_level($l['subrubrics'], $currents, $level+1, $crumbs);
		}
	}
	
	create_urls($vars['rubrics']['subrubrics'], null, $vars['root']['prefix']); 
	
	$currents = explode("/", $vars['current']);
	
	$crumbs = array();
	
	fill_level($vars['rubrics']['subrubrics'], $currents, 0, $crumbs);	

?>

<?//<link rel="stylesheet" type="text/css" href="/_styles/design/200710_dom/modules/realty/breadcrumb.css" src="/_styles/design/200710_dom/modules/realty/breadcrumb.css" />?>

<table border="0" cellspacing="0" cellpadding="0" class="breadcrumb">
	<tr>
		<td class="root" valign="top">
		<? if ( empty($vars['root']['link']) ): ?>
			<a href="/<?=App::$Env['section']?>/"><?=App::$Env['site']['title'][App::$Env['section']]?></a>
		<? else: ?>
			<?=$vars['root']['link']?>
		<? endif; ?>
		</td>
	
	<? $i = count($crumbs); ?>
	<? foreach ( $crumbs as $v ): ?>
	<? $i--; ?>
		<td class="mainmenu<? if ( $i <= 0 ):?> last<? endif; ?>"  id="i_<?=$i?>_td<? if ( $i <= 0 ):?>_last<? endif; ?>" style="padding-top:4px" valign="top">
			<div class="submenu" id="i_<?=$i?>_mainmenu<? if ( $i <= 0 ):?>_last<? endif; ?>">
				<table border="0" cellspacing="0" cellpadding="0" class="container">
				
				<?
					$cols = floor(count($v)/$max_in_column)+intval(count($v)%$max_in_column>0);
					
					if($cols<1)
						$cols = 1;								
				?>
				
				<tr>
				
				<? for($w=0; $w<$cols; $w++):?>	
					<td class="container" valign="top">
						<table border="0" cellspacing="0" cellpadding="0">
						<? for($k=$max_in_column*$w; $k<$max_in_column*($w+1)&&$k<count($v); $k++): ?>
						<tr>
							<? if (!empty($v[$k]['title'])): ?>
							<td<? if ( $v[$k]['active'] === true ): ?> class="active"<? endif; ?>>
								<a href="<?=$v[$k]['url']?>"><?=$v[$k]['title']?></a>								
							</td>
							
								<? if ( $v[$k]['active'] === true ): ?>
									<? $active = array( 'title' => $v[$k]['title'], 'url' => $v[$k]['url'] ); ?>
								<? endif; ?>
							
							<? else: ?>
								<td>&nbsp;</td>
							<? endif;?>
						</tr>
						<? endfor;?>
						</table>
					</td>
				<? endfor;?>
				
				</tr>				
			
				</table>
				<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
			</div>
			<a href="<?=$active['url']?>"><?=$active['title']?></a>
			<div class="hint"><span>выбрать раздел</span></div>
		</td>
	<? endforeach; ?>
	</tr>
</table>		
		
<script type="text/javascript" language="javascript">
	<? if($cols>1):?>

				$(document).ready(function() {					
					var left = $('#i_0_mainmenu_last').css('left');
					var paddingright = $('#i_0_td_last').css('padding-right');					
					var paddingleft = $('#i_0_mainmenu_last').css('padding-left');
					var paddinglefttd = $('#i_0_td_last').css('padding-left');
					var borderright = $('#i_0_mainmenu_last').css('border-right-width');
					var borderleft = $('#i_0_mainmenu_last').css('border-left-width');
					left = left.replace('px', '')*1;
					
					if(isNaN(left))
						left = $('#i_0_mainmenu_last').attr('offsetLeft')*1+7;//7 - магическое число
					
					paddingright = paddingright.replace('px', '')*1;
					paddingleft = paddingleft.replace('px', '')*1;
					paddinglefttd = paddinglefttd.replace('px', '')*1;
					borderright = borderright.replace('px', '')*1;
					borderleft = borderleft.replace('px', '')*1;
					if(isNaN(borderleft))
						borderleft = 0;
					if(isNaN(paddingright))
						paddingright = 0;
					if(isNaN(paddingleft))
						paddingleft = 0;
					if(isNaN(paddinglefttd))
						paddinglefttd = 0;
					if(isNaN(borderright))
						borderright = 0;					
					left = left + $('#i_0_td_last').width()*1-$('#i_0_mainmenu_last').width()*1+paddingright-paddingleft+paddinglefttd+borderright+borderleft;
					
					$('#i_0_mainmenu_last').css('left', left );					
				});
	<? endif;?>		

	<? if($vars['pred_sdvig']==true):?>

				$(document).ready(function() {					
					var left = $('#i_1_mainmenu').css('left');
					var paddingright = $('#i_1_td').css('padding-right');					
					var paddingleft = $('#i_1_mainmenu').css('padding-left');
					var paddinglefttd = $('#i_1_td').css('padding-left');
					var borderright = $('#i_1_mainmenu').css('border-right-width');
					var borderleft = $('#i_1_mainmenu').css('border-left-width');
					left = left.replace('px', '')*1;
					
					if(isNaN(left))
						left = $('#i_1_mainmenu').attr('offsetLeft')*1+7;//7 - магическое число
					
					paddingright = paddingright.replace('px', '')*1;
					paddingleft = paddingleft.replace('px', '')*1;
					paddinglefttd = paddinglefttd.replace('px', '')*1;
					borderright = borderright.replace('px', '')*1;
					borderleft = borderleft.replace('px', '')*1;
					if(isNaN(borderleft))
						borderleft = 0;
					if(isNaN(paddingright))
						paddingright = 0;
					if(isNaN(paddingleft))
						paddingleft = 0;
					if(isNaN(paddinglefttd))
						paddinglefttd = 0;
					if(isNaN(borderright))
						borderright = 0;					
					left = left + $('#i_1_td').width()*1-$('#i_1_mainmenu').width()*1+paddingright-paddingleft+paddinglefttd+borderright+borderleft;
					
					$('#i_1_mainmenu').css('left', left );					
				});
	<? endif;?>		
	
		

$(document).ready( function() {	

	$('.mainmenu').bind('mouseenter', function() {
		var obj = $('.submenu',this).get(0);
		if ( obj != null && this.offsetWidth + 2 > obj.offsetWidth )
		{
			$('.submenu',this).css('width',this.offsetWidth + 2);
		}
		if ( $.browser.msie ) // IE6 hack for Selects
		{
			obj = $('.submenu',this).get(0);
			$('.submenu iframe',this).css('width', obj.offsetWidth);
			$('.submenu iframe',this).css('height', obj.offsetHeight);
		}
		$('.submenu',this).css('visibility','visible');
		$(this).addClass("hover");
	}).bind('mouseleave', function() {
		$('.submenu',this).css('visibility','hidden');
		$(this).removeClass("hover");
	});
		
});

</script>

<? endif; ?>
