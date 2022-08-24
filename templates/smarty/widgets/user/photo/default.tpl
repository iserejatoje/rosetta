{if $res.photo.url}
<div class="user_info_additional">
<div class="image">
<img src="{$res.photo.url}" height="{$res.photo.height}" width="{$res.photo.width}" alt="{$res.showname}" title="{$res.showname}" />
{if $res.isnophoto}
<div><a href="/passport/mypage/person.php">Добавить фото</a></div>
{/if}
</div>
</div>
{/if}