<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%"><div align="center">Id</div></td>
		<td>Project Type</td>
		<td align="center" width="10%"><div align="center">Delete</div></td>
	</tr>
{section name=ty loop=$types}	
	<tr class="{cycle values="odd,even"} box " id="pos_{$types[ty].id}">
		<td align="center">{$types[ty].id}</td>
		<td align="left">
			<div id="editMe_{$types[ty].id}">{$types[ty].name}</div>
		<script type="text/javascript">editMe({$types[ty].id},'{$config.url}/module.php?act=load&modload=projects&file=types&action=save&id={$types[ty].id}');</script>		</td>
		<td align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=projects&amp;file=types&amp;action=delete&amp;id={$types[ty].id}" 
			onclick="return confirm('Are you sure ?\nThis action cant be undo.');">
				<img src="{$config.url}/images/icons/table_delete.gif" class="icon" alt="delete {$types[ty].name}"/>			</a>		</td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Projects Types in the database yet..</div>		</td>
	</tr>
{/section}
</table>
