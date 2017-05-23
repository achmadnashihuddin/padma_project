
<div class="main-content-inner">
	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="#">Home</a>
			</li>
			<li class="active">Dashboard </li>
		</ul>
	</div>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Dashboard 
			</h1>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="widget-box" id="widget-box-1">
					<div class="widget-header">
						<h5 class="widget-title bigger lighter">
							<i class="ace-icon glyphicon glyphicon-user"></i>
							USER VISIT
						</h5>
						<div class="widget-body">
							<div class="widget-main no-padding">
	                            <div id="list_user_visit">
									<span id="progress_visit" style="display:none"><img src="images/loading.gif" width="20" /> Please Wait... </span>	
								</div>
							</div>
						</div>
					</div>
				</div>		
			</div>
			<div class="col-sm-6">
				<div class="widget-box" id="widget-box-1">
					<div class="widget-header">
						<h5 class="widget-title bigger lighter">
							<i class="ace-icon fa fa-table"></i>
							List Ultah Karyawan
						</h5>
						<div class="widget-body">
							<div class="widget-main no-padding">
								<select class="chosen-select form-control" ng-model="model.select" required="" id="month" name="month" onchange="bulan_lahir()" style="width: 150px">
	                                <?php $month=array("January"=>"1","February"=>"2","March"=>"3","April"=>"4","Mei"=>"5","June"=>"6","July"=>"7","August"=>"8","September"=>"9","Oktober"=>"10","November"=>"11","Desember"=>"12");?>
	                                    <option value="">--Select Month--</option>  
	                                <?php foreach($month as $x=>$x_value){?>
	                                    <option value="<?php echo $x_value;?>" <?php if($x_value==date('m')){echo "selected";} ?>><?php echo $x;?></option> 
	                                <?php }?>
	                            </select>
	                            <p></p>
	                            <div id="list_ulang_tahun">
									<span id="progress_ulta" style="display:none"><img src="images/loading.gif" width="20" /> Please Wait... </span>	
								</div>
							</div>
						</div>
					</div>
				</div>		
			</div>

			<div class="col-sm-6" style="display:none;" id="visitor">
				<div class="widget-box" id="widget-box-1">
					<div class="widget-header">
						<h5 class="widget-title bigger lighter">
							<i class="ace-icon fa fa-table"></i>
							History Visitor
						</h5>
						<button class="btn btn-xs btn-danger pull-right" onclick="close_history();">
							<i class="ace-icon fa fa-times"></i>
							<span class="bigger-110"></span>
						</button>
						<div class="widget-body">
							<div class="widget-main no-padding">
								<div id="view_history_visitor"></div>
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
		<p></p>
		<div class="row">
			
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('.chosen-select').chosen(); 
	$(window)
	.off('resize.chosen')
	.on('resize.chosen', function() {
		$('.chosen-select').each(function() {
			var $this = $(this);
			$this.next().css({'width': '10%'});
		})
	}).trigger('resize.chosen');
	//resize chosen on sidebar collapse/expand

	$("#progress_ulta").show();
	$.ajax({
		type:"GET",
		url:"inc/index/get_kar_ulta.php",
		success:function(data){											
			$("#list_ulang_tahun").html(data);
			$("#progress_ulta").hide();
		},
		error:function(msg){
			alert(msg);
		}
	});	

	$("#progress_visit").show();
	$.ajax({
		type:"GET",
		url:"inc/index/get_visitor.php",
		success:function(data){											
			$("#list_user_visit").html(data);
			$("#progress_visit").hide();
		},
		error:function(msg){
			alert(msg);
		}
	});	
});
function bulan_lahir(){
	var month = $("#month").val();
	if(month != ""){
	    $("#progress_ulta").show();
	    $.ajax({
	        type:"GET",
	        url:"inc/index/view_temp_kar_ulta.php?month="+month,
	        success:function(data){               
	          	$("#progress_ulta").hide();                          
	            $("#list_ulang_tahun").html(data);
	            //$("#progress1").hide();
	        },
	        error:function(msg){
	            alert(msg);
	        }
	    });
	}
}
function close_history(){
	$("#visitor").hide();	
}
</script>
