{head}{literal}<script>Event.observe(window,'load',function(){ addPos(); openME('add'); });</script>{/literal}{/head}

<div class="titles">
		<img src="{$config.url}/images/icons/group.gif" align="left" class="icon" alt="Projects Types"/>
		&nbsp;Projects Types
</div>
<div class="right">
	<a href="javascript:void(0);" id="add" class="aLink" >
		<img src="{$config.url}/images/icons/add.gif" class="icon" />Add new Type</a>&nbsp;<span id="note"></span>
	<div id="addMeForm" style="display:none;">
	<form id="addForm" name="addForm" action="{$config.url}/module.php?act=load&modload=projects&file=types" method="post">
		<label for="Position Title">Project Type Title <input type="text" size="50" class="required" maxlength="255" name="title" id="title" /></label>
		<input type="hidden" name="action" value="add"/>
		<input type="submit" name="sbt" id="sbt" value="Add"/>
	</form>
	<script>var valid = new Validation('addForm');</script>
	</div>
</div>
{if $smarty.get.done eq '1'}
<div class="right">
	<img src="{$config.url}/images/icons/accept.gif" class="icon" align="left" alt="Your request has been performed successfully"/>
	&nbsp;Your request has been performed successfully . </div>
{elseif $smarty.get.error eq '1'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;An error accrued while we were trying to perform your request , please try again later .. </div>
{elseif $smarty.get.error eq '2'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You didnt specify a record to delete , please try again .. </div>
{elseif $smarty.get.error eq '3'}
<div class="error">
	<img src="{$config.url}/images/icons/exclamation.gif" align="left" class="icon" alt="An error accrued .."/>
	&nbsp;You cant delete this type because there is Projects belongs to it.. </div>
{/if}
<div id="update">
{include file='site/projects/alltypes.tpl'}
</div>