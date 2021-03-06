<html>
<head>
	<title>Heyvin's Tools</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<!-- CodeMirror Dependencies -->
	<script src="/tools/codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/tools/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="/tools/codemirror/theme/mbo.css"></link>
	<script src="/tools/codemirror/mode/clike/clike.js"></script>
	<style>
		.control-wrapper {
			position: absolute;
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
				<div class="col s2 offset-s8 control-wrapper pinned">
					<div class="button-container">
						<br>
						<a href="#" id="btnSubmit" class="waves-effect waves-light btn-large"><i class="mdi-action-exit-to-app left"></i>COMPARE</a>
						<br><br>
						<a href="#" id="btnClear" class="waves-effect waves-light btn-large red lighten-1"><i class="mdi-navigation-refresh left"></i>CLEAR</a>
						<br><br>
						<a href="#" id="btnHow" class="waves-effect waves-light btn-large orange lighten-1"><i class="mdi-action-help left"></i>WTF?!?</a>
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
		<div id="mdlHow" class="modal modal-fixed-footer">
			<div class="modal-content">
				<h4>Đây Là Cái Nồi Gì</h4>
				<p>Lỡ có viết cái doQuery tới hơn trăm cái biến mà nó báo lỗi thì không biết đường nào mà lần ra biến không hợp kiểu. Vì lí do làm biếng nói chung nên tool này được tạo ra.</p>
				<h4>Cách Sử Dụng</h4>
				<p><b>B1: Copy thông báo lỗi từ method. Dán vô [Text From Error Message]</b></p>
				<p><b>Eg:</b> The method doQuery(int, int, String, String, String, String) in the type S_PZC0050_I_003 is not applicable for the arguments (int, int, String, int, String, String)
				</p>
				<p><b>B2: Mở file SQL Java ra tìm chỗ khai báo biến. Dán vô [Arguments From SQL Java]</b></p>
				<p><b>Eg:</b> int idoden_no, int idomeisai_no, String nendo, String can_kbn, String juha_no1, String juha_no2
				</p>
				<p><b>B3: Nhấn COMPARE để sướng.</b></p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">OK</a>
			</div>
		</div>
		<script type="text/javascript">
		
			// CodeMirror
			var cmError = CodeMirror.fromTextArea(document.getElementById("txtError"), {
				indentUnit: 4,
				lineWrapping: true,
				lineNumbers: true,
				mode: "java",
				theme: "mbo"
			});
			cmError.setSize("100%", "43%");
			
			var cmSQL = CodeMirror.fromTextArea(document.getElementById("txtSQL"), {
				indentUnit: 4,
				lineWrapping: true,
				lineNumbers: true,
				mode: "java",
				theme: "mbo"
			});
			cmSQL.setSize("100%", "43%");
			
			var cmConflict = CodeMirror.fromTextArea(document.getElementById("txtConflict"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "java",
				readOnly: true,
				theme: "mbo"
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
						strError = strError.replace(/\n/g, "");
						var arrError = strError.split(',');
						strSQL = strSQL.replace(/\n/g, "");
						var arrSQL = strSQL.split(',');
						
						if(arrError.length != arrSQL.length) {
							
							cmConflict.setValue("");
							Materialize.toast("2 input textboxs don't have the same number of variables.", 3000);
							
						} else {
							
							for(var i = 0; i < arrError.length; i++) {
								arrSQL[i] = arrSQL[i].trim();
								if(arrError[i] != arrSQL[i].substring(0, arrSQL[i].indexOf(' '))) {
									if((arrError[i] == "float" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "double")
									|| (arrError[i] == "int" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "double")
									|| (arrError[i] == "int" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "Integer")
									|| (arrError[i] == "float" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "Float")
									|| (arrError[i] == "short" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "Short")
									|| (arrError[i] == "long" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "Long")
									|| (arrError[i] == "double" && arrSQL[i].substring(0, arrSQL[i].indexOf(' ')) == "Double")) {
									} else {
										strConflict = strConflict + arrSQL[i] + "\n";
									}
								}
							}
							
							cmConflict.setValue(strConflict);
							
						}
					
					}
					
				});

				$("#btnClear").click(function() {
					
					cmError.setValue("");
					cmSQL.setValue("");
					cmConflict.setValue("");
					
				});
				
				$("#btnHow").click(function() {
					$('#mdlHow').openModal();	
				});

			});
		</script>
	</div>
</body>
</html>
