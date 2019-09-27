

  

  <!-- JavaScript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.2.2/justgage.min.js"></script>
  <script src="./sp/js/thecore.js"></script>  
  


  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  

    <div class="container-fluid">
	<div class="row">
	<div id="testArea">
	
            <div class="col-sm"><div class="meter" id="ggdl"></div></div>
            <div class="col-sm"><div class="meter" id="ggul"></div></div>
            <div class="col-sm"><div class="meter" id="ggping"></div></div>
        </div>
		</div>
        <div>
            <a href="javascript:runTest()"   id="startBtn" class="btn btn-primary btn-lg" style="text-align: center;
display: block;
height: 36px;
width: 50%;
margin: auto;
    margin-top: auto;
background: #960933;
font-size: 35px;
margin-top: 10px;">Tester</a>
            <a href="javascript:abortTest()" id="abortBtn" class="btn btn-primary btn-lg" style="display:none;" style="text-align: center;
display: block;
height: 36px;
width: 50%;
margin: auto;
    margin-top: auto;
background: #960933;
font-size: 35px;
margin-top: 10px;">Arreter</a>
        </div>
        <br>
        <p id="ip"></p> - <p id="isp"></p>
      
      
    </div>


