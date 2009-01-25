<table border="0" cellpadding="2" cellspacing="0" class="list_container">
	<tr class="tblHeader">
		<td align="center" width="5%" ><div align="center">Id</div></td>
		<td >Position Title</td>
		<td align="center" width="10%" ><div align="center">Delete</div></td>
	</tr>
{section name=pos loop=$positions}
	<tr class="{cycle values="odd,even"} box " id="pos_{$positions[pos].id}">
		<td align="center">{$positions[pos].id}</td>
		<td align="left">
			<div id="editMe_{$positions[pos].id}">{$positions[pos].name}</div>
		<script type="text/javascript">editMe({$positions[pos].id},'{$config.url}/module.php?act=load&modload=employees&file=position&action=save&id={$positions[pos].id}');</script>		</td>
		<td align="center">
			<div align="center">
			<a href="{$config.url}/module.php?act=load&amp;modload=employees&amp;file=position&amp;action=delete&amp;id={$positions[pos].id}"
				onclick="return confirm('Are you sure ?\nDeleting the position will delete all his related information.\nThis action cant be undo.');">
			  <img src="{$config.url}/images/icons/table_delete.gif" class="icon" alt="delete {$positions[pos].name}"/>
	    </a>	        </div></td>
	</tr>
{sectionelse}
	<tr>
		<td colspan="6">
			<div class="error">Sorry There is no Positions in the database yet..</div>		</td>
	</tr>
{/section}
</table>
