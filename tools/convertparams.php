<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<!-- CodeMirror Dependencies -->
	<script src="codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror/theme/monokai.css"></link>
	<script src="codemirror/mode/vb/vb.js"></script>
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
				<div class="col s2 offset-s8 control-wrapper pinned">
					<div class="rdo-container">
						<input type="radio" id="rdoVar" name="rdoButton" checked />
						<label for="rdoVar">Variables</label>
						<input type="radio" id="rdoArr" name="rdoButton" />
						<label for="rdoArr">Arrays</label>
					</div>
					<div class="button-container">
						<br>
						<a href="#" id="btnSubmit" class="waves-effect waves-light btn-large"><i class="mdi-action-exit-to-app left"></i>GET CODE</a>
						<br><br>
						<a href="#" id="btnSelAll" class="waves-effect waves-light btn-large orange lighten-1"><i class="mdi-content-select-all left"></i>SELECT ALL</a>
						<br><br>
						<a href="#" id="btnClear" class="waves-effect waves-light btn-large red lighten-1"><i class="mdi-navigation-refresh left"></i>CLEAR</a>
					</div>
				</div>
				<div class="col s6">
					<div align="center"><h6>VB.NET</h6></div>
					<textarea id="txtVb"></textarea>
				</div>
				<div class="col s6">
					<div align="center"><h6>JAVA</h6></div>
					<textarea id="txtJava"></textarea>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		
			// CodeMirror
			var cmVb = CodeMirror.fromTextArea(document.getElementById("txtVb"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "vb",
				theme: "monokai"
			});
			cmVb.setSize("100%", "90%");
			var cmJava = CodeMirror.fromTextArea(document.getElementById("txtJava"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "text/x-java",
				readOnly: true,
				theme: "monokai"
			});
			cmJava.setSize("100%", "90%");
		
			$(document).ready(function(){
				
				setActive("#convertparams");

				$('.control-wrapper .row').pushpin({ top: $('.control-wrapper').offset().top });

				$("#btnSubmit").click(function() {

					var input = cmVb.getValue();
					var lines = input.split('\n');
					var types = []; // variable type
					var variables = []; // variable name
					var flg_class = []; // whether the variable type is a new class or not

					for(var i = 0; i < lines.length; i++) {
						
						flg_class[i] = false;
						lines[i] = lines[i].trim();
						if(lines[i][0] == 'P') {

							// search for type declaration in VB, if equivalence's not found, consider it as a new class
							if(lines[i].search("String") != -1) {
								types.push("String");
							} else if(lines[i].search("Long") != -1) {
								types.push("int");
							} else if(lines[i].search("Integer") != -1) {
								types.push("int");
							} else if(lines[i].search("Decimal") != -1) {
								types.push("float");
							} else if(lines[i].search("Boolean") != -1) {
								types.push("boolean");
							} else {
								types.push(lines[i].substring(lines[i].lastIndexOf(" ") + 1));
								flg_class[i] = true;
							}
							
							// clear head and tail to get variable name only
							lines[i] = lines[i].replace("Public ", "");
							lines[i] = lines[i].slice(0, lines[i].indexOf(" "));

							if(flg_class[i] == false) {
								
								// if variable type is available in Java
								if(lines[i] == lines[i].toUpperCase()) {
									
									variables.push(lines[i].toLowerCase());
									
								} else {
									
									for(var x = 1; x < lines[i].length; x++) {
										if(lines[i].charAt(x) == lines[i].charAt(x).toUpperCase()) {
											lines[i] = lines[i].slice(0, x) + "_" + lines[i].slice(x);
											x++;
										}
									}
									variables.push(lines[i].toLowerCase());
									
								}
								
							} else {
								
								// if variable type is a new class
								variables.push(lines[i]);
								
							}

						}

					}

					// concat type + name to create declaration code in Java
					var textToPrint = "";
					for(var i = 0; i < types.length; i++) {
						textToPrint += types[i] + " " + variables[i] + ";" + "\n";
					}
					cmJava.setValue(textToPrint);
					
				});

				$("#btnClear").click(function() {
					cmVb.setValue("");
					cmJava.setValue("");
				});

				$("#btnSelAll").click(function() {
					cmJava.execCommand("selectAll");
					cmJava.focus();
				});

			});
			
		</script>
	</div>
</body>
</html>
