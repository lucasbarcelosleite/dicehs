isOpera = (navigator.userAgent.toLowerCase().indexOf('opera')>-1);
isKonqueror = (navigator.userAgent.toLowerCase().indexOf('konqueror')>-1);
isIE  = ((!isOpera)&&(navigator.userAgent.toLowerCase().indexOf('msie')>-1));
isIE7 = ((!isOpera)&&(navigator.userAgent.toLowerCase().indexOf('msie 7')>-1));
isIE6 = ((isIE)&&(!isIE7)); 
isMozilla = ((!isOpera)&&(!isKonqueror)&&(!isIE));

//var intervalCampo = undefined;

wbotoes = {};
wbotoes.disabled = false;

function loading(visivel){
    wbotoes.disabled = visivel;
	if (visivel) {
		$("#loading").css("display", "block");
	} else {
		$("#loading").css("display", "none");
	}
}

$(document).ready(function() {
	
    var htmlRemoveLang = $("#dialog-remove-idiomas").html();
   
	$(".multi-relacional .bt-adicionar").click(function(){
		var table = $(this).parent().parent().parent().parent();
		table.find(".cb_multi_origem option:selected").each(function (){
			table.find(".cb_multi_destino").append($(this).clone());
			table.find(".hidden-multi").append("<input type='hidden' name='"+table.attr("id")+"[]' value='"+$(this).val()+"' />");
			$(this).hide();
			$(this).attr("selected",false);
		});
	});
	
	$(".multi-relacional .bt-remover").click(function(){
		var table = $(this).parent().parent().parent();
		table.find(".cb_multi_destino option:selected").each(function (){
			table.find(".cb_multi_origem option[value="+$(this).val()+"]").show();
			$(this).remove();
			table.find(".hidden-multi input[value="+$(this).val()+"]").remove();
		});
	});
	
	$(".cb_multi_destino option").each(function (){
		var table = $(this).parent().parent().parent().parent().parent();
		//table.find(".hidden-multi").append("<input type='hidden' name='"+table.attr("id")+"[]' value='"+$(this).val()+"' />");
		$(this).append("<input type='hidden' name='"+table.attr("id")+"[]' value='"+$(this).val()+"' />");
		table.find(".cb_multi_origem option[value="+$(this).val()+"]").hide();
	});
	
	$(".multi-relacional .bt-cima").click(function(){
		var table = $(this).parent().parent().parent();
		table.find(".cb_multi_destino option:selected").each(function (){
			$(this).prev().before($(this));
		});
	});
	
	$(".multi-relacional .bt-baixo").click(function(){
		var table = $(this).parent().parent().parent();
		table.find(".cb_multi_destino option:selected").each(function (){
			$(this).next().after($(this));
		});
	});
	
	$("#bt-search").click(function() {
		$('input[name*=cp_wordem]').attr('disabled', 'disabled');
		$('input[name*=cp_ord]').attr('disabled', 'disabled');
		$("#adminFormList").submit();
	});
	
	$("#bt-search-clear").click(function() {
		$("#search").val('');
		$("#bt-search").click();
	});
	
	$("#adminForm").submit(function(){ 
	    $(".editor-area").each(function (){
	        var editorName = $(this).attr("name");
	        eval("CKEDITOR.instances."+editorName+".updateElement();");
	    });

	   /*for(k in jsEditorArea) eval(jsEditorArea[k]);*/
		return false; 
	});
	
	$("#adminForm").ajaxForm({
		success: function (responseText, statusText) {
			eval(responseText);
		}
	});
	
	$("#not-return-main").click(function(){
		var href = $(this).val().split("@");
		document.location.href = href[(($(this).attr("checked"))?1:0)];
	});
		
    $(".input-ordering").each(function(){
		if($(this).attr("lang")==""){
            
            $(this).keypress(function(e){
                if(e.keyCode==13){
                    var aux = $("#task").val();
                    $("#task").val("ordem");
					$("form").submit();
                    $("#task").val(aux);
                }
            });
            $(this).attr("lang","temEvento");
        }
    });
    
	// toolbar
	$(".toolbar").click(function(){
		
		if (wbotoes.disabled) return false;
		
		var task = $(this).children().attr('name');
		var checkSelected = ($(this).find('.check-selected').attr('class') != undefined);
		var formSubmit = ($(this).find('.form-submit').attr('class') != undefined);
		
		if (task != 'ordem') {
			$('input[name*=cp_wordem]').attr('disabled', 'disabled');
			$('input[name*=cp_ord]').attr('disabled', 'disabled');
		}
		
		if (checkSelected) {
			var totalSelected = false;
			$('input[name*=cid]').each(function () {
				if ($(this).attr('checked')) {
					totalSelected = true;
					return false;
				}
			});
			
			if (!totalSelected) {
				alert("É necessário selecionar algum registro para executar essa operação.");
				return false;	
			}
		}

		if (task == 'ordem') {
			$("form").attr('method', 'post');
			$('input[name*=cid]').attr('checked', 'checked');
		}
		
		$("#task").val(task);
		
		if (formSubmit) {
			loading(true);
         	$("form").submit();
         	$("form").ajaxComplete(function(){
	            loading(false);
	        });
			return false;	
		}
		
		if (task.substr(0, 4) == 'flag') {
			var param = task.substr(5, task.length-6);
			var vParam = param.split('=');
			
			$("#task").val('flag');
			$("#adminFormList").append('<input type="hidden" name="campo" value="'+vParam[0]+'" />');
			$("#adminFormList").append('<input type="hidden" name="valor" value="'+vParam[1]+'" />');
			$("#adminFormList").submit();
			
			return false;
		}		
		if (task == 'remove') {
			if (window.confirm("Deseja excluir o(s) registro(s) selecionado(s)?")) {
				$("form").submit();
			}
			return false;
		}
		return true;
	});
	
	if ($("#id_estado") && $("#id_cidade")) {
       $("#id_estado").change(function(){
           mostraCidades($("#id_estado").val());
       });
    }
	
	/* Autocomplete */
	
	if ($(".autocomplete-input").result) {
    	$(".autocomplete-input").result(autoCompleteCallback).next().click(function() {
    		$(this).prev().search();
    	});    
	}

	$(".autocomplete-remover").live("click", function() {
	    $(this).parent().remove();
	});
	
	$(".autocomplete-salvar").live("click", function() {
	    if (!$(this).prev().val()) {
	        alert("Preencha o campo ao lado para salvar.");
	    } else {
	        var inputId = $(this).prev().attr("id");
	        var ulId = $(this).parents("td").find("ul").attr("id");
	        
    	    $.post($(this).attr("href"), { tag: $(this).prev().val() }, function(retorno) {
    	        
    	        if (retorno.indexOf("|") >= 0) {
        	        var tag = retorno.split("|");
                    var htmlBox = autoCompleteBox(inputId.replace("-input", ""), tag[1], tag[0]);
                    
                    $("#"+inputId).val("");
                    
                    $("<li>").html(htmlBox).appendTo("#"+ulId);
    	        } else {
    	            alert(retorno);
    	        }
            });
	    }
	    return false;
	});
	
	$(".clear-form").click(function () {
		$(this).parents("form").clearForm();
	});
	
	//EXTERNAL
    $(".external").live("click", function(){
        window.open($(this).attr("href"));
        return false;
    });
    
    if ($(".toolbar-form").length > 0) {
    	$(".toolbar-form").append($("#toolbar"));
    }
    
    if ($(".toolbar-lista").length > 0) {
    	$(".toolbar-lista").append($("#toolbar"));
    	$(".toolbar-lista").append("<br class='clr' />");
    } 
	
});

