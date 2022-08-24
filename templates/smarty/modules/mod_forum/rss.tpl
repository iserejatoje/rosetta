<?xml version="1.0"?>
<rss version="2.0">
	<channel> 
		<title><![CDATA[{$rss.title}]]></title>
		<link>{$rss.link}</link>
		<description><![CDATA[{$rss.description}]]></description>
		<pubDate>{$rss.nowdate}</pubDate>
		<lastBuildDate>{$rss.lastdate}</lastBuildDate>
{foreach from=$rss.items item=l}
		<item>
			<title><![CDATA[{$l.title}]]></title>
	        <link><![CDATA[{$l.link}]]></link>
	        <description><![CDATA[{$l.message}]]></description>
	        <pubDate>{$l.date}</pubDate>
	        <guid><![CDATA[{$l.guid}]]></guid>
		</item>
{/foreach}
	</channel>
</rss>