<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<!-- CodeMirror Dependencies -->
	<script src="codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror/theme/monokai.css"></link>
	<script src="codemirror/mode/clike/clike.js"></script>
	<style>
		.control-wrapper {
			position: relative;
			text-align: right;
			margin-top: 25px;
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
				<div class="col s10 control-wrapper pinned">
					<div class="button-container">
						<br>
						<a href="#" id="btnSubmit" class="waves-effect waves-light btn-large"><i class="mdi-action-exit-to-app left"></i>GET CODE</a>
						<br><br>
						<a href="#" id="btnClear" class="waves-effect waves-light btn-large red lighten-1"><i class="mdi-navigation-refresh left"></i>CLEAR</a>
					</div>
				</div>
				<div class="input-field col s8 offset-s2">
					<textarea id="txtVariable" class="materialize-textarea"></textarea>
					<label for="txtVariable">Variables (separated by commas)</label>
				</div>
				<div class="col s4">
					<div align="center"><h6>Variables declaration</h6></div>
					<textarea id="txtDeclaration"></textarea>
				</div>
				<div class="col s4">
					<div align="center"><h6>Initiation code</h6></div>
					<textarea id="txtInitiation"></textarea>
				</div>
				<div class="col s4">
					<div align="center"><h6>Validation code</h6></div>
					<textarea id="txtValidation"></textarea>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		
			// CodeMirror
			var cmDeclaration = CodeMirror.fromTextArea(document.getElementById("txtDeclaration"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "java",
				theme: "monokai"
			});
			cmDeclaration.setSize("100%", "70%");
			
			var cmInitiation = CodeMirror.fromTextArea(document.getElementById("txtInitiation"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "java",
				readOnly: true,
				theme: "monokai"
			});
			cmInitiation.setSize("100%", "70%");
			
			var cmValidation = CodeMirror.fromTextArea(document.getElementById("txtValidation"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "java",
				readOnly: true,
				theme: "monokai"
			});
			cmValidation.setSize("100%", "70%");
		
			$(document).ready(function(){
				
				setActive("#formvars");
				
				$('.control-wrapper .row').pushpin({ top: $('.control-wrapper').offset().top });

				$("#btnSubmit").click(function() {
					
					var arr_variables = [];
					
					if($("#txtVariable").val() != "") {

						arr_variables = $("#txtVariable").val().split(",");
						for(var i = 0; i < arr_variables.length; i++) {
							arr_variables[i] = arr_variables[i].trim();
						}
						// Declaration Text
						var str_declaration = "";
						for(var i = 0; i < arr_variables.length; i++) {
							str_declaration += "public String " + arr_variables[i] + ";\n";
						}
						cmDeclaration.setValue(str_declaration);
						
					} else {
						
						if(cmDeclaration.getValue() != "") {
							
							var lines = cmDeclaration.getValue().split('\n');
							for(var i = 0; i < lines.length; i++) {
								lines[i] = lines[i].trim();
								if(lines[i] != "") {
									lines[i] = lines[i].replace("public String ", "");
									lines[i] = lines[i].replace(";", "");
									arr_variables.push(lines[i]);
								}
							}
							
						}
						
					}
	
					// Initiation Text
					var str_init = "";
					for(var i = 0; i < arr_variables.length; i++) {
						str_init += "this." + arr_variables[i] + " = this.values.get(\"" + arr_variables[i] + "\");\n";
					}
					cmInitiation.setValue(str_init);

					// Validation Text
					var str_validation = "";
					for(var i = 0; i < arr_variables.length; i++) {
						str_validation += "if (this." + arr_variables[i] +" == null) {\n\t" +
											"this.errors.add(new FormObjectErrorMessage(\"" + arr_variables[i] + 
											"\", -1));\n" + "}\n";
					}
					cmValidation.setValue(str_validation);
					
				});

				$("#btnClear").click(function() {
					$("#txtVariable").val("");
					$("#txtVariable").focus();
					$("#txtVariable").blur();
					cmDeclaration.setValue("");
					cmInitiation.setValue("");
					cmValidation.setValue("");
				});

			});
		</script>
	</div>
</body>
</html>
