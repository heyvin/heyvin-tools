<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<!-- CodeMirror Dependencies -->
	<script src="/tools/codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/tools/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="/tools/codemirror/theme/monokai.css"></link>
	<script src="/tools/codemirror/mode/clike/clike.js"></script>
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
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/tools/layout/sidebar.php'; ?>
		</header>
		<form id="myForm" method="post">
			<div class="row">
				<div class="col s10 control-wrapper pinned">
					<div class="button-container">
						<br>
						<a href="#" id="btnSubmit" class="waves-effect waves-light btn-large"><i class="mdi-action-exit-to-app left"></i>COMPARE</a>
						<br><br>
						<a href="#" id="btnClear" class="waves-effect waves-light btn-large red lighten-1"><i class="mdi-navigation-refresh left"></i>CLEAR</a>
					</div>
				</div>
				<div class="col s8">
					<div class="col s12">
						<div align="center"><h6>Text From Error Message</h6></div>
						<textarea id="txtError"></textarea>
					</div>
					<div class="col s12">
						<div align="center"><h6>Arguments From SQL Java</h6></div>
						<textarea id="txtSQL"></textarea>
					</div>
				</div>
				<div class="col s4">
					<div align="center"><h6>Conflict Variables</h6></div>
					<textarea id="txtConflict"></textarea>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		
			// CodeMirror
			var cmError = CodeMirror.fromTextArea(document.getElementById("txtError"), {
				indentUnit: 4,
				lineWrapping: true,
				lineNumbers: true,
				mode: "java",
				theme: "monokai"
			});
			cmError.setSize("100%", "43%");
			
			var cmSQL = CodeMirror.fromTextArea(document.getElementById("txtSQL"), {
				indentUnit: 4,
				lineWrapping: true,
				lineNumbers: true,
				mode: "java",
				theme: "monokai"
			});
			cmSQL.setSize("100%", "43%");
			
			var cmConflict = CodeMirror.fromTextArea(document.getElementById("txtConflict"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "java",
				readOnly: true,
				theme: "monokai"
			});
			cmConflict.setSize("100%", "90%");
		
			$(document).ready(function(){
				
				setActive("#comparetool");
				
				$('.control-wrapper .row').pushpin({ top: $('.control-wrapper').offset().top });

				$("#btnSubmit").click(function() {
					
					if(cmError.getValue() != "" && cmSQL.getValue() != "") {
					
						var strError = cmError.getValue();
						var strSQL = cmSQL.getValue();
						var strConflict = "";
						
						if(strError.indexOf("arguments") != -1) {
							strError = strError.substring(strError.indexOf("arguments") + 11, strError.length - 1);
						}
						strError = strError.replace(/\ /g, "");
						var arrError = strError.split(',');
						strSQL = strSQL.replace(/\n/g, "");
						var arrSQL = strSQL.split(',');
						
						
						for(var i = 0; i < arrError.length; i++) {
							arrSQL[i] = arrSQL[i].trim();
							if(arrError[i] != arrSQL[i].substring(0, arrSQL[i].indexOf(' '))) {
								if((arrError[i] == "float" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "double")
								|| (arrError[i] == "int" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "double")) {
								} else {
									strConflict = strConflict + arrSQL[i] + "\n";
								}
							}
						}
						
						cmConflict.setValue(strConflict);
					
					}
					
				});

				$("#btnClear").click(function() {
					
					cmError.setValue("");
					cmSQL.setValue("");
					cmConflict.setValue("");
					
				});

			});
		</script>
	</div>
</body>
</html>
