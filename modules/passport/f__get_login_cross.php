<?
  
return array(
	'progress' => round($params[0]['domains_elapsed']/$params[0]['domains_count']*100),
	'redirect_url' => $params[0]['redirect_url'],
	'state' => $params[0]['state'],
	'url' => $params[0]['url'],
	'domains' => $params[0]['domains'],
	'rest_domains' => $params[0]['rest_domains'],
	'cdomain' => $params[0]['cdomain'],
	'sdomain' => $params[0]['sdomain'],
);
?>