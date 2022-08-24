<?
exit;
Response::NoCache();


	$this->_config['blocks']['left'] = array();
	$this->_config['blocks']['right'] = array();
	$this->_config['blocks']['header'] = array();
	$this->_config['blocks']['footer'] = array();

if ( App::$Request->Get['SID']->AlNum(false) !== false ) {

	if (!$OBJECTS['user']->IsAuth())
		$OBJECTS['usersMgr']->SetSession(App::$Request->Get['SID'], (bool) App::$Request->Get['remember']);

	$url = App::$Request->Get['url']->Url(false,false);
	if (strlen(App::$Request->Get['d']) && false !== ($domains = base64_decode(urldecode(App::$Request->Get['d'])))) {

		$domains = explode(',',$domains);
		$domain = array_shift($domains);

		if ( sizeof($domains) > 0 ) {
		
			$params = array(
					'redirect_url' => '',
					'state'	=> 'login',
					'url'	=> App::$Request->Get['url']->Url('',false),
					'domains' => $this->_config['login_cross_domains'][$this->_env['regid']],
					'rest_domains' => array_merge(array($domain), array_slice($domains,0, sizeof($domains)-1)),
					'cdomain' => $this->_env['site']['domain'],
					'sdomain' => $domains[sizeof($domains)-1],
			);


			$params['domains_count'] = App::$Request->Get['c']->Int(0, Request::UNSIGNED_NUM) + 1;
			$params['domains_elapsed'] = abs($params['domains_count'] - sizeof($domains));

			$query = array(
    			'SID'	=> App::$Request->Get['SID']->Value(),
    			'd'		=> base64_encode(implode(',',$domains)),
    			'c'		=> $params['domains_count'],
    			'url'	=> App::$Request->Get['url']->Url(''),
    			'remember' => (int) App::$Request->Get['remember']
		    );

		    $params['redirect_url'] = $domain.'/'.$this->_env['section'].'/';
		    $params['redirect_url'] .= $this->_config['files']['get']['login_cross']['string'];
		    $params['redirect_url'] .= '?'.DATA::build_query_string($query,array(),false);

			$this->_config['templates']['index'] = $this->_config['templates']['index_simple'];

			$OBJECTS['title']->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
			$OBJECTS['title']->AppendBefore('Вход');

			echo $this->RenderBlock(
				$this->_config['templates']['ssections']['login_cross'],
				array($params),
				array($this, '_get_login_cross'));
			exit;
		} else if ( !sizeof($domains) && $domain ) {

			if( $url !== false ) {
				$purl = parse_url($url);
				if ( $purl['host'] )
					Response::Redirect( $url );
				else
					Response::Redirect( $domain.'/'.ltrim($url,'/') );
			} else
				Response::Redirect($domain.'/'.$this->_env['section'].'/'.$this->_config['files']['get']['mypage']['string']);
		}
	}

	if( $url !== false )
		Response::Redirect( $url );
	else
		$this->redirect_authorized();
}
exit;
?>