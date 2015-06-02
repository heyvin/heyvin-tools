<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<link rel="stylesheet" href="/css/animation.css">
	<!-- CodeMirror Dependencies -->
	<script src="codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror/theme/monokai.css"></link>
	<script src="codemirror/mode/vb/vb.js"></script>
	<script src="codemirror/mode/clike/clike.js"></script>
	<style>
		.control-wrapper {
			position: absolute;
			text-align: left;
			margin-top: 25px;
		}
		#button-wrapper {
		    margin-top: 20px;
		}
		.hidden {
			display:none
		}
	</style>
	<script type="text/javascript" src="/js/materialize.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
</head>
<body>
	<div class="container">
		<header>
			<?php include 'sidebar.php'; ?>
		</header>
		<form id="myForm" method="post">
			<div class="row">
				<div id="control" class="row control-wrapper col s3 offset-s6">
				    <div id="controlGroup1">
    					<div class="input-field col s5">
    					    <input id="txtRep1" type="text" class="validate" onchange='refreshReplace()'>
                            <label for="txtRep1">Replace</label>
                        </div>
                        <div class="input-field col s5">
                            <input id="txtWith1" type="text" class="validate" onchange='refreshReplace()'>
                            <label for="txtWith1">With</label>
				    	</div>
				    	<div id='button-wrapper' class='col s2'>
				    	    <a id='btnRemove1' class='btn-floating btn-small waves-effect waves-light teal' onclick='btnRemoveClick("1")'>
				    	        <i class='mdi-content-remove'></i>
			    	        </a>
		    	        </div>
					</div>
				</div>
				<div class="col s9">
					<div class="col s12">
						<div align="center"><h6>ORIGINAL</h6></div>
						<textarea id="txtOri"></textarea>
					</div>
					<div class="col s12">
						<div align="center"><h6>PREVIEW</h6></div>
						<textarea id="txtPre"></textarea>
					</div>
				</div>
			</div>
			<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a id="btnAdd" class="btn-floating btn-large waves-effect waves-light red">
                    <i class="large mdi-content-add"></i>
                </a>
                <ul>
                	<li><a id="btnSave" class="btn-floating waves-effect waves-light green tooltipped" data-position="left" data-delay="50" data-tooltip="Save Preset"><i class="large mdi-content-save"></i></a></li>
                	<li><a id="btnLoad" class="btn-floating waves-effect waves-light orange lighten-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Load Preset"><i class="large mdi-content-inbox"></i></a></li>
					<li><a id="btnClear" class="btn-floating waves-effect waves-light blue tooltipped" data-position="left" data-delay="50" data-tooltip="Clear"><i class="large mdi-content-clear"></i></a></li>
				</ul>
            </div>
            <div id="modal-save" class="modal">
            	<div class="modal-content">
            		<h5>Save Preset</h5>
            		<div id="preloader" class="progress hidden">
						<div class="indeterminate"></div>
					</div>
					<div id="files-preloader-save" class="hidden" align="center">
						<div class="preloader-wrapper medium active">
							<div class="spinner-layer spinner-green-only">
								<div class="circle-clipper left">
									<div class="circle"></div>
								</div><div class="gap-patch">
									<div class="circle"></div>
								</div><div class="circle-clipper right">
									<div class="circle"></div>
								</div>
							</div>
						</div>
					</div>
					<div id="file-list-save" class="collection hidden">
					</div>
					<div class="input-field">
                        <input id="txtNewPreset" type="text" class="validate">
                        <label for="txtNewPreset">Or enter new preset name</label></label>
			    	</div>
			    	<div align="center">
			    		<a id="btnOkSave" class="modal-action waves-effect waves-teal btn-flat">OK</a>
			    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
			    	</div>
            	</div>
            </div>
            <div id="modal-load" class="modal">
            	<div class="modal-content">
            		<h5>Load Preset</h5>
            		<div id="preloader" class="progress hidden">
						<div class="indeterminate"></div>
					</div>
					<div id="files-preloader-load" class="hidden" align="center">
						<div class="preloader-wrapper medium active">
							<div class="spinner-layer spinner-green-only">
								<div class="circle-clipper left">
									<div class="circle"></div>
								</div><div class="gap-patch">
									<div class="circle"></div>
								</div><div class="circle-clipper right">
									<div class="circle"></div>
								</div>
							</div>
						</div>
					</div>
					<div id="file-list-load" class="collection hidden">
					</div>
			    	<div align="center">
			    		<a id="btnOkLoad" class="modal-action waves-effect waves-teal btn-flat">OK</a>
			    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
			    	</div>
            	</div>
            </div>
		</form>
		<script type="text/javascript">
		    
		    var num = 1;
			var realNum = 1;
			var countFiles = 0;
			
			// CodeMirror
			var cmOri = CodeMirror.fromTextArea(document.getElementById("txtOri"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "vb",
				theme: "monokai"
			});
			cmOri.setSize("100%", "43%");
			
			var cmPre = CodeMirror.fromTextArea(document.getElementById("txtPre"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "text/x-java",
				readOnly: true,
				theme: "monokai"
			});
			cmPre.setSize("100%", "43%");
		
			$(document).ready(function(){
				
				setActive("#replacetool");
				
				$("#btnAdd").click(function() {
				    
				    num = num + 1;
				    
				    var newDiv = "<div id='controlGroup" + num.toString() + "'><div class='input-field col s5'><input id='txtRep" + num.toString() 
				    + "' type='text' class='validate' onchange='refreshReplace()'><label for='txtRep" + num.toString() 
				    + "'>Replace</label></div><div class='input-field col s5'><input id='txtWith" + num.toString() 
				    + "' type='text' class='validate' onchange='refreshReplace()'><label for='txtWith" + num.toString() 
				    + "'>With</label></div><div id='button-wrapper' class='col s2'><a id='btnRemove" + num.toString() 
				    + "' class='btn-floating btn-small waves-effect waves-light teal' onclick='btnRemoveClick(\"" + num.toString()
				    + "\")'><i class='mdi-content-remove'></i></a></div></div>";
				    
				    realNum = realNum + 1;
				    $("#control").append(newDiv);
				    
				});
				
				$("#btnClear").click(function() {
					location.reload();
				});
				
				$("#btnSave").click(function() {
					
					$('#txtNewPreset').val("");
					$("#file-list-save").empty();
					countFiles = 0;
					$("#file-list-save").addClass("hidden");
					$('#txtNewPreset').blur();
					$('#modal-save').openModal();
					
					// call AJAX to get file list
		    		$.ajax({
					    type : "POST",
					    url : "data/getpresetsname.php",
					    success : function(response) {
					    	$("#file-list-save").removeClass("hidden");
					    	var filesArray = $.parseJSON(response).files;
					    	for(var i = 0; i < filesArray.length; i++) {
					    		$("#file-list-save").append("<a href='#!' id='file-save-" 
					    			+ i.toString() + "' class='collection-item' onclick='btnFileNameSaveClick(" 
					    			+ i.toString() + ")'>" 
					    			+ filesArray[i].replace(".json", "") + "</a>");
				    			countFiles = countFiles + 1;
					    	}
					    },
					    beforeSend : function() {
					    	$("#files-preloader-save").removeClass("hidden");
					    },
					    complete : function() {
					    	$("#files-preloader-save").addClass("hidden");
					    }
					});
					
				});
				
				$("#btnOkSave").click(function() {
					
					if($("#txtNewPreset").val() != "") {
						
						var dataObject = {
							crits: []
						};
						
						for(var i = 1; i <= num; i++) {
			        
					        if($("#txtRep" + i.toString()).val() != undefined && $("#txtWith" + i.toString()).val() != undefined) {
					            
					            dataObject.crits.push({
					            	"replace" : $("#txtRep" + i.toString()).val(),
					            	"with" : $("#txtWith" + i.toString()).val()
					            });
					            
					        }
			        
			    		}
			    		
			    		// call AJAX to write preset to file in JSON format
			    		$.ajax({
						    type : "POST",
						    url : "data/savepreset.php",
						    dataType : 'json', 
						    data : {
						    	name: $("#txtNewPreset").val(),
						        json : JSON.stringify(dataObject)
						    },
						    success : function(response) {
						    	$('#modal-save').closeModal();
						    	if(response.result == "ok") {
						    		Materialize.toast("Save preset completed.", 3000);
						    	} else {
						    		Materialize.toast("Error, please try again.", 3000);
						    	}
						    },
						    beforeSend : function() {
						    	$("#preloader").removeClass("hidden");
						    },
						    complete : function() {
						    	$("#preloader").addClass("hidden");
						    }
						});
			    		
					}
					
				});
				
				$("#btnLoad").click(function() {
				
					$("#file-list-load").empty();
					countFiles = 0;
					$("#file-list-load").addClass("hidden");
					$('#modal-load').openModal();
					
					// call AJAX to get file list
		    		$.ajax({
					    type : "POST",
					    url : "data/getpresetsname.php",
					    success : function(response) {
					    	$("#file-list-load").removeClass("hidden");
					    	var filesArray = $.parseJSON(response).files;
					    	for(var i = 0; i < filesArray.length; i++) {
					    		$("#file-list-load").append("<a href='#!' id='file-load-" 
					    			+ i.toString() + "' class='collection-item' onclick='btnFileNameLoadClick(" 
					    			+ i.toString() + ")'>" 
					    			+ filesArray[i].replace(".json", "") + "</a>");
				    			countFiles = countFiles + 1;
					    	}
					    },
					    beforeSend : function() {
					    	$("#files-preloader-load").removeClass("hidden");
					    },
					    complete : function() {
					    	$("#files-preloader-load").addClass("hidden");
					    }
					});
				
				});
				
				$("#btnOkLoad").click(function() {
					
					var currentName = "";
					for(var i = 0; i < countFiles; i++) {
						if($("#file-load-" + i.toString()).hasClass("active")) {
							currentName = $("#file-load-" + i.toString()).text();
							break;
						}
					}
					
					// call AJAX to get file content
		    		$.ajax({
					    type : "POST",
					    url : "data/getpreset.php",
					    dataType : 'json', 
						data : {
							name: currentName
						},
					    success : function(response) {
					    	
					    	var object = $.parseJSON(response.content);
					    	var arrCrits = object.crits;
					    	
					    	for(var i = 1; i <= num; i++) {
					    		if($("#txtRep" + i.toString()).val() != undefined && $("#txtWith" + i.toString()).val() != undefined) {
					    			$("#controlGroup" + i.toString()).remove();
					    		}
					    	}
					    	
					    	num = 0;
					    	
					    	for(var i = 0; i < arrCrits.length; i++) {
					    		
					    		num = num + 1;
							    
							    var newDiv = "<div id='controlGroup" + num.toString() + "'><div class='input-field col s5'><input id='txtRep" + num.toString() 
							    + "' type='text' class='validate' onchange='refreshReplace()'><label for='txtRep" + num.toString() 
							    + "'>Replace</label></div><div class='input-field col s5'><input id='txtWith" + num.toString() 
							    + "' type='text' class='validate' onchange='refreshReplace()'><label for='txtWith" + num.toString() 
							    + "'>With</label></div><div id='button-wrapper' class='col s2'><a id='btnRemove" + num.toString() 
							    + "' class='btn-floating btn-small waves-effect waves-light teal' onclick='btnRemoveClick(\"" + num.toString()
							    + "\")'><i class='mdi-content-remove'></i></a></div></div>";
							    
							    $("#control").append(newDiv);
							    
							    $("#txtRep" + num.toString()).focus();
							    $("#txtRep" + num.toString()).val(arrCrits[i].replace);
							    $("#txtRep" + num.toString()).blur();
							    
							    $("#txtWith" + num.toString()).focus();
							    $("#txtWith" + num.toString()).val(arrCrits[i].with);
							    $("#txtWith" + num.toString()).blur();
							    
					    	}
					    	
					    	refreshReplace();
					    	$('#modal-load').closeModal();
					    	
					    },
					    beforeSend : function() {
					    	$("#files-preloader-load").removeClass("hidden");
					    },
					    complete : function() {
					    	$("#files-preloader-load").addClass("hidden");
					    }
					});
					
				});
				
				cmOri.on("change", function(){
					cmPre.setValue(cmOri.getValue());
				});

			});
			
			function btnRemoveClick(strNum) {
			    $("#controlGroup" + strNum).remove();
			    if(refreshReplace() == 0) {
			        cmPre.setValue(cmOri.getValue());
			    }
			}
			
			function btnFileNameSaveClick(strNum) {
				for(var i = 0; i < countFiles; i++) {
					$("#file-save-" + i.toString()).removeClass("active");
				}
				$("#file-save-" + strNum).addClass("active");
				$("#txtNewPreset").focus();
				$("#txtNewPreset").val($("#file-save-" + strNum).text());
				$("#txtNewPreset").blur();
			}
			
			function btnFileNameLoadClick(strNum) {
				for(var i = 0; i < countFiles; i++) {
					$("#file-load-" + i.toString()).removeClass("active");
				}
				$("#file-load-" + strNum).addClass("active");
				$("#txtNewPreset").focus();
				$("#txtNewPreset").val($("#file-load-" + strNum).text());
				$("#txtNewPreset").blur();
			}
			
			function refreshReplace() {
			    
			    var text = cmOri.getValue();
			    var count = 0;
			    
			    for(var i = 1; i <= num; i++) {
			        
			        if($("#txtRep" + i.toString()).val() != undefined && $("#txtWith" + i.toString()).val() != undefined) {
			            
			            count = count + 1;
			            
			            if($("#txtRep" + i.toString()).val() == "") continue;
			            
			            text = replaceAll(text, $("#txtRep" + i.toString()).val(), $("#txtWith" + i.toString()).val());
			            
			            cmPre.setValue(text);
			            
			        }
			        
			    }
			    
			    return count;
			    
			}
			
			function replaceAll(string, find, replace) {
                return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
            }
			
			function escapeRegExp(string) {
                return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
            }
			
		</script>
	</div>
</body>
</html>
