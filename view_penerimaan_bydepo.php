<?php
include('../../lib/db_sqlserver2.php');
include('../../lib/fungsi_rupiah.php');
include('../format/function_workingday.php');
?>
<script>
$(document).ready(function(){
	MergeCommonRows($('#list_emp'));
	fix_thead();
});
function MergeCommonRows(table) {
	//alert(table)
	var firstColumnBrakes = [];
	// iterate through the columns instead of passing each column as function parameter:
	for(var i=1; i<=table.find('th').length; i++){
		var previous = null, cellToExtend = null, rowspan = 1;
		//table.find("td:nth-child(" + i + ")").each(function(index, e){
		table.find(".td_l1:nth-child(" + i + ")").each(function(index, e){
			var jthis = $(this), content = jthis.text();
			//alert(content);
			// check if current row "break" exist in the array. If not, then extend rowspan:
			if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1 && typeof content === "string") {
				// hide the row instead of remove(), so the DOM index won't "move" inside loop.
				jthis.addClass('hidden');
				cellToExtend.attr("rowspan", (rowspan = rowspan+1));
			}else{
				// store row breaks only for the first column:
				if(i === 1) firstColumnBrakes.push(index);
				rowspan = 1;
				previous = content;
				cellToExtend = jthis;
			}
		});
		
	}
	// now remove hidden td's (or leave them hidden if you wish):
	$('td.hidden').remove();
}

function fix_thead(){
	var $table = $('#list_emp');
	 $table.floatThead({
		responsiveContainer: function($table){
        return $table.closest('.table-responsive');
		},
		position : 'absolute'
		 
	});
}

</script>
<?php 
	
	$sku = '';
	if($_GET['sku']==""){
		$sku = '';
	}else{
		$sku = " and a.szProductName = '".$_GET['sku']."' ";
	}
	$entity = '';
	if($_GET['entity']==""){
		$entity = '';
	}else{
		$entity = " and b.asal2 in(".$_GET['entity'].") ";
	}
	$depo = '';
	if($_GET['depo']==""){
		$depo = '';
	}else{
		$depo = " and b.depo = '".$_GET['depo']."' ";
	}
	$brand = '';
	if($_GET['brand']==""){
		$brand = '';
	}else{
		$brand = " and a.szProductCategory = '".$_GET['brand']."' ";
	}
	
	


$year_before = $_GET['tahun']-1;
$ulang1=0;
$hapus='';

	$sql_vol = "SELECT 	 
			 		b.asal2,b.depo,a.szProductCategory,a.szProductName,  ";
