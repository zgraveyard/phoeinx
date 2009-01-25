<table border=0 width="100%" cellspacing="10"><tr>
{section name=rss loop=$rss}
<td valign="top" width="50%" class="{if $smarty.section.rss.index %2 eq 0}table_container{else}table_container2{/if}">
<div style="display:table-cell;width:100%;">
	<div class="note" {if !ereg('[a-zA-Z]',$rss[rss].title) }style="direction:rtl;text-align:right; padding:5px;"{/if}>
		<img src="{$config.url}/images/icons/feed.gif" align="absmiddle" class="icon" />&nbsp;{$rss[rss].title}</div>
	{section name=itm loop=$rss[rss].item}
	<div  class="inews" {if !ereg('[a-zA-Z]',$rss[rss].item[itm].title) }style="direction:rtl; text-align:right;"{/if}>
	<span class="time" {if !ereg('[a-zA-Z]',$rss[rss].item[itm].title) }style="float:left;"{/if}>
		<img src="images/icons/time.gif" alt="{$rss[rss].item[itm].date_timestamp|date_format:"%A, %B %e, %Y"}" class="icon" />
	</span>
		<a href="{$rss[rss].item[itm].link}" target="_blank" title="{$rss[rss].item[itm].title}">{$rss[rss].item[itm].title}</a>
		<blockquote>{$rss[rss].item[itm].description_content|default:$rss[rss].item[itm].description}</blockquote>
	</div>
	{/section}
</div></td>
{if $smarty.section.rss.index %2 eq 1}</tr><tr>{/if}
{sectionelse}
<blockquote>Sorry we couldnt get any news , are you sure your connected to the internet ?!</blockquote>
{/section}
</tr></table>
