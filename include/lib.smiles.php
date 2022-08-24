<?php

class Smiles
{
	static $config = array(			
			'max_smiles' => 20,			
			'smiles_path' => '/_img/modules/passport/im/smiles/',
			// регэксп, чтобы каждый раз не генерить
			'smileregexp' => '@(\:\)|\:\(|\:bad\:|\:tongue\:|\:wink\:|\:air_kiss\:|\:cray\:|\:crazy\:|\:good\:|\:lol\:|\:shok\:|\:blush2\:|\:agree\:|\:alcoholic\:|\:black_eye\:|\:boom\:|\:bravo\:|\:dance\:|\:first_move\:|\:flirt\:|\:fool\:|\:girl_cray\:|\:girl_devil\:|\:girl_haha\:|\:girl_sigh\:|\:give_rose\:|\:help\:|\:hysterics\:|\:king\:|\:kiss\:|\:lazy\:|\:mosking\:|\:music\:|\:new_russian\:|\:not_i\:|\:pardon\:|\:pilot\:|\:pleasantry\:|\:queen\:|\:secret\:|\:stop\:|\:suicide\:|\:superstition\:|\:yess\:|\:thank_you\:|\:tomato\:|\:yes\:|\:umnik\:|\:victory\:|\:xaxa\:)@',
			// сопоставление имени и картинки
			'smilesconv' => array(
				':)' => 'smile.gif', ':(' => 'sad.gif', ':bad:' => 'bad.gif', ':tongue:' => 'tongue.gif', ':wink:' => 'wink.gif',
				':air_kiss:' => 'air_kiss.gif', ':cray:' => 'cray.gif', ':crazy:' => 'crazy.gif', ':good:' => 'good.gif', ':lol:' => 'lol.gif',
				':shok:' => 'shok.gif', ':blush2:' => 'blush2.gif', ':agree:' => 'agree.gif', ':alcoholic:' => 'alcoholic.gif', ':black_eye:' => 'black_eye.gif',
				':boom:' => 'BooM.gif', ':bravo:' => 'bravo.gif', ':dance:' => 'dance4.gif', ':first_move:' => 'first_move.gif', ':flirt:' => 'flirt.gif',
				':fool:' => 'fool.gif', ':girl_cray:' => 'girl_cray2.gif', ':girl_devil:' => 'girl_devil.gif', ':girl_haha:' => 'girl_haha.gif', ':girl_sigh:' => 'girl_sigh.gif',
				':give_rose:' => 'give_rose.gif', ':help:' => 'help.gif', ':hysterics:' => 'hysterics.gif', ':king:' => 'king.gif', ':kiss:' => 'kiss.gif',
				':lazy:' => 'lazy.gif', ':mosking:' => 'mosking.gif', ':music:' => 'music.gif', ':new_russian:' => 'new_russian.gif', ':not_i:' => 'not_i.gif',
				':pardon:' => 'pardon.gif', ':pilot:' => 'pilot.gif', ':pleasantry:' => 'pleasantry.gif', ':queen:' => 'queen.gif', ':secret:' => 'secret.gif',
				':stop:' => 'stop.gif', ':suicide:' => 'suicide.gif', ':superstition:' => 'superstition.gif', ':yess:' => 'yess.gif', ':thank_you:' => 'thank_you.gif',
				':tomato:' => 'tomato.gif', ':yes:' => 'yes.gif', ':umnik:' => 'umnik.gif', ':victory:' => 'victory.gif', ':xaxa:' => 'XaXa.gif'
				),
			'smilesex' => array(
				':)' => 'smile.gif', ':(' => 'sad.gif', ':bad:' => 'bad.gif', ':tongue:' => 'tongue.gif', ':wink:' => 'wink.gif',
				':air_kiss:' => 'air_kiss.gif', ':cray:' => 'cray.gif', ':crazy:' => 'crazy.gif', ':good:' => 'good.gif', ':lol:' => 'lol.gif',
				':shok:' => 'shok.gif', ':blush2:' => 'blush2.gif', ':agree:' => 'agree.gif', ':alcoholic:' => 'alcoholic.gif', ':black_eye:' => 'black_eye.gif',
				':boom:' => 'BooM.gif', ':bravo:' => 'bravo.gif', ':dance:' => 'dance4.gif', ':first_move:' => 'first_move.gif', ':flirt:' => 'flirt.gif',
				':fool:' => 'fool.gif', ':girl_cray:' => 'girl_cray2.gif', ':girl_devil:' => 'girl_devil.gif', ':girl_haha:' => 'girl_haha.gif', ':girl_sigh:' => 'girl_sigh.gif',
				':give_rose:' => 'give_rose.gif', ':help:' => 'help.gif', ':hysterics:' => 'hysterics.gif', ':king:' => 'king.gif', ':kiss:' => 'kiss.gif',
				':lazy:' => 'lazy.gif', ':mosking:' => 'mosking.gif', ':music:' => 'music.gif', ':new_russian:' => 'new_russian.gif', ':not_i:' => 'not_i.gif',
				':pardon:' => 'pardon.gif', ':pilot:' => 'pilot.gif', ':pleasantry:' => 'pleasantry.gif', ':queen:' => 'queen.gif', ':secret:' => 'secret.gif',
				':stop:' => 'stop.gif', ':suicide:' => 'suicide.gif', ':superstition:' => 'superstition.gif', ':yess:' => 'yess.gif', ':thank_you:' => 'thank_you.gif',
				':tomato:' => 'tomato.gif', ':yes:' => 'yes.gif', ':umnik:' => 'umnik.gif', ':victory:' => 'victory.gif', ':xaxa:' => 'XaXa.gif'
				),
				
			'regexp_old' => '@(\:\)|\:\(|\:angel\:|\:phi\:|\:wink\:|\:lol\:|\:vvp\:|\:cry\:|\:stupid\:|\:fu\:|\:joking\:|\:devil\:|\:happy\:|\:vomit\:|\:nunu\:|\:ups\:|\:drink\:|\:kiss1\:|\:kiss2\:|\:bubble\:|\:umnik\:|\:abuse\:|\:agree\:|\:haha\:|\:biggrin\:|\:yes\:|\:no\:|\:bye\:|\:dn\:|\:up\:|\:helloween\:|\:hb\:|\:drug\:|\:pb\:|\:punch\:|\:rupor\:|\:scull\:|\:shuffle\:|\:smoker\:|\:hz\:)@',
			
		'conv_old' => array(
			':angel:' => 'new/aa.gif', ':phi:' => 'new/ae.gif',
			':)' => 'new/ab.gif', ':(' => 'new/ac.gif', ':wink:' => 'new/ad.gif',
			':lol:' => 'new/ag.gif', ':vvp:' => 'new/ai.gif', ':cry:' => 'new/ak.gif',
			':stupid:' => 'new/an.gif', ':fu:' => 'new/ao.gif', ':joking:' => 'new/ap.gif',
			':devil:' => 'new/aq.gif', ':happy:' => 'new/ar.gif', ':vomit:' => 'new/at.gif',
			':nunu:' => 'new/bd.gif', ':ups:' => 'new/bh.gif', ':drink:' => 'new/az.gif',
			':kiss1:' => 'new/aj.gif', ':kiss2:' => 'new/aw.gif', ':bubble:' => 'new/af.gif',
			':umnik:' => 'umnik.gif', ':abuse:' => 'abuse.gif', ':agree:' => 'agree.gif',
			':haha:' => 'haha.gif', ':biggrin:' => 'biggrin.gif', ':yes:' => 'yes.gif',
			':no:' => 'no.gif', ':bye:' => 'bye.gif', ':dn:' => 'dn.gif', ':up:' => 'up.gif',
			':helloween:' => 'helloween.gif', ':hb:' => 'hb.gif', ':drug:' => 'drug.gif',
			':pb:' => 'pb.gif', ':punch:' => 'punch.gif', ':rupor:' => 'rupor.gif',
			':scull:' => 'scull.gif', ':shuffle:' => 'shuffle.gif', ':smoker:' => 'smoker.gif',
			':hz:' => 'hz.gif'
		  ),
		  
		  'old_to_new' => array(
			':angel:' => ':)', 
			':phi:' => '',
			':)' => ':)', 
			':(' => ':(', 
			':wink:' => ':wink:',
			':lol:' => ':lol:',
			':vvp:' => '',			
			':cry:' => ':cray:',
			':stupid:' => ':fool:', 
			':fu:' => '', 
			':joking:' => ':king:',
			':devil:' => '',			
			':happy:' => ':)',		
			':vomit:' => '',
			':nunu:' => '', 
			':ups:' => '', 
			':drink:' => '',			
			':kiss1:' => ':kiss:',
			':kiss2:' => ':kiss:',			
			':umnik:' => ':umnik:', 	
			':bubble:' => '',			
			':agree:' => ':agree:',
			':abuse:' => '', 
			':haha:' => ':xaxa:', 
			':yes:' => ':yes:',		
			':biggrin:' => '',		
			':no:' => '', 
			':bye:' => '', 
			':dn:' => '', 
			':up:' => '',
			':helloween:' => '', 
			':hb:' => '', 
			':drug:' => '',
			':pb:' => '', 
			':punch:' => '', 
			':rupor:' => '',
			':scull:' => '', 
			':shuffle:' => '', 
			':smoker:' => '',
			':hz:' => '',
		  ),
	);

	static function Convert($source)
	{
		// вставка смайлов
		//$text = str_replace($smiles['from'], $smiles['to'], $text);
						
		$start = "<img src=\"";
		$end = "\">";
		$path = self::$config['smiles_path'];
		$smiles = self::$config['smilesconv'];
		$regexp = self::$config['smileregexp'];
		$limit = self::$config['max_smiles'];
		
		if($limit != 0)
		{
			$source = preg_replace($regexp.'e', "\$start.\$path.\$smiles['\\1'].\$end", $source, $limit);
			$source = preg_replace($regexp, "", $source);
		}
		else
			$source = preg_replace($regexp.'e', "\$start.\$path.\$smiles['\\1'].\$end", $source);
		
		return $source;
	}
	
	static function FromOldToNew($source)
	{		
		$smiles = self::$config['old_to_new'];
		$regexp = self::$config['regexp_old'];
		
		//$source = preg_replace($regexp.'e', "\$smiles['\\1']", $source);
		
		foreach(self::$config['old_to_new'] as $k => $v ){
			$source = str_replace($k, $v, $source);
		}
				
		return $source;
	}
	
	static function StripSmiles( $str ){
	
		return preg_replace("@:[a-z]+:@", "", $str);
	}	
}

?>