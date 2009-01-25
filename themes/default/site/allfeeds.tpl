<table cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%">Id</td>
		<td >Web site</td>
		<td align="center" width="10%">Delete</td>
	</tr>
{section name=ty loop=$feeds}
	<tr class="{cycle values="odd,even"} box " id="pos_{$feeds[ty].id}">
		<td align="center">{$feeds[ty].id}</td>
		<td align="left">{$feeds[ty].title}</td>
		<td align="center">
			<a href="javascript:void(0)" onclick="return aresure('Are you Sure?!','{$config.url}/feed.php?action=del&amp;id={$feeds[ty].id}','pos_{$feeds[ty].id}');return false;">
				<img src="{$config.url}/images/icons/delete.gif" class="icon" alt="delete {$types[ty].url}"/>
			</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Feeds in the database yet..</div>
		</td>
	</tr>
{/section}
</table>