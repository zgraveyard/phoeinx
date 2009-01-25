<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%" >Id</td>
		<td >Work Field Title</td>
		<td align="center" width="10%" >Delete</td>
	</tr>
{section name=area loop=$work}	
	<tr class="{cycle values="odd,even"}" id="work_{$work[area].id}">
		<td align="center">{$work[area].id}</td>
		<td align="left">
			<div id="editMe_{$work[area].id}">{$work[area].work_type}</div>
		<script type="text/javascript">editMe({$work[area].id},'{$config.url}/module.php?act=load&modload=clients&file=work&action=save&id={$work[area].id}');</script>	
		</td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=clients&amp;file=work&amp;action=delete&amp;id={$work[area].id}" 
			onclick="return confirm('Are you sure ?\nThis action cant be undo.');">
				<img src="{$config.url}/images/icons/delete.gif" class="icon" alt="delete {$work[area].work_type}"/>
			</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Work Fields in the database yet..</div>
		</td>
	</tr>
{/section}
</table>