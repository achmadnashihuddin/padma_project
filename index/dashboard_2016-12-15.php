<?php 
	if(isset($_GET['act']) and $_GET['act']=='see_detail'){
		include "inc/sales/see_detail_sales_dashboard.php";
	}else if(isset($_GET['act']) and $_GET['act']=='see_detail_bpjs'){
		include "inc/index/see_detail_bpjs.php";
	}else if(isset($_GET['act']) and $_GET['act']=='list_peg_uncovered'){
		include"inc/index/view_list_karyawan_bpjs.php";
	}else if(isset($_GET['act']) and $_GET['act']=='list_peg_covered'){
		include"inc/index/view_list_karyawan_bpjs.php";
	}
	else{	
?>
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
					<div class="tabbable">
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

						<div class="tab-content">
							<div id="hrd-tab" class="tab-pane active">
								<h4 class="widget-title lighter smaller">
									<i class="ace-icon fa fa-bar-chart-o"></i> Dashboard HRD
								</h4>
								<!-- LIST KARYAWAN ULTA -->
									<div class="row">
										<div class="col-sm-3">
											<div class="widget-box" id="widget-box-1">
												<div class="widget-header">
													<h5 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-table"></i>
														List Ulta Karyawan
													</h5>
													<div class="widget-body">
														<div class="widget-main no-padding">
															<select class="chosen-select form-control" ng-model="model.select" required="" id="month" name="month" onchange="bulan_lahir()" style="width: 150px">
								                                <?php $month=array("January"=>"01","February"=>"02","March"=>"03","April"=>"04","Mei"=>"05","June"=>"06","July"=>"07","August"=>"08","September"=>"09","Oktober"=>"10","November"=>"11","Desember"=>"12");?>
								                                    <option value="">--Select Month--</option>  
								                                <?php foreach($month as $x=>$x_value){?>
								                                    <option value="<?php echo $x_value;?>" <?php if($x_value==date('m')){echo "selected";} ?>><?php echo $x;?></option> 
								                                <?php }?>
								                            </select>
								                            <span id="progress_ulta" style="display:none"><img src="images/loading.gif" width="20" /> Please Wait... </span>	
								                            <p></p>
								                            <div class="scroll_user" id="list_ulang_tahun">
																<?php 
									                                $active = "'Y'";
									                                $sql_ultah = 'SELECT k.dtgllahir, extract(doy from k.dtgllahir), k.cnama, k.*, d.cdepo 
									                                                FROM tbkaryawan as k 
									                                                inner join tbdepo as d on k.iddepo = d.id 
									                                                where extract(doy from k.dtgllahir)+1 >=  extract(doy from now()) and k.cactive ='.$active.' 
									                                                order by EXTRACT(month FROM "dtgllahir") asc, EXTRACT(day FROM "dtgllahir") asc';
									                               
									                                $ultah = pg_query($dbpostgre,$sql_ultah);
									                                $ultah_now = '';
									                                $bsk = date('m-d', strtotime("+1 days"));
									                                while ($dultah = pg_fetch_array($ultah)) {
										                                if(date("m-d", strtotime($dultah['dtgllahir']))==date('m-d', strtotime("+1 days"))){
										                                    $ultah_now='Besok';
										                                }else if(date("m-d", strtotime($dultah['dtgllahir']))==date('m-d', strtotime("-1 days"))){
										                                    $ultah_now='Kemarin';
										                                }else if(date("m-d", strtotime($dultah['dtgllahir']))==date('m-d')){
										                                   $ultah_now='Hari Ini';
										                                }else{
										                                  $ultah_now = date("d-M", strtotime($dultah['dtgllahir']));
										                                }
									                            ?>
										                         
									                            		<div id="profile-feed-1" class="profile-feed">
									                            			<div class="profile-activity clearfix">
									                            				<?php 
											                                        $lokasi_foto = "images/employee/".$dultah['nik'].".jpg";
											                                        if(file_exists($lokasi_foto)){
											                                    ?>
																						<img class="pull-left" src="http://www.padmatirtagroup.com/dashboard_old/images/employee/<?php echo $dultah['nik'].".jpg";?>" />
																				<?php }else{?>
											                                       		<img class="pull-left" src="http://www.padmatirtagroup.com/dashboard_old/images/ultah.jpg">
											                                    <?php }?>
																				<a class="user" href="#"> <?php echo $dultah['cnama'];?> </a>
																				
																				<div class="time">
																					<i class="ace-icon fa fa-clock-o bigger-110"></i>
																					<?php echo $dultah['cdepo']." ( ".$ultah_now." ) ";?>
																				</div>
																			</div>
									                            		</div>
									                            <?php }?> 
															</div>
														</div>
													</div>
												</div>
											</div>															
				                        </div>
			                        </div>
								<!-- END -->
								<!-- CHART BPJS -->
									<script>
							            $(document).ready(function(){
							                $('#container_bpjs').highcharts({
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
							                        text: 'Total Karyawan (BPJS)'
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
										            name: 'BELUM IKUT',
										            data: [
												            <?php 
														        $depo = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
																$nmr_blm_ikut = 1;
																$koma_blm_ikut = '';
																$num_blm_ikut = '';
																$nmr_skt_depo = pg_num_rows($depo);
																while($d_depo = pg_fetch_array($depo)){
																	if($nmr_blm_ikut!=$nmr_skt_depo){$koma_blm_ikut=',';}else{$koma_blm_ikut='';}
																	$chart_bpjs = pg_query($dbpostgre, "SELECT 
																									        (SELECT count(*) from tbkaryawan where cnojamsostek ='' and cactive='Y' and iddepo = '".$d_depo['id']."') as uncover,
																									        (SELECT count(*) from tbkaryawan where cnojamsostek is null and cactive='Y' and iddepo = '".$d_depo['id']."') as uncover2,
																									        (SELECT count(*) from tbkaryawan where cactive='Y' and iddepo = '".$d_depo['id']."')as tot_karyawan
																									        from tbkaryawan where iddepo = '".$d_depo['id']."'  group by uncover");  
															        $dchart_bpjs = pg_fetch_array($chart_bpjs);
															        $uncover = $dchart_bpjs['uncover']+$dchart_bpjs['uncover2'];																       
														   	?>
														   	{
																	name: '<?php echo $d_depo['cdepo']; ?>',
																	y: <?php echo round($uncover,2) ; ?>,
																	drilldown: '<?php echo $d_depo['cdepo']; ?>'
															    }<?php echo $koma_blm_ikut;?>		
														<?php $nmr_blm_ikut++; }?>
										            ],
													color : 'rgba(246,15,46,0.7)'
										        }, {
										            name: 'SUDAH IKUT',
										            data: [
												            <?php 
														        $depo = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
																$nmr_sdh_ikut = 1;
																$koma_sdh_ikut = '';
																$num_sdh_ikut = '';
																$nmr_skt_depo = pg_num_rows($depo);
																while($d_depo = pg_fetch_array($depo)){
																	if($nmr_sdh_ikut!=$nmr_skt_depo){$koma_sdh_ikut=',';}else{$koma_sdh_ikut='';}
																	$chart_bpjs = pg_query($dbpostgre, "SELECT 
																									        (select count(*) from tbkaryawan where cnojamsostek !='' and cactive='Y' and iddepo = '".$d_depo['id']."') as covered,
																									        (SELECT count(*) from tbkaryawan where cactive='Y' and iddepo = '".$d_depo['id']."')as tot_karyawan
																									        from tbkaryawan where iddepo = '".$d_depo['id']."'  group by covered");  
															        $dchart_bpjs = pg_fetch_array($chart_bpjs);
															        //$uncover = $dchart_bpjs['uncover']+$dchart_bpjs['uncover2'];																       
														   	?>
														   	{
																	name: '<?php echo $d_depo['cdepo']; ?>',
																	y: <?php echo round($dchart_bpjs['covered'],2) ; ?>,
																	drilldown: '<?php echo $d_depo['cdepo']; ?>'
															    }<?php echo $koma_sdh_ikut;?>		
														<?php $nmr_sdh_ikut++; }?>
										            ],
													color :'rgba(74,249,30,0.5)'
										        }]
							                });
							            });
							        </script> 
									<div class="table-responsive">
										<div id="container_bpjs" class="col-xs-12"></div>
										<span style="float:right;margin-right:10px"> <a href="?page=dashboard&act=see_detail_bpjs"><font color="blue" size="2">See Detail</font></a></span>
									</div>
								<!-- END -->
								<div class="hr hr32 hr-dotted"></div>
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
													            $depo = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
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
													            $depo_ijin = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
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
													            $depo_alpa = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
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
													            $depo_hadir = pg_query($dbpostgre, "SELECT * from tbdepo order by cdepo asc");
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
									<div class="table-responsive"><div id="container_sia_month2" class="col-xs-12"></div></div>
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
														        $depo_tetap = mysqli_query($db_depo, "SELECT * from tbdepo order by cdepo asc");
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
														        $depo_out = mysqli_query($db_depo, "SELECT * from tbdepo order by cdepo asc");
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
													        $depo_tetap_drill = mysqli_query($db_depo, "SELECT * from tbdepo order by cdepo asc");
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
									<div class="table-responsive"><div id="container_sia_tetap_outsource" class="col-xs-12"></div></div>
								<!-- END -->
							</div>

							<div id="operational-tab" class="tab-pane">
								<h4 class="widget-title lighter smaller">
									<i class="ace-icon fa fa-bar-chart-o"></i> Dashboard OPERATIONAL
								</h4>
						        <div class="row">
							        <div class="col-sm-3">
								        <label>SELECT Year </label>
										<SELECT class="chosen-SELECT form-control" name="slc_years" id="slc_years" data-placeholder="Choose a State..." onchange="view_chart_gasolinee()">
											<?php 
												$tahun1 = date('Y')-5;
												$tahun2 = date('Y')+5;
												for($i=$tahun1;$i<=date('Y');$i++){
											?>
												<option value="<?php echo $i;?>" <?php if($i==date('Y')){?>SELECTed <?php }?>><?php echo $i;?></option>
											<?php }?>	
										</SELECT>
										<span id="progress_view" style="display:none"><img src="images/loading.gif" width="20" /> Please Wait... </span>		
									</div>
								</div>
						        
					        	<div class="row">
				        			<div class="table-responsive">
				        				<div id="view_gasoline"> 
				        					<div id="chart_gasolinee"></div>
				        				</div>
				        			</div>
					        	</div>
							</div>

							<div id="sales-tab" class="tab-pane">
								<h4 class="widget-title lighter smaller">
									<i class="ace-icon fa fa-bar-chart-o"></i> Dashboard SALES
								</h4>
								<div class="row">
							        <div class="col-sm-3">
								        <label>Entity :</label>
										<?php $slc_entity = mysqli_query($dbpdc,"SELECT DISTINCT asal2 FROM tb_masking_lokasi ORDER BY asal2 ASC");
											$slc_depo = mysqli_query($dbpdc,"SELECT DISTINCT depo FROM tb_masking_lokasi ORDER BY depo ASC");
										?>
										<SELECT class="form-control control" ng-model="model.SELECT" required="" id="slc_entity" onchange="get_depo(this.value)">
											<option value="">--All Entity--</option>
											<?php while($dentity = mysqli_fetch_array($slc_entity)){?>
											
											 <option value="<?php echo $dentity['asal2'];?>"><?php echo $dentity['asal2'];?></option>
											 
											<?php }?>
										</SELECT>

										<label>Depo :</label>
										<?php $slc_entity = mysqli_query($dbpdc,"SELECT DISTINCT asal2 FROM tb_masking_lokasi ORDER BY asal2 ASC");
											$slc_depo = mysqli_query($dbpdc,"SELECT DISTINCT depo FROM tb_masking_lokasi ORDER BY depo ASC");
										?>
										<SELECT class="form-control control" ng-model="model.SELECT" required="" id="slc_depo">
											<option value="">--All Depo--</option>
											<?php while($ddepo = mysqli_fetch_array($slc_depo)){?>
												<option value="<?php echo $ddepo['depo'];?>"><?php echo $ddepo['depo'];?></option>
											<?php }?>
										</SELECT>
										<p></p>
										<input type="button" class="btn btn-primary" onclick="view_saless()" value="View Report">	
										<div id="progress_views" style="display:inline;visibility: hidden;"><img src="images/loading.gif" width="20" id="loader"/> Loading...</div>	
									</div>
								</div>
								<div class="row">
				        			<div class="table-responsive">
				        				<div id="view_sales"> 
				        					<div id="sales_peryear"></div>
				        				</div>
				        			</div>
					        	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<style type="text/css">
	.scroll_user{
	    border: 1px solid #ccc;
	    height: 210px;
	    padding: 10px;
	    overflow-y:scroll;
	}
</style>	
<script>
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
function get_depo(depo){
	//alert(depo);
	var act = 'get_depo';
	$("#progress").css("visibility","visible");
	$.ajax({
		type:"GET",
		url:"inc/sales/get_option.php?act="+act+"&depo="+depo,
		success:function(data){
			//alert("Data Berhasil Disimpan");
			$("#slc_depo").html(data);
			$("#progress").css("visibility","hidden");
		},
		error:function(msg){
			alert(msg);
		}
	});
}
function view_saless(){
	var slc_entity = $("#slc_entity").val();
	var slc_depo = $("#slc_depo").val();
	$("#progress_views").css("visibility","visible");
	$.ajax({
		type:"GET",
		url:"inc/sales/get_view_sales.php?entity="+encodeURIComponent(slc_entity)+"&depo="+slc_depo,
		success:function(data){
			//alert("Data Berhasil Disimpan");
			$("#view_sales").html(data);
			$("#progress_views").css("visibility","hidden");
		},
		error:function(msg){
			alert(msg);
		}
	});
}
function view_chart_gasolinee(){
    var slc_years = $("#slc_years").val();	
	//alert(judul_report);
	$("#progress_view").show();
	$.ajax({
		type:"GET",
		url:"inc/operational/view_chart_gasoline.php?year="+slc_years,
		success:function(data){			
			$('#view_gasoline').html(data);	
			$("#progress_view").hide();
		},
		error:function(msg){
			alert(msg);
		}
	});
	//alert(slc_years);
}
$(document).ready(function() {
	$("#progress_view").show();
    $.ajax({
		type:"GET",
		url:"inc/operational/get_opt_dashboard.php",
		success:function(data){
			$("#chart_gasolinee").html(data);
			$("#progress_view").hide();
		},
		error:function(msg){
			//alert(msg);
		}
	});

    $("#progress_views").css("visibility","visible");
	$.ajax({
		type:"GET",
		url:"inc/sales/get_sales_dashboard.php",
		success:function(data){
			$("#view_sales").html(data);
			$("#progress_views").css("visibility","hidden");
		},
		error:function(msg){
			//alert(msg);
		}
	});
	if(!ace.vars['touch']) {
		$('.chosen-select').chosen({allow_single_deselect:true}); 				
	}
	$(".messages").animate({ scrollTop: $(document).height() }, "slow");
  	return false;
});
</script>
<?php }?>