?>
<table class="table  table-bordered table-hover" id="list_emp">
	<thead>
		<tr>	
			<th style="vertical-align:middle; text-align:center; " rowspan="2">Entity</th>
			<th style="vertical-align:middle; text-align:center; " rowspan="2">Depo</th>
			<th style="vertical-align:middle; text-align:center; " rowspan="2">Principle</th>
			<th style="vertical-align:middle; text-align:center; " rowspan="2">Product</th>				
			<?php 
			if($_GET['jenis_lap']=="monthly"){
				$month=array("jan"=>"01","feb"=>"02","mar"=>"03","apr"=>"04","may"=>"05","jun"=>"06","jul"=>"07","aug"=>"08","sep"=>"09","oct"=>"10","nov"=>"11","dec"=>"12");
				if($_GET['tahun']==date('Y')){
				$this_month1 = date('n');
				}else{
					$this_month1 = 12;
				}
			if($_GET['tahun']==date('Y')){
				//$sql_vol .=" SUM(CASE WHEN szYear ='".$year_before."' THEN szStokKeluar ELSE 0 END) AS vol_year_before, ";
			?>
			
			<?php 
			}
			foreach($month as $x=>$x_value){
			  if($x_value <= $this_month1){
				${'total'.$x_value} = '';
				if($x_value!=$this_month1){$koma_bulan=',';}else{$koma_bulan = '';}
				$sql_vol .= "SUM(CASE WHEN DATEPART(month, dtmTransaction) ='".$x_value."' and DATEPART(year, dtmTransaction) ='".$_GET['tahun']."' THEN szStokMasuk ELSE 0 END) AS sm_".$x.",";
				$sql_vol .= "SUM(CASE WHEN DATEPART(month, dtmTransaction) ='".$x_value."' and DATEPART(year, dtmTransaction) ='".$_GET['tahun']."' THEN szStokKeluar ELSE 0 END) AS sk_".$x.$koma_bulan;
			?>
			<th style="vertical-align:middle; text-align:center; " colspan="2"><?php echo $x; ?></th>
			<?php } 
			}//end for each monthly?>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Total</th>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Average</th>
			<?php if($_GET['tahun']==date('Y')){?>
			
			<?php 
				$sql_vol .=" from View_BOSNET_btb_bkb as a inner join dbo.table_masking_lokasi as b 
							 on a.szWorkplaceId = b.szWorkplaceId COLLATE DATABASE_DEFAULT
							where  DATEPART(year, dtmTransaction) = '".$_GET['tahun']."' ".$entity." ".$depo."  ".$sku." ".$brand." 
							group by b.asal2,b.depo,a.szProductCategory,a.szProductName with rollup 
							";
			}else{
				$sql_vol .=" from View_BOSNET_btb_bkb as a inner join dbo.table_masking_lokasi as b 
							 on a.szWorkplaceId = b.szWorkplaceId COLLATE DATABASE_DEFAULT
							where  DATEPART(year, dtmTransaction) = '".$_GET['tahun']."' ".$entity." ".$depo."  ".$sku." ".$brand." 
							group by b.asal2,b.depo,a.szProductCategory,a.szProductName with rollup 
							 ";
			}
			}//end if monthly
			if($_GET['jenis_lap']=="weekly"){
				$koma_week = '';
				$i = 12; 
				while ($i >=1) {
					if($i!=1){$koma_week = ',';}else{$koma_week = '';}
				$sql_vol .= "SUM(CASE WHEN DATEPART(week, dtmTransaction) ='".date('W', strtotime("-$i week"))."' and DATEPART(year, dtmTransaction) ='".date('Y', strtotime("-$i week"))."' THEN szStokMasuk ELSE 0 END) AS sm_week".$i.",";
				$sql_vol .= "SUM(CASE WHEN DATEPART(week, dtmTransaction) ='".date('W', strtotime("-$i week"))."' and DATEPART(year, dtmTransaction) ='".date('Y', strtotime("-$i week"))."' THEN szStokKeluar ELSE 0 END) AS sk_week".$i.$koma_week;	
			?>
			<th style="vertical-align:middle; text-align:center; " colspan="2" ><?php echo date('W-Y', strtotime("-$i week"));?></th>
			<?php $i--;}?>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Total</th>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Average</th>
			<?php 
				$sql_vol .=" from View_BOSNET_btb_bkb as a inner join dbo.table_masking_lokasi as b 
							 on a.szWorkplaceId = b.szWorkplaceId COLLATE DATABASE_DEFAULT
							where  DATEPART(year, dtmTransaction) in (".$_GET['tahun'].",".$year_before.") ".$entity." ".$depo."  ".$sku." ".$brand." 
							group by b.asal2,b.depo,a.szProductCategory,a.szProductName with rollup 
							 ";
			}//end if weekly
			else if($_GET['jenis_lap']=="daily"){
				$a_date = $_GET['tahun']."-".$_GET['month']."-01";
				$date = new DateTime($a_date);
				$date->modify('last day of this month');
				$akhir_day =  $date->format('d');
				$tgl_for = '';
				$koma_day = '';
				for($i=1;$i<=$akhir_day;$i++){
					if($i<=9){$tgl_for="0".$i;}else{$tgl_for = $i;}
					if($i!=$akhir_day){$koma_day=',';}else{$koma_day = '';}
					$sql_vol .= "SUM(CASE WHEN  DATEPART(day, dtmTransaction) ='".$tgl_for."' and DATEPART(month, dtmTransaction) ='".$_GET['month']."' and DATEPART(year, dtmTransaction) ='".$_GET['tahun']."' THEN szStokMasuk ELSE 0 END) AS sm_tgl_".$tgl_for.",";
					$sql_vol .= "SUM(CASE WHEN  DATEPART(day, dtmTransaction) ='".$tgl_for."' and DATEPART(month, dtmTransaction) ='".$_GET['month']."' and DATEPART(year, dtmTransaction) ='".$_GET['tahun']."' THEN szStokKeluar ELSE 0 END) AS sk_tgl_".$tgl_for.$koma_day;
					$hari = date("D", strtotime($_GET['tahun']."-".$_GET['month']."-".$tgl_for));
			?>
			<th style="vertical-align:middle; text-align:center; <?php if($hari=="Sun"){ echo "background-color:red;";?><?php }?>" colspan="2"><?php echo $tgl_for; ?></th>
			<?php } //end for daily?>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Total</th>
			<th style="vertical-align:middle; text-align:center; " colspan="2">Average</th>
			<?php 
			$sql_vol .=" from View_BOSNET_btb_bkb as a inner join dbo.table_masking_lokasi as b 
							 on a.szWorkplaceId = b.szWorkplaceId COLLATE DATABASE_DEFAULT
							where  DATEPART(year, dtmTransaction) = '".$_GET['tahun']."' ".$entity." ".$depo."  ".$sku." ".$brand." 
							group by b.asal2,b.depo,a.szProductCategory,a.szProductName with rollup 
							 ";
			}//end if daily?>
		</tr>
		<?php 
		if($_GET['jenis_lap']=="monthly"){
			foreach($month as $x=>$x_value){
				if($x_value <= $this_month1){
		?>
			<th style="vertical-align:middle; text-align:center; " class="td_1">Stock IN</th>
			<th style="vertical-align:middle; text-align:center; " class="td_1">Stock OUT</th>
			
		<?php }
			}
		}
		else if($_GET['jenis_lap']=="weekly"){
			$i = 12; 
			while ($i >=1) {
		?>
			<th style="vertical-align:middle; text-align:center; " class="td_1">Stock IN</th>
			<th style="vertical-align:middle; text-align:center; " class="td_1">Stock OUT</th>
			
		<?php $i--;}
		}
		else if($_GET['jenis_lap']=="daily"){
			for($i=1;$i<=$akhir_day;$i++){
				$hari = date("D", strtotime($_GET['tahun']."-".$_GET['month']."-".$tgl_for));
		?>
			<th style="vertical-align:middle; text-align:center; <?php if($hari=="Sun"){ echo "background-color:red;";?><?php }?>" class="td_1">Stock IN</th>
			<th style="vertical-align:middle; text-align:center; <?php if($hari=="Sun"){ echo "background-color:red;";?><?php }?>" class="td_2">Stock OUT</th>
			
		<?php }
		}?>
		
		<th style="vertical-align:middle; text-align:center; " class="td_1">Stock IN</th>
		<th style="vertical-align:middle; text-align:center; " class="td_1">Stock OUT</th>
		
		
		<th style="vertical-align:middle; text-align:center; " class="td_1">Stock IN</th>
		<th style="vertical-align:middle; text-align:center; " class="td_1">Stock OUT</th>
		
	</thead>
	<tbody>
		<?php 
		$stmt_exp = sqlsrv_query( $conn2, $sql_vol , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
		$num_exp = sqlsrv_num_rows($stmt_exp); 
		$jml_hari_kerja = hari_kerja()-2;
		$vol_bulan_ini = "";
		while($row_vol = sqlsrv_fetch_array( $stmt_exp, SQLSRV_FETCH_ASSOC)){
			${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}="";
			${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}="";
			${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} = '';
			${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} = '';
			${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} = 0;
			${'estimasi_tahun_ini'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}="";
			${'estimasi_growth'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}="";
			${'vol_before'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}="";
			if($row_vol['szProductName']!= ""){
					$hapus="tidak";
					$ulang1++;	
			}
		?>
			<?php if ($ulang1 ==1 && $row_vol['szProductName'] == "") { } else {?>
				<tr <?php 
						if($row_vol['asal2']=="" and $row_vol['depo']=="" and $row_vol['szProductCategory']=="" and $row_vol['szProductName']=="" ){
							echo "style='background-color:#7030a0;color:white;'";
						}
						else if($row_vol['asal2']!="" and $row_vol['depo']!="" and $row_vol['szProductCategory']=="" and $row_vol['szProductName']=="" ){
							echo "style='background-color:#00b050;'";
						}
						else if($row_vol['asal2']!="" and $row_vol['depo']!="" and $row_vol['szProductCategory']=="" and $row_vol['szProductName']=="" ){
							echo "style='background-color:#ffccff;'";
						}
						else if($row_vol['asal2']!="" and $row_vol['depo']!="" and $row_vol['szProductCategory']!="" and $row_vol['szProductName']=="" ){
							echo "style='background-color:#ffccff;'";
						}

					?>
				>
					<?php 
						if($row_vol['asal2']==""){
							echo "<td style='vertical-align:middle; text-align:center;' class='td_l1' colspan='4'><b>Grand Total</b></td>";
						}else{							
							//echo "<td style='vertical-align:middle; text-align:center;' class='td_l1'>".$row_vol['szProductCategory']."</td>";
							echo "<td style='vertical-align:middle; text-align:center;' class='td_l1'>".$row_vol['asal2']."</td>";
						}
					?>
					
					<?php 
						if($row_vol['depo']==""){
							if($row_vol['asal2']==""){echo"";}
							else{echo "<td style='vertical-align:middle; text-align:center;' class='td_l1' colspan='3'><b>Total ".$row_vol['asal2']."</b></td>";}									 
						}
						else{
						   echo "<td style='vertical-align:middle; ' class='td_l1'>".$row_vol['depo']."</td>";
						}
					?>
					
					<?php 
						if($row_vol['szProductCategory']==""){
							if($row_vol['depo']==""){echo"";}
							else{echo "<td style='vertical-align:middle; text-align:center;' class='td_l1' colspan='2'><b>Total ".$row_vol['depo']."</b></td>";}									 
						}
						else{
						   echo "<td style='vertical-align:middle; ' class='td_l1'>".$row_vol['szProductCategory']."</td>";
						}
					?>
					
					<?php 
						if($row_vol['szProductName']==""){
							if($row_vol['szProductCategory']==""){echo"";}
							else{
								 echo "<td style='vertical-align:middle; text-align:center;' class='' ><b>Total ".$row_vol['szProductCategory']."</b></td>";
								}									 
						}					
						else{
						   //echo "<td style='vertical-align:middle; ' class=''>".$row_vol['szProductName']."</td>";
						   echo "<td style='vertical-align:middle; ' class=''>".$row_vol['szProductName']."</td>";
						}
					?>

					

					<?php 
						if($_GET['jenis_lap']=="monthly"){
						//$vol_bulan_ini = ($row_vol[strtolower(date('M'))]/$jml_hari_kerja)*hari_kerja_bulan_ini();
						if($_GET['tahun']==date('Y')){
					
						}
						foreach($month as $x=>$x_value){
							if($x_value <= $this_month1){
								${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} +=$row_vol["sk_".$x];			
								${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} +=$row_vol["sm_".$x];
								
								if($row_vol["sk_".$x]!=0){
									${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}++;
								}?>
								<td style='vertical-align:middle; text-align:center;'><?php echo format_rupiah($row_vol["sm_".$x]);?></td>
								<td style='vertical-align:middle; text-align:center;'><?php echo format_rupiah($row_vol["sk_".$x]);?></td>
								
								<?php 		
							}  
						}//end for each monthly
					?>
						<td style='vertical-align:middle; text-align:center;'><?php echo format_rupiah(${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
						<td style='vertical-align:middle; text-align:center;'><?php echo format_rupiah(${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
						
						<td style="vertical-align:middle; text-align:center;">
					<?php //${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} = array_sum(${'array'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}) / count(${'array'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
						if(${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}!=0){
							${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} =  ${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / ${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']};
							echo format_rupiah(${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
						}
					?>
					</td>
						<td style="vertical-align:middle; text-align:center;">
					<?php //${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} = array_sum(${'array'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}) / count(${'array'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
						if(${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}!=0){
							${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} =  ${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / ${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']};
							echo format_rupiah(${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
						}
					?>
					</td>
						
					<?php if($_GET['tahun']==date('Y')){?>

					<?php }?>
					<?php 
					} //end jenis lap monthly
					if($_GET['jenis_lap']=="weekly"){
					$g = 12;
					while ($g >=1) {
					${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}+=$row_vol["sk_week".$g];
					${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}+=$row_vol["sm_week".$g];
					?>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah($row_vol["sm_week".$g]);?></td>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah($row_vol["sk_week".$g]);?></td>
					
					<?php 
					$g--;} //end while weekly
					?>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah(${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah(${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
					
					<td style="vertical-align:middle; text-align:center;"><?php 
					${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}= ${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / 12;
					echo format_rupiah(${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?>
					</td>
					<td style="vertical-align:middle; text-align:center;"><?php 
					${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}= ${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / 12;
					echo format_rupiah(${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?>
					</td>
					
					<?php 
					} //end jenis lap weekly
					else if($_GET['jenis_lap']=="daily"){
					for($i=1;$i<=$akhir_day;$i++){
					if($i<=9){$tgl_for="0".$i;}else{$tgl_for = $i;}
					${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}+=$row_vol["sk_tgl_".$tgl_for];
					${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}+=$row_vol["sm_tgl_".$tgl_for];
					if($row_vol["sk_tgl_".$tgl_for]!=0){
					${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}++;
					}
					$hari = date("D", strtotime($_GET['tahun']."-".$_GET['month']."-".$tgl_for));
					?>
					<td style="vertical-align:middle; text-align:center;<?php if($hari=="Sun"){ echo "background-color:red;";?><?php }?>"><?php echo format_rupiah($row_vol["sm_tgl_".$tgl_for]);?></td>
					<td style="vertical-align:middle; text-align:center;<?php if($hari=="Sun"){ echo "background-color:red;";?><?php }?>"><?php echo format_rupiah($row_vol["sk_tgl_".$tgl_for]);?></td>
					<?php } //end for daily?>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah(${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
					<td style="vertical-align:middle; text-align:center;"><?php echo format_rupiah(${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});?></td>
					<td style="vertical-align:middle; text-align:center;"><?php 
					if(${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}!=0){
					${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}= ${'total_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / ${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']};

					echo format_rupiah(${'avg_masuk'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
					}?>
					</td>
					<td style="vertical-align:middle; text-align:center;"><?php 
					if(${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}!=0){
					${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']}= ${'total'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']} / ${'jml_avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']};

					echo format_rupiah(${'avg'.$row_vol['asal2'].$row_vol['depo'].$row_vol['szProductCategory'].$row_vol['szProductName']});
					}?>
					</td>
					<?php 
					}//end jenis lap daily?>
				</tr>
			<?php } if($row_vol['szProductName']!= ""){}else{$hapus="ya"; $ulang1 = 0;} ?>	
		<?php }?>
	</tbody>
</table>
