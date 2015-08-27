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
	<script src="/tools/codemirror/mode/xml/xml.js"></script>
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
						<a id="btnSubmit" class="waves-effect waves-light btn-large"><i class="mdi-action-exit-to-app left"></i>GENERATE</a>
						<br><br>
						<a id="btnClear" class="waves-effect waves-light btn-large red lighten-1"><i class="mdi-navigation-refresh left"></i>CLEAR</a>
						<br><br>
						<a id="btnHow" class="waves-effect waves-light btn-large orange lighten-1"><i class="mdi-action-help left"></i>WTF?!?</a>
					</div>
				</div>
				<div class="col s12">
				    <div class="col s8">
						<div align="center"><h6>Static Text declaration from Column Header</h6></div>
						<textarea id="txtStatic"></textarea>
					</div>
					<div class="col s4">
    					<div align="center"><h6>Field Name from Documents</h6></div>
    					<textarea id="txtFieldName"></textarea>
    				</div>
			    </div>
				<div class="col s12">
					<div align="center"><h6>Text Field declaration</h6></div>
					<textarea id="txtTextField"></textarea>
				</div>
			</div>
		</form>
		<div id="mdlHow" class="modal modal-fixed-footer">
			<div class="modal-content">
				<h4>Cại ni là cại chi</h4>
				<p>Dành riêng cho đội lười team Layout.</p>
				<h4>Cạch sự dụng</h4>
				<p><b>B1: Copy đoạn khai báo Static Text trong Column Header.</b></p>
				<p><b>Eg:</b>
				<xmp>
<staticText>
  <reportElement x="0" y="2" width="50" height="12" uuid="5c91ba75-3c04-447a-aa10-abeb88d6298f"/>
  <textElement verticalAlignment="Middle">
    <font fontName="MS Gothic" size="7"/>
  </textElement>
  <text><![CDATA[棚番]]></text>
</staticText>
<staticText>
  <reportElement x="50" y="2" width="120" height="12" uuid="9e3fab04-5b3d-4383-b59d-1ba194f2e97b"/>
  <textElement verticalAlignment="Middle">
    <font fontName="MS Gothic" size="7"/>
  </textElement>
  <text><![CDATA[品番]]></text>
</staticText>
				</xmp>
				</p>
				<p><b>B2: Copy danh sách Fields từ Documents.</b></p>
				<p><b>Eg:</b>
				<xmp>
TANANO
HINBAN
CIR_CD
MAKER_RK_NM
SALE_CD
				</xmp>
				</p>
				<p><b>B3: Nhấn GENERATE để sướng.</b></p>
			</div>
			<div class="modal-footer">
				<a class="modal-action modal-close waves-effect waves-green btn-flat ">OK</a>
			</div>
		</div>
		<script type="text/javascript">
		
			// CodeMirror
			var cmStatic = CodeMirror.fromTextArea(document.getElementById("txtStatic"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "xml",
				theme: "mbo"
			});
			cmStatic.setSize("100%", "43%");
			
			var cmTextField = CodeMirror.fromTextArea(document.getElementById("txtTextField"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				readOnly: true,
				mode: "xml",
				theme: "mbo"
			});
			cmTextField.setSize("100%", "43%");
			
			var cmFieldName = CodeMirror.fromTextArea(document.getElementById("txtFieldName"), {
				indentUnit: 4,
				lineWrapping: false,
				lineNumbers: true,
				mode: "xml",
				theme: "mbo"
			});
			cmFieldName.setSize("100%", "43%");
		
			$(document).ready(function(){
				
				setActive("#tftool");
				
				$('.control-wrapper .row').pushpin({ top: $('.control-wrapper').offset().top });

				$("#btnSubmit").click(function() {
					
					if (cmStatic.getValue() == "" || cmFieldName.getValue() == "") {
					    return;
					}
					
					var input = cmStatic.getValue();
					input = replaceAll(input, "staticText>", "textField>");
					input = replaceAll(input, "text>", "textFieldExpression>");
					
					var variables = cmFieldName.getValue().split('\n');
					
					var value1 = "<textFieldExpression>";
					var arrIndex1 = [];
					for (var i = input.indexOf(value1); i >= 0; i = input.indexOf(value1, i + 1)) {
                        arrIndex1.push(i);
                    }
                    var value2 = "</textFieldExpression>";
                    var arrIndex2 = [];
					for (var i = input.indexOf(value2); i >= 0; i = input.indexOf(value2, i + 1)) {
                        arrIndex2.push(i);
                    }
                    
                    for (var i = 0; i < arrIndex1.length; i++) {
                        
                        arrIndex1 = [];
    					for (var j = input.indexOf(value1); j >= 0; j = input.indexOf(value1, j + 1)) {
                            arrIndex1.push(j);
                        }
                        arrIndex2 = [];
    					for (var j = input.indexOf(value2); j >= 0; j = input.indexOf(value2, j + 1)) {
                            arrIndex2.push(j);
                        }
                        
                        input = input.substring(0, arrIndex1[i] + 21) 
                                + "<![CDATA[$F{" + variables[i].trim() + "}]]></textFieldExpression>"
                                + input.substring(arrIndex2[i] + 22, input.length);
                        
                    }
					
					cmTextField.setValue(input);
					
				});

				$("#btnClear").click(function() {
					
					cmStatic.setValue("");
					cmFieldName.setValue("");
					cmTextField.setValue("");
					
				});
				
				$("#btnHow").click(function() {
					$('#mdlHow').openModal();	
				});

			});
			
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
