<div>
{if $showClose eq 1}
	<span style="float:right;">
		<a href="javascript:Control.Modal.close()" title="Close">
			<img src="{$config.url}/images/icons/cross.gif" class="icon" alt="Close"/>
		</a>
	</span>
{/if}
<div id="sucess" style="display:none;"></div>
<img src="{$config.url}/images/icons/add.gif" class="icon" />Add Relations</a>
<form id="addForm" name="addForm" action="{$config.url}/{$goto}" method="post">
<div class="box_container">
<table border="0" cellpadding="5" cellspacing="0" width="100%" class="table_container3">
	<tr>
		<td valign="top" width="150px"><label>Task Name :</label></td>
		<td>
			{html_options options=$tasks name="note" id="selection"}
		</td>
	</tr>
	<tr>
		<td valign="top"><label>Relation Type :</label></td>
		<td>
			{html_options options=$relations name="relation"}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>
		<input type="hidden" name="action" value="arelation"/>
		<input type="hidden" name="tid" value="{$smarty.get.id}"/>
		<input type="hidden" name="project" value="{$projectId}" />
		<input type="submit" name="sbt" id="sbt" value="Add"/>
		</td>
	</tr>
</table></div>
</form>
<script>addRelation('{$goto}','addForm');</script>
</div>