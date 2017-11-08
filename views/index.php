<div class="row">
	<div class="col-lg-12">
		<form class="row" name="calculator" style="width:500px !important; margin:0 auto;">
			<div class="col-lg-8">
				<div class="row">
					<input type="textfield" class="col-lg-12 form-control" id="currentNum" value ="200109"/>
					<br/>
					<br/>
					<br/>
					<input type="textfield" class="col-lg-12 form-control" id="NoTujuan" name="ans" placeholder="Auto Fill Out / In Number On click" />
					<input type="button" class="col-lg-4 btn btn-default" value="1" onClick="document.calculator.ans.value+='1'">
					<input type="button" class="col-lg-4 btn btn-default" value="2" onClick="document.calculator.ans.value+='2'">
					<input type="button" class="col-lg-4 btn btn-default" value="3" onClick="document.calculator.ans.value+='3'">
					 
					<input type="button" class="col-lg-4 btn btn-default" value="4" onClick="document.calculator.ans.value+='4'">
					<input type="button" class="col-lg-4 btn btn-default" value="5" onClick="document.calculator.ans.value+='5'">
					<input type="button" class="col-lg-4 btn btn-default" value="6" onClick="document.calculator.ans.value+='6'">
					 
					<input type="button" class="col-lg-4 btn btn-default" value="7" onClick="document.calculator.ans.value+='7'">
					<input type="button" class="col-lg-4 btn btn-default" value="8" onClick="document.calculator.ans.value+='8'">
					<input type="button" class="col-lg-4 btn btn-default" value="9" onClick="document.calculator.ans.value+='9'">

					<input type="button" class="col-lg-4 btn btn-default" value="*" onClick="document.calculator.ans.value+='*'">					 
					<input type="button" class="col-lg-4 btn btn-default" value="0" onClick="document.calculator.ans.value+='0'">
					<input type="button" class="col-lg-4 btn btn-default" value="#" onClick="document.calculator.ans.value+='*'">

				</div><br/><br/>
			</div>
			<div class="col-lg-4">
				<input type="button" class="btn btn-primary btn-block" value="CALL" onclick="actionCall();"/>
				<input type="button" class="btn btn-primary btn-block" value="Release" onclick="actionRelease();"/>
				<input type="button" class="btn btn-danger btn-block" value="Disconnect Call" onclick="actionDisconnect();"/>
				<!-- <input type="button" class="btn btn-warning btn-block" value="ACW" onclick=""/>
				<input type="button" class="btn btn-info btn-block" value="AVAIL MANUAL" onclick=""/>
				<input type="button" class="btn btn-success btn-block" value="AVAIL AUTOIN" onclick=""/> -->
			</div>
		</form>

		<code>
			<h1>Respons Will Be Here</h1>
			<pre id="respons">
				
			</pre>
		</code>
	</div>
</div>