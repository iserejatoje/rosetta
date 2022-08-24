<?php

class SphinxPlugin_Video_PlayList extends SphinxPluginTrait {

	protected $_type = Sphinx::PT_NAMED;

	protected $_rules = array(
		'source' => array(
			'video_playlist' => array(

				'type'		=> 'xmlpipe2',
				'xmlpipe_command' => '',
				'xmlpipe_fixup_utf8' => 1,
			),
		),


		'index' => array(
			'video_playlist' => array(
				'source'		=> 'video_playlist',
				'path'			=> '%VAR_DIR%/video/playlist',
				'docinfo'			=> 'extern',
				'mlock'				=> 0,
				'morphology'		=> 'stem_en, stem_ru',
				'wordforms'			=> '%CONF_DIR%/wordforms.txt',
				'min_word_len'		=> 2,
				'charset_type'		=> 'utf-8',
				'ignore_chars'		=> 'U+00AD',
				'min_prefix_len'	=> 2,
				'enable_star'		=> 1,
				'phrase_boundary'	=> '., ?, !, U+2026',
				'html_strip'		=> 0,
				'html_index_attrs'	=> 'img=alt,title; a=title;',
				'min_stemming_len'	=> 4,
			),
		),
	);

	function __construct()
	{
		parent::__construct();

		$this->_rules['source']['video_playlist']['xmlpipe_command'] = ENGINE_PATH . 'shell.sh action=sphinx/source/video:playlist';
	}
}
