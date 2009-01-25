/*
###################################
# Copyright (c) 2008 Mhd Zahere Ghaibeh and others.
# All rights reserved. This program and the accompanying materials
# are made available under the terms of the GNU GPL v2.0
# which accompanies this distribution, and is available at
# http://www.GNU.org
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#
##################################
*/

Event.observe(window,'load',function(){
	new Effect.toggle('loading','slide');
	getWindow();
});

Event.addBehavior({
	'a#add:click':function(e){
		try{
			openME('add');
		}catch(e){
			var errorString = 'An error accured : '+e.toString();
			$('errorMSG').addClassName('error').update(errorString);
			setTimeout('hideMyElement',10);
			$('loading').hide();
		}
		return false;
	},
	'div#modal_container div table tbody tr td a.deleteME:click':function(){
		aresure(this.readAttribute('title'),this.readAttribute('href'),'box_'+this.readAttribute('id'));
		return false;
	}
});

aresure = function(msg , url ,elemID){
	if(confirm(msg)){
		try{
			$('loading').show();
			new Ajax.Request(url, {
				method: 'get',
				onSuccess: function(transport){
					if(transport.responseText == '1') {
						new Effect.Highlight(elemID, {
							duration: 0.5,
							afterFinish: function(effect){
								$(elemID).remove();
								$('loading').hide();
							}
						});
					}
					else {
						$('msg').update('<div>'+transport.responseText+'</div>').addClassName('error');
						new Effect.toggle('msg','slide');
						setTimeout("new Effect.toggle('msg','slide');",5000);
						$('loading').hide();
					}
				}
			});
		}catch(e){
			var errorString = 'An error accured : '+e.toString();
			$('errorMSG').addClassName('error').update(errorString);
			setTimeout('hideMyElement',10);
			$('loading').hide();
		}
	}else{
		return false;
	}
}

