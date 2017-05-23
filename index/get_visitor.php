<script>
$(document).ready(function(){
	
});

</script>
<div class="scroll_user" >
	<?php 
		session_start();
		include('../../lib/db_bosnet_dashboard.php');
	    $active = "'Y'";
  	 	$sql_daily = mysqli_query($db_bosnet,"SELECT daily.username,daily.id_user,nama,user_lastlogin, jml,bln 
  	 										FROM (
												SELECT u.id_user,u.username,u.nama,u.user_lastlogin,COUNT(u.nama) AS jml 
												FROM USER AS u INNER JOIN tbl_visitor AS v ON u.username = v.email 
												WHERE DATE_FORMAT(v.tgl_visitor,'%Y-%m-%d') ='".date('Y-m-d')."' 
												GROUP BY u.nama 
											) daily
											INNER JOIN (
												SELECT u.username, u.id_user,
												COUNT(CASE WHEN MONTH(tgl_visitor)='".date('m')."' AND YEAR(tgl_visitor)='".date('Y')."' THEN v.email ELSE 0 END) AS bln
												FROM USER AS u INNER JOIN tbl_visitor AS v ON u.username = v.email
												where YEAR(tgl_visitor)='".date('Y')."' and MONTH(tgl_visitor)='".date('m')."'
												GROUP BY u.username
											) AS monthly ON daily.username = monthly.username
											ORDER BY jml DESC, nama ASC");	
   	?>
			<table class="table table-hover"  id="list_emp">
				<thead>
					<tr>
						<th colspan='4' style="text-align: center;">Data Pengunjung Tanggal <?php echo date('Y-m-d');?></th>
					</tr>
					<tr>
						<th>#.</th>
						<th>Nama User</th>
						<th>Kunjungan Hari Ini</th>
						<th>Kunjungan Bulan <?php echo date('M');?></th>
						<th>Last Visited</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no = 1;
						while($dtgl = mysqli_fetch_array($sql_daily)){
					?>
						<tr <?php if($no%2==0){echo "class='success'";}else{echo "scope='row'";}?>>
							<td><?php echo $no;?>.</td>
							<td><?php echo ucwords(strtolower($dtgl['nama']));?></td>
							<td align="center">
								<a href="#" onclick = "det_visitor('<?php echo date('Y-m-d'); ?>','<?php echo $dtgl['id_user']; ?>','<?php echo $dtgl['nama']; ?>','daily')" >
									<?php echo $dtgl['jml'];?>
								</a>
							</td>
							<td align="center">
								<a href="#" onclick = "det_visitor2('<?php echo date('Y'); ?>','<?php echo date('m'); ?>','<?php echo $dtgl['id_user']; ?>','<?php echo $dtgl['nama']; ?>','monthly')" >
									<?php echo $dtgl['bln'];?>
								</a>
							</td>
							<td><?php echo $dtgl['user_lastlogin'];?></td>
						</tr>
					<?php $no++;}?>
				</tbody>
			</table>
</div>
<style type="text/css">
	.scroll_user{
	    border: 1px solid #ccc;
	    height: 310px;
	    padding: 10px;
	    overflow-y:scroll;
	}
</style>
<script type="text/javascript">
function det_visitor(tgl,iduser,nmuser,jns){
	$.ajax({
		type:"GET",
		url:"inc/index/view_det_visitor.php?tgl="+tgl+"&iduser="+iduser+"&nmuser="+nmuser+"&jns="+jns,
		success:function(data){		
			$("#visitor").show();									
			$("#view_history_visitor").html(data);
		},
		error:function(msg){
			alert(msg);
		}
	});
	//alert(tgl+"-"+iduser);
}
function det_visitor2(thn,bln,iduser,nmuser,jns){
	$.ajax({
		type:"GET",
		url:"inc/index/view_det_visitor.php?thn="+thn+"&bln="+bln+"&iduser="+iduser+"&nmuser="+nmuser+"&jns="+jns,
		success:function(data){		
			$("#visitor").show();									
			$("#view_history_visitor").html(data);
		},
		error:function(msg){
			alert(msg);
		}
	});
	//alert(tgl+"-"+iduser);
}
</script>