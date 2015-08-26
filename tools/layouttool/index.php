<html>
<head>
	<title>Heyvin's Tools</title>
	<script src="/js/jquery-1.11.2.min.js"></script>
	<link rel="stylesheet" href="/css/materialize.css">
	<meta http-equiv="Content-Type" content="text/html;charset=Shift-JIS">
	<!-- CodeMirror Dependencies -->
	<script src="/tools/codemirror/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/tools/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="/tools/codemirror/theme/mbo.css"></link>
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
		<p><h3>Parameters</h3></p>
        <p>Example: (Copy the content below and paste into the textarea)</p> <span id="example1"></span>
        <div class="row">
            <div class="col s5">
                <textarea id="input" style="width:400px; height:300px"></textarea>
            </div>
            <div class="col s2" style="padding-left: 30px">
                <a id="convert" class="waves-effect waves-light btn">Convert</a>
            </div>
            <div class="col s5">
                <textarea id="output" style="width:400px; height:300px"></textarea>
            </div>
        </div>
        <br/><br/>
        <p><h3>Fields</h3></p>
        <p>Example: (Copy the content below and paste into the textarea)</p> <span id="example2"></span>
        <div class="row">
            <div class="col s5">
                <textarea id="input2" style="width:400px; height:300px"></textarea>
            </div>
            <div class="col s2" style="padding-left: 30px">
                <a id="convert2" class="waves-effect waves-light btn">Convert</a>
            </div>
            <div class="col s5">
                <textarea id="output2" style="width:400px; height:300px"></textarea>
            </div>
        </div>
        <br/><br/>
        <p><h3>Parameters in Model</h3></p>
        <p>Example: (Copy the content below and paste into the textarea)</p> <span id="example3"></span>
        <div class="row">
            <div class="col s5">
                <textarea id="input3" style="width:400px; height:300px"></textarea>
            </div>
            <div class="col s2" style="padding-left: 30px">
                <a id="convert3" class="waves-effect waves-light btn">Convert</a>
            </div>
            <div class="col s5">
                <textarea id="output3" style="width:400px; height:300px"></textarea>
            </div>
        </div>
        
		<script type="text/javascript">
		
		    function ConvertParameters() {
                var lines = $("#input").val().split("\n");
                var output = "";
                for(var i = 0; i < lines.length; i++) {
                    output += '<parameter name="'+lines[i]+'" class="java.lang.String"/>\n';
                }
                
                $("#output").val(output);
            }
            
            function ConvertFields() {
                var lines = $("#input2").val().split("\n");
                var output = "";
                for(var i = 0; i < lines.length; i++) {
                    var description = lines[i].split("	")[0];
                    var name = lines[i].split("\t")[1];
                    output += '<field name="'+name+'" class="java.lang.String">\n' + '\t<fieldDescription><![CDATA['+name+']]></fieldDescription>\n' + '</field>\n';
                }
                
                $("#output2").val(output);
            }
            
            function ConvertParametersInModel() {
                var lines = $("#input3").val().split("\n");
                var output = "";
                for(var i = 0; i < lines.length; i++) {
                    var description = lines[i].split("	")[0];
                    var name = lines[i].split("\t")[1];
                    output += 'public String '+name+'; // '+description+'\n';
                }
                
                $("#output3").val(output);
            }
            
            $(document).ready(function() { 
                setActive("#layouttool");
                $("#example1").html("fldNYKYT_DATE<br/>fldSIR_CD</br>fldSIR_RKNM</br/></br/>");
            	$("#example2, #example3").html("<table style='width:400px'>"+
                                        "<tr><td>入荷予定日</td><td>fldNYKYT_DATE</td></tr>"+
                                        "<tr><td>仕入先コード</td><td>fldSIR_CD</td></tr>"+
                                        "<tr><td>仕入先名</td><td>fldSIR_RKNM</td></tr>"+
                                    "</table>");
                
                $("#convert").click(function() {
                    ConvertParameters();
                });
                $("#convert2").click(function() {
                    ConvertFields();
                });
                $("#convert3").click(function() {
                    ConvertParametersInModel();
                });
            });
			
		</script>
	</div>
</body>
</html>