getNews = function(divId){
	try{
	new	Ajax.PeriodicalUpdater($(divId),'feed.php?action=getNews',{
		frequency: 3600,
		onSuccess:function(){
			new Effect.Highlight($(divId));
		},
		decay:2
	});

	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}

getWindow = function(elemClass){
	try{
		$$('.myLink').each(
			function(link){
				new Control.Modal(link,{
						fade : true,
						width:800,
						height:600,
						containerClassName:'modal',
						loading:website+'/images/loading.gif',
						ajaxRequest:true,
						requestOptions:{
							postBody :'ajax=1'
						}
					});
			}
		);
	}
	catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

getEmployee = function(url,depID){
	try{
		var updateEmp = $('data');
		var dep = depID.options[depID.selectedIndex].value;
		$('loading').show();
		new Ajax.Request(url,{
			method:'post',
			postBody:'depID='+dep,
			onSuccess:function(transparnt){
				$(updateEmp).update(transparnt.responseText);
				new Effect.Appear($(updateEmp));
				new Effect.Highlight($(updateEmp));
				$('loading').hide();
//				changeColor();
			}
		});
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}

editMe = function(elID,url){
	try {
		new Ajax.InPlaceEditor('editMe_'+elID,url,
			{
				okText:'Edit',
				highlightcolor:'#FF3300',
				loadingText:'Just Wait Loading ...',
				cols:50,
				onFailure:function(transport){
					alert('Error communicating with the server: ' + transport.responseText.stripTags());
				}
			});
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}

openME = function(elmID){
	try{
		var myLink = $(elmID);
		myLink.observe('click',function(e){
			Event.stop(e);
			var elmForm = $(elmID+'MeForm');
			elmForm.show();
			var myNote = $('note');
			var text = "[ <a href=\"javascript:void(0);\" class=\"aLink\" onclick=\"closeMe('addMeForm');\" title=\"Close\">Close</a> ]";
			myNote.show().update(text);
		});
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}


hideMyElement = function(){
	new Effect.Fade('errorMSG', { transition: Effect.Transitions.sinoidal });
}


closeMe = function(elmID){
	try{
		$('note').hide();
		$(elmID).hide();
		return false;
	}
	catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
	}
}

addPos = function(){
	try{
		var formId = $('addForm');
		var url = formId.readAttribute('action');
		formId.observe('submit',function(e){
			Event.stop(e);
			var title = $('addForm').serialize();
			$('loading').show();
			if(!$F('title').blank()){
				$('sbt').value = 'Adding data ...';
				$('sbt').disable();
				new Ajax.Request(url,
					{
						postBody: title+'&ajax=1',
						onSuccess:function(transport){
							$('title').clear();
							$('title').focus();
							$('sbt').enable();
							$('sbt').value = 'add';
							$('update').update(transport.responseText);
							var elmId = $$('.box').last().readAttribute('id');
							new Effect.Highlight($(elmId));
							$('loading').hide();
						},
						onFailure:function(transport){
							alert('Error communicating with the server: ' + transport.responseText.stripTags());
							$('loading').hide();
						}
					}
				);
			}
			$('loading').hide();
		});
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
		$('loading').hide();
	}
}

addNote = function(url , form){
	try{
		var formId = $(form);
		formId.observe('submit',function(e){
			Event.stop(e);

			var title = formId.serialize();

			$('loading').show();
			if(!$F('note').balnk()){
				$('sbt').value = 'Adding data ...';
				$('sbt').disable();
				new Ajax.Request(url,
					{
						postBody: title+'&ajax=1',
						onComplete:function(transport){
							$('note').clear();
							$('sbt').enable();
							$('sbt').value = 'add';
							$('sucess').show();
							$('sucess').update('The note Has Been Added Successfully').addClassName('right');
							new Effect.Highlight('sucess');
							$('loading').hide();
						},
						onFailure:function(transport){
							alert('Error communicating with the server: ' + transport.responseText.stripTags());
							$('loading').hide();
						}
					}
				);
			}
			$('loading').hide();
		});
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
		$('loading').hide();
	}
}

addRelation = function(url , form){
	try{
		var formId = $(form);
		formId.observe('submit',function(e){
			Event.stop(e);
			var title = formId.serialize();
			var noteValue = $F('selection');
			$('loading').show();
			$('sbt').value = 'Adding data ...';
			$('sbt').disable();
			var getData = $('selection').descendants();
			getData.each(
				function(e){
					if (e.value == noteValue ){
						e.remove();
					};
				}
			);
			new Ajax.Request(url,
				{
					postBody: title+'&ajax=1',
					onComplete:function(transport){
						$('sbt').enable();
						$('sbt').value = 'add';
						$('sucess').show();
						$('sucess').update('The Relationship Has Been Added Successfully').addClassName('right');
						new Effect.Highlight('sucess');
						$('loading').hide();
					},
					onFailure:function(transport){
						$('sucess').show();
						$('sucess').update('Error communicating with the server: ' + transport.responseText.stripTags()).addClassName('error');
						$('loading').hide();
					}
				}
				);
		});
		$('loading').hide();
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
		$('loading').hide();
	}
}

checkValue = function(firstVal , secondVal , formID){
	try{
		$(formID).observe('submit',function(e){
			var sVal =  $(secondVal).value;
			var fVal = $(firstVal).value;
			if( fVal >= sVal ){
				Event.stop(e);
				new Effect.Highlight($(firstVal+'_div'),{
					afterFinish:function(obj){
						$(firstVal).setStyle({border:'1px solid #FF0033'});
					}
				});
				new Effect.Highlight($(secondVal+'_div'),{
					afterFinish:function(obj){
						$(secondVal).setStyle({border:'1px solid #FF0033'});
					}
				});
			}
		});
		$('loading').hide();
	}catch(e){
		var errorString = 'An error accured : '+e.toString();
		$('errorMSG').addClassName('error').update(errorString);
		setTimeout('hideMyElement',10);
		$('loading').hide();
	}
}
