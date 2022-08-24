<? if (!empty($vars['current']) && is_array($vars['rubrics'])): ?>

<?

	//строит путь для default рубрик
	function get_default_path($rubric){
	
		if(!isset($rubric['default']))
			return "";

			
		return "/".$rubric['default'].get_default_path($rubric['subrubrics'][$rubric['default']]);
	}

	//строит url для рубрик
	function create_urls(&$rubrics, $key = null, $prefix = null){
		
		if (!empty($key))
			foreach($rubrics as $k=>$rubric){
				
				if(empty($prefix))
					$rubrics[$k]['url'] = $key."/".$k;
				else 
					$rubrics[$k]['url'] = $prefix.$key."/".$k;
				
				if(!empty($rubric['subrubrics']))
					create_urls($rubrics[$k]['subrubrics'], $key."/".$k, $prefix);
			}
		else
			foreach($rubrics as $k=>$rubric){
				
				if(empty($prefix))
					$rubrics[$k]['url'] = $k.get_default_path($rubric);
				else 	
					$rubrics[$k]['url'] = $prefix.$k.get_default_path($rubric);					
					
				if(!empty($rubric['subrubrics']))
					create_urls($rubrics[$k]['subrubrics'], $k, $prefix);
			}
	}

	//формирует структуру "хлебных крошек"
	function fill_level($rubrics, &$currents, $level, &$crumbs){
					
		if(!is_array($rubrics) || !is_array($crumbs))
			return false;
			
		foreach ( $rubrics as $k => $l ) {
						
				$crumbs[$level][$k]= array(
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
			корень
		<? else: ?>
			<?=$vars['root']['link']?>
		<? endif; ?>
		</td>
	
	<? $i = count($crumbs); ?>
	<? foreach ( $crumbs as $v ): ?>
	<? $i--; ?>
		<td class="mainmenu<? if ( $i <= 0 ):?> last<? endif; ?>" style="padding-top:4px" valign="top">
			<div class="submenu">
				<table border="0" cellspacing="0" cellpadding="0">
					<? foreach ( $v as $k => $l ): ?>
						<tr>
							<td<? if ( $l['active'] === true ): ?> class="active"<? endif; ?>>
								<a href="<?=$l['url']?>"><?=$l['title']?></a>								
							</td>
						</tr>
						
						<? if ( $l['active'] === true ): ?>
							<? $active = array( 'title' => $l['title'], 'url' => $l['url'] ); ?>
						<? endif; ?>
					
					<? endforeach; ?>
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
