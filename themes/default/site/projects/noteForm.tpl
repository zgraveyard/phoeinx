<div>
{if $showClose eq 1}
	<span style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</span>
{/if}
<div id="sucess" style="display:none;"></div>
<div class="titles">
<img src="{$config.url}/images/icons/add.gif" class="icon" />Add new Note</a></div>
<form id="addForm" name="addForm" action="{$config.url}/{$goto}" method="post">
	<div class="box_container">
	<table border="0" cellpadding="5" cellspacing="0" width="100%" class="table_container3"><tr><td valign="top" width="50px"><label>Note :</label></td>
	<td><textarea rows="10" cols="80%" class="required" name="note" id="note"></textarea></td>
	</tr><tr>
	<td>&nbsp;</td><td>
	<input type="hidden" name="action" value="anote"/>
	<input type="hidden" name="pid" value="{$smarty.get.id}"/>
	<input type="submit" name="sbt" id="sbt" value="Add"/>
	</td></tr></table></div>
</form>
<script>var valid = new Validation('addForm');addNote('{$goto}','addForm');</script>
</div>