$.fn.clearForm = function() {
	return this.each(function() {
		var type = this.type, tag = this.tagName.toLowerCase();
		if (tag == 'form')
			return $(':input',this).clearForm();
		if (type == 'text' || type == 'password' || tag == 'textarea')
			this.value = '';
		else if (type == 'checkbox' || type == 'radio')
			this.checked = false;
		else if (tag == 'select')
			this.selectedIndex = -1;
	});
};

/* Autocomplete */

function autoCompleteBox(name, tagId, tagName) {
    return '<a href="javascript:void(0)" class="autocomplete-remover" title="Remover">x</a>'+ tagName +
           '<input type="hidden" name="'+name+'[]" value="'+ tagId +'" />';
}

function autoCompleteFind(name, id) {
    var encontrou = false;
    $("input[name^="+name+"]").each(function () {
        if ($(this).val()+0 == id+0) {
            encontrou = true;
            return;
        }
	});
	return encontrou;
}

function autoCompleteCallback(event, data) {
    if (data!=undefined) {
        var inputId = $(event["target"]).attr("name");
        $("#"+inputId).val("");
        
        var name = inputId.replace("-input", "");
        
        if (!autoCompleteFind(name, data[1])) {
            var htmlBox = autoCompleteBox(name, data[1], data[0]);
    		$("<li>").html(htmlBox).appendTo("#"+inputId.replace("-input", "-ul"));
        }
    }
}

