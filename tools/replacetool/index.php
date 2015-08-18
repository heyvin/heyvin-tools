<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<link rel="stylesheet" href="/css/animation.css">
	<!-- CodeMirror Dependencies -->
	<script src="/tools/codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/tools/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="/tools/codemirror/theme/mbo.css"></link>
	<script src="/tools/codemirror/mode/vb/vb.js"></script>
	<script src="/tools/codemirror/mode/clike/clike.js"></script>
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
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/tools/layout/sidebar.php'; ?>
		</header>
		<form id="myForm" method="post">
			<div class="row">
				<div id="control" class="row control-wrapper col s3 offset-s6">
					<div class="card-panel">
						<span style="font-size: 10gpt">Side of Variables:</span>
						<select id="selSide">
							<option value="" disabled selected>Choose your option</option>
							<option value="1">Left</option>
							<option value="2">Right</option>
							<option value="3">Both</option>
						</select>
						<div id="controlGroup0" align="left">
							<div>
								<input type="checkbox" id="chkVariables" />
	      						<label for="chkVariables">Replace VB-style Variables</label>
							</div>
	      					<div style="margin-top: 10px">
								<input type="checkbox" id="chkSemi" />
	      						<label for="chkSemi">Add Semicolons to The Lines</label>
							</div>
							<div style="margin-top: 10px">
								<input type="checkbox" id="chkSetObject" />
	      						<label for="chkSetObject">Fix setObject</label>
							</div>
						</div>
					</div>
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
					<div class="col s12" style="margin-top: 15px">
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
					<li><a id="btnClear" class="btn-floating waves-effect waves-light blue tooltipped" data-position="left" data-delay="50" data-tooltip="Clear Input"><i class="large mdi-content-clear"></i></a></li>
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
					<ul id="file-list-save" class="collection hidden">
					</ul>
					<div class="input-field">
                        <input id="txtNewPreset" type="text" class="validate">
                        <label for="txtNewPreset">Or enter new preset name</label></label>
			    	</div>
			    	<div align="center">
			    		<a id="btnOkSave" class="modal-action waves-effect waves-teal btn-flat">OK</a>
			    		<a class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
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
					<ul id="file-list-load" class="collection hidden">
					</ul>
			    	<div align="center">
			    		<a id="btnOkLoad" class="modal-action waves-effect waves-teal btn-flat">OK</a>
			    		<a class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
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
				theme: "mbo"
			});
			cmOri.setSize("100%", "43%");
			
			var cmPre = CodeMirror.fromTextArea(document.getElementById("txtPre"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "text/x-java",
				readOnly: true,
				theme: "mbo"
			});
			cmPre.setSize("100%", "43%");
		
			$(document).ready(function(){
				
				setActive("#replacetool");
				$("#selSide").material_select();
				
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
					cmOri.setValue("");
					cmPre.setValue("");
					$("#selSide").val("");
					$("#selSide").material_select();
					$("#chkVariables").prop("disabled", false);
					$("#chkVariables").prop("checked", false);
					$("#chkSemi").prop("checked", false);
					$("#chkSetObject").prop("disabled", false);
					$("#chkSetObject").prop("checked", false);
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
					    	filesArray.shift();
					    	for(var i = 0; i < filesArray.length; i++) {
					    		$("#file-list-save").append("<li id='file-save-" 
					    			+ i.toString() + "' class='collection-item' onclick='btnFileNameSaveClick(" 
					    			+ i.toString() + ")'><div>" 
					    			+ filesArray[i].replace("tools-data/json/", "").replace(".json", "") 
					    			+ "<a href='#' id='file-delete-" + i.toString() 
					    			+ "' class='secondary-content' onclick='btnDeletePresetClick("
					    			+ i.toString() + ")'><i class='mdi-action-delete small circle white'></i></a></div></li>");
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
					    	filesArray.shift();
					    	for(var i = 0; i < filesArray.length; i++) {
					    		$("#file-list-load").append("<li id='file-load-" 
					    			+ i.toString() + "' class='collection-item' onclick='btnFileNameLoadClick(" 
					    			+ i.toString() + ")'>" 
					    			+ filesArray[i].replace("tools-data/json/", "").replace(".json", "") + "</li>");
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
					refreshReplace();
				});
				
				$("#chkVariables").change(function() {
					if($("#chkVariables").prop("checked")) {
						var strPreText = cmPre.getValue();
						var arrLines = strPreText.split('\n');
						for(var i = 0; i < arrLines.length; i++) {
							if(arrLines[i].lastIndexOf('\'') != -1) {
								arrLines[i] = arrLines[i].substring(0, arrLines[i].lastIndexOf('\''));
							}
							arrLines[i] = arrLines[i].trim();
							if(arrLines[i] != "") {
								if(arrLines[i].indexOf('=') == -1) {
									var varText = arrLines[i].substring(arrLines[i].lastIndexOf('.') + 1, arrLines[i].lastIndexOf(')'));
									varText = varText.trim();
									if(varText.match(/^[a-zA-Z0-9]+$/g) != null) {
										if(varText == varText.toUpperCase()) {
											varText = varText.toLowerCase();
										} else {
											for(var x = 1; x < varText.length; x++) {
												if(varText.charAt(x).match(/^[a-zA-Z0-9]+$/g) != null && varText.charAt(x) == varText.charAt(x).toUpperCase()) {
													varText = varText.slice(0, x) + "_" + varText.slice(x);
													x++;
												}
											}
											varText = varText.toLowerCase();
										}
										arrLines[i] = arrLines[i].substring(0, arrLines[i].lastIndexOf('.') + 1) + varText + arrLines[i].substring(arrLines[i].lastIndexOf(')'), arrLines[i].length);
									}
								} else {
									var arrSegment = arrLines[i].split(" = ");
									
									if(arrSegment[0] != undefined && arrSegment[1] != undefined) {
										
										// First segment
										if($("#selSide").val() == "1" || $("#selSide").val() == "3") {
											var varText = arrSegment[0].substring(arrSegment[0].lastIndexOf('.') + 1, arrSegment[0].length);
											if(varText == varText.toUpperCase()) {
												varText = varText.toLowerCase();
											} else {
												for(var x = 1; x < varText.length; x++) {
													if(varText.charAt(x).match(/^[a-zA-Z0-9]+$/g) != null && varText.charAt(x) == varText.charAt(x).toUpperCase()) {
														varText = varText.slice(0, x) + "_" + varText.slice(x);
														x++;
													}
												}
												varText = varText.toLowerCase();
											}
											arrSegment[0] = arrSegment[0].substring(0, arrSegment[0].lastIndexOf('.') + 1) + varText;
										}
										
										// Second segment
										if($("#selSide").val() == "2" || $("#selSide").val() == "3") {
											var varText = arrSegment[1].substring(arrSegment[1].lastIndexOf('.') + 1, arrSegment[1].length);
											if(varText == varText.toUpperCase()) {
												varText = varText.toLowerCase();
											} else {
												for(var x = 1; x < varText.length; x++) {
													if(varText.charAt(x).match(/^[a-zA-Z0-9]+$/g) != null && varText.charAt(x) == varText.charAt(x).toUpperCase()) {
														varText = varText.slice(0, x) + "_" + varText.slice(x);
														x++;
													}
												}
												varText = varText.toLowerCase();
											}
											arrSegment[1] = arrSegment[1].substring(0, arrSegment[1].lastIndexOf('.') + 1) + varText;
										}
										
										arrLines[i] = arrSegment.join(" = ");
									
									}
									
								}
							}
						}
						cmPre.setValue(arrLines.join('\n'));
						$("#chkVariables").prop("disabled", true);
					}
				});
				
				$("#chkSemi").change(function() {
					if($("#chkSemi").prop("checked")) {
						var strPreText = cmPre.getValue();
						var arrLines = strPreText.split('\n');
						for(var i = 0; i < arrLines.length; i++) {
							if(arrLines[i].lastIndexOf('\'') != -1) {
								arrLines[i] = arrLines[i].substring(0, arrLines[i].lastIndexOf('\''));
							}
							arrLines[i] = arrLines[i].trim();
							if(arrLines[i] != "") {
								arrLines[i] = arrLines[i] + ";";
							}
						}
						cmPre.setValue(arrLines.join('\n'));
					} else {
						var strPreText = cmPre.getValue();
						var arrLines = strPreText.split('\n');
						for(var i = 0; i < arrLines.length; i++) {
							if(arrLines[i] != "") {
								if(arrLines[i][arrLines[i].length - 1] == ';') {
									arrLines[i] = arrLines[i].substring(0, arrLines[i].lastIndexOf(';'));
								}
							}
						}
						cmPre.setValue(arrLines.join('\n'));
					}
				});
				
				$("#chkSetObject").change(function() {
					if($("#chkSetObject").prop("checked")) {
						var strPreText = cmPre.getValue();
						var arrLines = strPreText.split('\n');
						for(var i = 0; i < arrLines.length; i++) {
							var arg = arrLines[i].substring(arrLines[i].indexOf(',') + 1, arrLines[i].lastIndexOf(')')).trim();
							arrLines[i] = arrLines[i].substring(0, arrLines[i].lastIndexOf(')')) 
								+ ' != null ? (' + arg + '.equals("") ? null : ' + arg + ') : ' + arg + ');';
						}
						cmPre.setValue(arrLines.join('\n'));
						$("#chkSetObject").prop("disabled", true);
					}
				});

			});
			
			function btnDeletePresetClick(strNum) {
				// call AJAX to delete preset file
	    		$.ajax({
				    type : "POST",
				    url : "data/deletepreset.php",
				    dataType : 'json', 
					data : {
						name: $("#file-save-" + strNum).text()
					},
				    success : function(response) {
				    	$("#file-save-" + strNum).remove();
				    	Materialize.toast("Delete preset completed.", 3000);
				    },
				    error : function() {
				    	Materialize.toast("Deletion failed, please try again.", 3000);
				    },
				    beforeSend : function() {
				    	$("#files-preloader-load").removeClass("hidden");
				    },
				    complete : function() {
				    	$("#files-preloader-load").addClass("hidden");
				    }
				});
			}
			
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
			    
			    if($("#chkVariables").prop("disabled")) {
			    	$("#chkVariables").trigger("change");
			    }
			    if($("#chkSemi").prop("checked")) {
			    	$("#chkSemi").trigger("change");
			    }
			    if($("#chkSetObject").prop("checked")) {
			    	$("#chkSetObject").trigger("change");
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
