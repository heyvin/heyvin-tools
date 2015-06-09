<html>
<head>
	<title>Heyvin's Tools</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<!-- CodeMirror Dependencies -->
	<script src="/tools/codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/tools/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="/tools/codemirror/theme/monokai.css"></link>
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
				<p><b>B1: Lấy thông báo lỗi từ method.</b></p>
				<p><b>Eg:</b> The method doQuery(int, int, String, String, String, String)
				</p>
				<p><b>B2: Mở file SQL Java ra tìm chỗ khai báo biến rồi dán vô đây.</b></p>
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
				
				$("#btnHow").click(function() {
					$('#mdlHow').openModal();	
				});

			});
		</script>
	</div>
</body>
</html>
