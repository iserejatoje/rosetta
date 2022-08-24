<?
	
	Response::Status(301);
	Response::Redirect("/".$this->_env['section']."/");