/****************************************/


function clickOrdering(id,wordem,valor){
  var option = $("#option").val();	   
   var url = "index_ajax.php?option="+option+"&task=ordering&cid[]="+id+"&wordem="+wordem+"&valor="+valor;
   $.get(url,function(data) {
      eval(data);   
   });	
}


function mostraCidades(id_estado) {
   $("#id_cidade").html('<option value="">Carregando...</option>');
    
   $.get("index_ajax.php", { option: "ajax", task: "cidade", id_estado: id_estado, Itemid: '10000' },
   	   function(data){
   	   $("#id_cidade").html(data);
   });
}

function limitChars(textid, limit, infodiv) {
	var text = $('#'+textid).val();
	var textlength = text.length;
	
    if (limit - textlength > 0) {
        $('#'+infodiv).css('color', '#999');
    } else {
        $('#'+infodiv).css('color', 'red');
    }
	
	if(textlength > limit) {
		$('#'+infodiv).html('Seu texto atingiu o limite de '+limit+' caracteres.');
		$('#'+textid).val(text.substr(0,limit));
		return false;
	} else {
        $('#'+infodiv).html((limit - textlength) +' caracteres restantes.');
        return true;
	}
}

function uploadCrop(campo, size, arquivo){
	var vSize = size.split('x');
	
	var imgTesting = new Image();
	function imgTestingOnload(){
		var sizeOriginalWidth = imgTesting.width;
		var sizeOriginalHeight = imgTesting.height;
		
		var widthNew = 0;
		var heightNew = sizeOriginalHeight*vSize[0]/sizeOriginalWidth;
		if(heightNew >= vSize[1]){
			widthNew = vSize[0];
		}else{
			widthNew = sizeOriginalWidth*vSize[1]/sizeOriginalHeight;
			heightNew = vSize[1];
		}
		
		var htmlSize = 'width="'+widthNew+'" height="'+heightNew+'"';
		
		$('#hide-id-'+campo).append('<img src="'+arquivo+'" '+htmlSize+' id="cropbox-'+campo+'" />');
		$('#hide-id-'+campo).append('<input type="hidden" id="'+campo+'-x" name="'+campo+'-x" />');
		$('#hide-id-'+campo).append('<input type="hidden" id="'+campo+'-y" name="'+campo+'-y" />');
		$('#hide-id-'+campo).append('<input type="hidden" id="'+campo+'-w" name="'+campo+'-w" />');
		$('#hide-id-'+campo).append('<input type="hidden" id="'+campo+'-h" name="'+campo+'-h" />');
		
		$('#cropbox-'+campo).Jcrop({
			setSelect: [ 0, 0, vSize[0], vSize[1] ],
			onSelect: function (c) { return uploadCropCoords(campo, c) },
			allowResize: false,
			minSize: [ vSize[0], vSize[1] ],
			maxSize: [ vSize[0], vSize[1] ],
			aspectRatio: vSize[0] / vSize[1]
		});
		
		uploadCropCoords(campo, [0, 0, vSize[0], vSize[1]]);
	}
	imgTesting.onload = imgTestingOnload;
	imgTesting.src = arquivo;
}

function uploadCropCoords(campo, c) {
	$('#'+campo+'-x').val(c.x);
	$('#'+campo+'-y').val(c.y);
	$('#'+campo+'-w').val(c.w);
	$('#'+campo+'-h').val(c.h);
};

/********************************************************************************************/

function checkAll( n, fldName ) {
	  if (!fldName) {
	     fldName = 'cb';
	  }
		var f = document.adminForm;
		var c = f.toggle.checked;
		var n2 = 0;
		for (i=0; i < n; i++) {
			cb = eval( 'f.' + fldName + '' + i );
			if (cb) {
				cb.checked = c;
				n2++;
			}
		}
		/*if (c) {
			document.adminForm.boxchecked.value = n2;
		} else {
			document.adminForm.boxchecked.value = 0;
		}*/
	}