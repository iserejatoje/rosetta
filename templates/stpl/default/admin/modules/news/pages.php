<nav>
  <ul class="pagination">
  	<? if (!empty($vars['pages']['back'])) { ?>
	    <li>
	      <a href="<?=$vars['pages']['back']?>" aria-label="Previous">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
	    </li>
    <? } ?>

    <? foreach ($vars['pages']['btn'] as $l) { ?>
		<? if (!$l['active']) { ?>
			<li>
				<a href="<?=$l['link']?>"><?=$l['text']?></a>
			</li>
	    <? } else { ?>
	    	<li class="active">
	    		<a href="<?=$l['link']?>"><?=$l['text']?></a>
	    	</li>
	    <? } ?>
    <? } ?>

    <? if (!empty($vars['pages']['next'])) { ?>
	    <li>
	      <a href="<?=$vars['pages']['next']?>" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
    <? } ?>
  </ul>
</nav>