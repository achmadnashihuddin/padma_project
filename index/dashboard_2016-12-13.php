<?php $month = array("jan"=>"01","feb"=>"02","mar"=>"03","apr"=>"04","may"=>"05","jun"=>"06", "jul"=>"07","aug"=>"08","sep"=>"09","okt"=>"10","nov"=>"11","des"=>"12");  ?>
<div class="main-content-inner">
	<div class="breadcrumbs ace-save-state" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="#">Home</a>
			</li>
			<li class="active">Dashboard HRD, Operational dan Sales</li>
		</ul>
	</div>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Dashboard HRD, Operational dan Sales
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
					<div class="widget-box transparent" id="recent-box">
						<div class="widget-header">
							<div class="widget-toolbar no-border">
								<ul class="nav nav-tabs" id="recent-tab">
									<li class="active">
										<a data-toggle="tab" href="#hrd-tab">HRD</a>
									</li>
									<li>
										<a data-toggle="tab" href="#operational-tab">OPERATIONAL</a>
									</li>
									<li>
										<a data-toggle="tab" href="#sales-tab">SALES</a>
									</li>
								</ul>
							</div>
						</div>
						
							<div class="widget-body">
								<div class="widget-main padding-4">
									<div class="tab-content padding-8">
										<div id="hrd-tab" class="tab-pane active">
											<h4 class="widget-title lighter smaller">
												<i class="ace-icon fa fa-bar-chart-o"></i> Dashboard HRD
											</h4>
											<!-- CHART ABSENSI BULANAN KARYAWAN (YTD) -->
												<script>
										            $(document).ready(function(){
										                $('#container_sia_month2').highcharts({
										                    chart: {
										                        type: 'column',
										                        events: {
										                            drilldown: function (e) {
										                                var re = /\s+/;
										                                var str = e.point.name;
										                                var results = str.split(re,1);
										                                $("#absen_kar_sia").val(results);
										                            },
										                            drillup: function (e) {
										                                //alert('drill Up');
										                                $("#absen_kar_sia").val('year');
										                            }
										                        }
										                    },
										                    title: {
										                        text: 'Absensi Bulanan Karyawan (YTD)'
										                    },
										                    xAxis: {
																type: 'category'
										                    },
										                    yAxis: {
										                        min: 0,
										                        cdepo: {
										                            text: 'Total Chart Per Month'
										                        },
										                        stackLabels: {
										                            enabled: true,
										                            style: {
										                                fontWeight: 'bold',
										                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
										                            }
										                        }
										                    },
										                    tooltip: {
										                        headerFormat: '<b>{point.x}</b><br/>',
										                        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
										                    },
										                    plotOptions: {
															 	column: {
																		stacking: 'normal',
																		pointPadding: 0.2,
																		borderWidth: 0,
																		dataLabels: {
																			enabled: true,
																			color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
																		}
																}
										                    },
										                   
															series: [{
													            name: 'SAKIT',
													            data: [
															            <?php 
																            $depo = pg_query($dbpostgre, "select * from tbdepo order by cdepo asc");
																			$nmr_sakit = 1;
																			$koma_sakit = '';
																			$num_sakit = '';
																			$nmr_skt_depo = pg_num_rows($depo);
																			while($d_depo = pg_fetch_array($depo)){
																				if($nmr_sakit!=$nmr_skt_depo){$koma_sakit=',';}else{$koma_sakit='';}
																				$sakit = mysqli_query($db_dash, "SELECT COUNT(keterangan) jml_sakit
																													FROM tbl_view_siah_karyawan
																													WHERE tahun = '".date('Y')."' AND keterangan = 'S'  AND id_depo = '".$d_depo['id']."' ");
																				$d_sakit = mysqli_fetch_array($sakit);  
																				$num_sakit.=$d_sakit['jml_sakit'].$koma_sakit;
																       	?>
																       	{
																				 name: '<?php echo $d_depo['cdepo']; ?>',
																				 y: <?php echo round( $d_sakit['jml_sakit'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo['cdepo']; ?>'
																		    }<?php echo $koma_sakit;?>		
																	<?php $nmr_sakit++; }?>
													            ],
																color : 'rgba(74,249,30,0.5)'
													        }, {
													            name: 'IJIN',
													            data: [
															            <?php 
																            $depo_ijin = pg_query($dbpostgre, "select * from tbdepo order by cdepo asc");
																			$nmr_ijin = 1;
																			$koma_ijin = '';
																			$num_ijin = '';
																			$nmr_ijin_depo = pg_num_rows($depo_ijin);
																			while($d_depo_ijin = pg_fetch_array($depo_ijin)){
																				if($nmr_ijin!=$nmr_ijin_depo){$koma_ijin=',';}else{$koma_ijin='';}
																				$ijin = mysqli_query($db_dash, "SELECT COUNT(keterangan) jml_ijin
																													FROM tbl_view_siah_karyawan
																													WHERE tahun = '".date('Y')."' AND keterangan = 'I' AND id_depo = '".$d_depo_ijin['id']."' ");
																				$d_ijin = mysqli_fetch_array($ijin);  
																				$num_ijin.=$d_ijin['jml_ijin'].$koma_ijin;
																       	?>
																       	{
																				 name: '<?php echo $d_depo_ijin['cdepo']; ?>',
																				 y: <?php echo round( $d_ijin['jml_ijin'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo_ijin['cdepo']; ?>'
																		    }<?php echo $koma_ijin;?>		
																	<?php $nmr_ijin++; }?>
													            ],
																color :'rgba(246,246,15,0.5)'
													        }, {
													            name: 'ALPA',
													            data: [
															            <?php 
																            $depo_alpa = pg_query($dbpostgre, "select * from tbdepo order by cdepo asc");
																			$nmr_alpa = 1;
																			$koma_alpa = '';
																			$num_alpa = '';
																			$nmr_alpa_depo = pg_num_rows($depo_alpa);
																			while($d_depo_alpa = pg_fetch_array($depo_alpa)){
																				if($nmr_alpa!=$nmr_alpa_depo){$koma_alpa=',';}else{$koma_alpa='';}
																				$ijin = mysqli_query($db_dash, "SELECT COUNT(keterangan) jml_alpa
																													FROM tbl_view_siah_karyawan
																													WHERE tahun = '".date('Y')."' AND keterangan = 'A' AND id_depo = '".$d_depo_alpa['id']."'");
																				$d_alpa = mysqli_fetch_array($ijin);  
																				$num_alpa.=$d_alpa['jml_alpa'].$koma_alpa;
																       	?>
																       	{
																				 name: '<?php echo $d_depo_alpa['cdepo']; ?>',
																				 y: <?php echo round( $d_alpa['jml_alpa'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo_alpa['cdepo']; ?>'
																		    }<?php echo $koma_alpa;?>		
																	<?php $nmr_alpa++; }?>
													            ],
																color :'rgba(246,15,46,0.7)'
													        }, {
													            name: 'HADIR',
													            data: [
															            <?php 
																            $depo_hadir = pg_query($dbpostgre, "select * from tbdepo order by cdepo asc");
																			$nmr_hadir = 1;
																			$koma_hadir = '';
																			$num_hadir = '';
																			$nmr_hadir_depo = pg_num_rows($depo_hadir);
																			while($d_depo_hadir = pg_fetch_array($depo_hadir)){
																				if($nmr_hadir!=$nmr_hadir_depo){$koma_hadir=',';}else{$koma_hadir='';}
																				$hadir = mysqli_query($db_dash, "SELECT COUNT(keterangan) jml_hadir
																													FROM tbl_view_siah_karyawan
																													WHERE tahun = '".date('Y')."' AND keterangan = 'HADIR' AND id_depo = '".$d_depo_hadir['id']."'");
																				$d_hadir = mysqli_fetch_array($hadir);  
																				$num_hadir.=$d_hadir['jml_hadir'].$koma_hadir;
																       	?>
																       	{
																				 name: '<?php echo $d_depo_hadir['cdepo']; ?>',
																				 y: <?php echo round( $d_hadir['jml_hadir'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo_hadir['cdepo']; ?>'
																		    }<?php echo $koma_hadir;?>		
																	<?php $nmr_hadir++; }?>
													            ],
																color :'rgba(251, 153, 255,0.7)'
													        }]
															
										                });
										            });
										        </script> 
												<div id="container_sia_month2"></div>
											<!-- END -->
											<div class="hr hr32 hr-dotted"></div>
											<!-- CHART TOTAL KARYAWAN (TETAP+OUTSOURCE) -->
												<script>
										            $(document).ready(function(){
										                $('#container_sia_tetap_outsource').highcharts({
										                    chart: {
										                        type: 'column',
										                        events: {
										                            drilldown: function (e) {
										                                var re = /\s+/;
										                                var str = e.point.name;
										                                var results = str.split(re,1);
										                                $("#absen_kar_sia").val(results);
										                            },
										                            drillup: function (e) {
										                                //alert('drill Up');
										                                $("#absen_kar_sia").val('year');
										                            }
										                        }
										                    },
										                    title: {
										                        text: 'Total Karyawan (Tetap + OutSource)'
										                    },
										                    xAxis: {
																type: 'category'
										                    },
										                    yAxis: {
										                        min: 0,
										                        cdepo: {
										                            text: 'Total Chart Per Month'
										                        },
										                        stackLabels: {
										                            enabled: true,
										                            style: {
										                                fontWeight: 'bold',
										                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
										                            }
										                        }
										                    },
										                    tooltip: {
										                        headerFormat: '<b>{point.x}</b><br/>',
										                        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
										                    },
										                    plotOptions: {
															 	column: {
																		stacking: 'normal',
																		pointPadding: 0.2,
																		borderWidth: 0,
																		dataLabels: {
																			enabled: true,
																			color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
																		}
																}
										                    },
										                   
															series: [
													        {
													            name: 'TETAP',
													            data: [
															            <?php 
																	        $depo_tetap = mysqli_query($db_depo, "select * from tbdepo order by cdepo asc");
																			$nmr_tetap = 1;
																			$koma_tetap = '';
																			$num_tetap = '';
																			$nmr_tetap_depo = mysqli_num_rows($depo_tetap);
																			while($d_depo_tetap = mysqli_fetch_array($depo_tetap)){
																				if($nmr_tetap!=$nmr_tetap_depo){$koma_tetap=',';}else{$koma_tetap='';}
																				$tetap = mysqli_query($db_depo, "SELECT COUNT(id) jlh_peg_eks FROM tbkaryawan WHERE cactive = 'Y' AND iddepo = '".$d_depo_tetap['id']."'");
																				$d_tetap = mysqli_fetch_array($tetap);  
																				$num_tetap.=$d_tetap['jlh_peg_eks'].$koma_tetap;
																	   	?>
																	   		{
																				 name: '<?php echo $d_depo_tetap['cdepo']; ?>',
																				 y: <?php echo round( $d_tetap['jlh_peg_eks'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo_tetap['cdepo']; ?>_tetap'
																		    }<?php echo $koma_tetap;?>		
																	<?php $nmr_tetap++; }?>
													            ],
																color :'rgba(246,246,15,0.5)'
													        }, {
													            name: 'OUTSOURCE',
													            data: [
															            <?php 
																	        $depo_out = mysqli_query($db_depo, "select * from tbdepo order by cdepo asc");
																			$nmr_out = 1;
																			$koma_out = '';
																			$num_out = '';
																			$nmr_out_depo = mysqli_num_rows($depo_out);
																			while($d_depo_out = mysqli_fetch_array($depo_out)){
																				if($nmr_out!=$nmr_out_depo){$koma_out=',';}else{$koma_out='';}
																				$out = mysqli_query($db_depo, "SELECT COUNT(b.l2) jlh_peg_outsource
															                                                    FROM table_master_data_opt a
															                                                    LEFT JOIN table_master_detail_opt b ON b.id_report = a.id_report
															                                                    WHERE a.depo = '".$d_depo_out['id']."' AND a.divisi = 'hrd' AND a.level_report = '1'");
																				$d_out = mysqli_fetch_array($out);  
																				$num_out.=$d_out['jlh_peg_outsource'].$koma_out;
																	   	?>
																	   		{
																				 name: '<?php echo $d_depo_out['cdepo']; ?>',
																				 y: <?php echo round( $d_out['jlh_peg_outsource'],2) ; ?>,
																				 drilldown: '<?php echo $d_depo_out['cdepo']; ?>'
																		    }<?php echo $koma_out;?>		
																	<?php $nmr_out++; }?>
													            ],
																color :'rgba(246,15,46,0.7)'
													        }],
															drilldown: {
																series: [
																 	<?php 
																        $depo_tetap_drill = mysqli_query($db_depo, "select * from tbdepo order by cdepo asc");
																		$nmr_tetap_drill = 1;
																		$koma_tetap_drill = '';
																		$num_tetap_drill = '';
																		$nmr_tetap_drill_depo = mysqli_num_rows($depo_tetap_drill);
																		while($d_depo_tetap = mysqli_fetch_array($depo_tetap_drill)){
																			if($nmr_tetap_drill!=$nmr_tetap_drill_depo){$koma_tetap_drill=',';}else{$koma_tetap_drill='';}
																			
																   	?>
																		{
																			name: 'TETAP',
																			id: '<?php echo $d_depo_tetap['cdepo']; ?>_tetap',
																		}<?php echo $koma_tetap_drill;?>		
																	<?php $nmr_tetap_drill++; }?>
																]
															}
										                });
										            });
										        </script> 
												<div id="container_sia_tetap_outsource"></div>
											<!-- END -->
										</div>
										<div id="operational-tab" class="tab-pane">
											<h4 class="widget-title lighter smaller">
												<i class="ace-icon fa fa-bar-chart-o"></i> Dashboard OPERATIONAL
											</h4>
											<div id="chart_gasolinee"></div>
											<span id="progress1" style="display:none"><img src="images/loading.gif" width="20" /> Please Wait... </span>
										</div>
										<div id="sales-tab" class="tab-pane">
											sales dashboard
										</div>
									</div>
								</div>
							</div>
					
					</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() {
    	$("#progress1").show();
	    $.ajax({
			type:"GET",
			url:"inc/operational/get_opt_dashboard.php",
			success:function(data){
				$("#chart_gasolinee").html(data);
				$("#progress1").hide();
			},
			error:function(msg){
				//alert(msg);
			}
		});
    });
</script>