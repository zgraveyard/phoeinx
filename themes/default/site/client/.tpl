{head}{literal}<style type="text/css" media="screen">.inplaceeditor-saving { background: url(../images/loading.gif) bottom right no-repeat; }</style><script type="text/javascript">Event.observe(window,'load',changeColor);</script>{/literal}{/head}
<div class="tblHeader titles">
	<h1>
		<img src="{$config.url}/images/icons/group.gif" align="left" class="icon" alt="Employees"/>
		&nbsp;Employees Positions
	</h1>
</div>
<div class="right">
	<a href="javascript:void(0);" onclick="openME('add');" class="aLink" >
		<img src="{$config.url}/images/icons/add.gif" class="icon" />Add new position</a>&nbsp;<span id="note"></span>
	<div id="add" style="display:none;">
	<form id="addForm" name="addForm" action="{$config.url}/module.php?act=load&modload=employees&file=position" method="post">
		<label for="Position Title">Position Title <input type="text" size="50" class="required" maxlength="255" name="title" id="title" /></label>
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
	&nbsp;You cant delete this position because there is employees belongs to it.. </div>
{/if}
<p>&nbsp;</p>
<div id="update">
{include file='site/emp/allpositions.tpl'}
</div>
{head}<script>{literal}Event.observe(window,'load',function(){
addPos('module.php?act=load&modload=employees&file=position');});{/literal}</script>
{/head}