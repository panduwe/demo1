<?php
error_reporting(0);

include "koneksi.php";

$b_jk = $_POST['jk'];
$b_us = $_POST['usia'];
$b_ag = $_POST['agama'];
$b_nk = $_POST['nikah'];
$b_dpt = $_POST['pendapatan'];
$b_ddk = $_POST['pendidikan'];
$b_ds = $_POST['desa'];


if (empty($b_jk) or empty($b_us) or empty($b_ag) or empty($b_nk)or empty($b_dpt)or empty($b_ddk)or empty($b_ds))
{
	echo "<script>
				alert('Ada yang belum anda isi');
				window.location = 'javascript:history.go(-1)'; 
		</script>";
}
else
{
	//Membaca jumlah baris data pada database
	$sql = mysql_query("SELECT * FROM data ORDER BY id ASC");
	$numrows = mysql_num_rows($sql);

	//Menentukan nilai K
	/*$k=0.3 * $numrows;
	$k=round($k);
	$r=$k % 2;
	if($r!=0)
	{
		$k=$k+1;
	}
	else
	{
		$k=$k;
	}*/

	$k=1; 

	echo "<b>Nilai K adalah sebesar $k </b><br><br>";

	//Perhitungan dengan KNN
	for ($i=1; $i <= $numrows; $i++)
	{	
		$sql1 = mysql_query("SELECT * FROM data Where id = $i");
		while($data = mysql_fetch_array($sql1))
		{
			//Pengurangan(KNN)
			
		//hitung kedekatan jenis kelamin
			if($b_jk==$data[jk])
				$kedekatanJk=1;
			else
				$kedekatanJk=0;
			
//hahahhahahahh ini perubahannya

		//hitung kedekatan usia
			if($b_us==$data[usia])
				$kedekatanUs=1;
			else{
				$v1 = $b_us.$data[usia];
				if($v1=='RD' or $v1=='DR')
					$kedekatanUs=0.7;
				elseif ($v1=='RL' or $v1=='LR') 
					$kedekatanUs=0;
				elseif ($v1=='RM' or $v1=='MR') 
					$kedekatanUs=0.4;

				elseif ($v1=='DL' or $v1=='LD') 
					$kedekatanUs=0.4;
				elseif ($v1=='DM' or $v1=='MD') 
					$kedekatanUs=0.7;

				elseif ($v1=='LM' or $v1=='ML') 
					$kedekatanUs=0.7;
			}

		//hitung kedekatan agama
			if($b_ag==$data[agama])
				$kedekatanAg=1;
			else
				$kedekatanAg=0;	

		//hitung kedekatan nikah
			if($b_nk==$data[nikah])
				$kedekatanNk=1;
			else
				$kedekatanNk=0;	

		//hitung kedekatan pendapatan
			if($b_dpt==$data[pendapatan])
				$kedekatanDpt=1;
			else{
				$v2 = $b_dpt.$data[pendapatan];
				if($v2=='AB' or $v2=='BA')
					$kedekatanDpt=0;
				elseif ($v2=='AM' or $v2=='MA') 
					$kedekatanDpt=0.5;
				elseif ($v2=='BM' or $v2=='MB') 
					$kedekatanDpt=0.5;
			}

		//hitung kedekatan pendidikan
			if($b_ddk==$data[pendidikan])
				$kedekatanDdk=1;
			else{
				$v3 = $b_ddk.$data[pendidikan];
				if($v3=='SDSLTP' or $v3=='SLTPSD')
					$kedekatanDdk=0.75;
				elseif ($v3=='SDSLTA' or $v3=='SLTASD') 
					$kedekatanDdk=0.5;
				elseif ($v3=='SDS1' or $v3=='S1SD') 
					$kedekatanDdk=0.25;
				elseif ($v3=='SDS2' or $v3=='S2SD') 
					$kedekatanDdk=0;
				elseif ($v3=='SLTPSLTA' or $v3=='SLTASLTP') 
					$kedekatanDdk=0.75;
				elseif ($v3=='SLTPS1' or $v3=='S1SLTP') 
					$kedekatanDdk=0.5;
				elseif ($v3=='SLTPS2' or $v3=='S2SLTP') 
					$kedekatanDdk=0.25;
				elseif ($v3=='SLTAS1' or $v3=='S1SLTA') 
					$kedekatanDdk=0.75;
				elseif ($v3=='SLTAS2' or $v3=='S2SLTA') 
					$kedekatanDdk=0.5;
				elseif ($v3=='S1S2' or $v3=='S2S1') 
					$kedekatanDdk=0.75;
				
			}

			//hitung kedekatan DESA
			if($b_ds==$data[desa])
				$kedekatanDs=1;
			else{
				$v4 = $b_ds.$data[desa];
				if($v4=='cipadungcisurupan' or $v4=='cisurupancipadung')
					$kedekatanDs=0.7;
				elseif ($v4=='cipadungpalasari' or $v4=='palasaricipadung') 
					$kedekatanDs=0.4;
				elseif ($v4=='cipadungpasir biru' or $v4=='pasir birucipadung') 
					$kedekatanDs=0;
				elseif ($v4=='cisurupanpalasari' or $v4=='palasaricisurupan') 
					$kedekatanDs=0.7;
				elseif ($v4=='cisurupanpasir biru' or $v4=='pasir birucisurupan') 
					$kedekatanDs=0.4;
				elseif ($v4=='palasaripasir biru' or $v4=='pasir birupalasari') 
					$kedekatanDs=0.7;
			}
			
			

			
			//rumus (KNN)
			$hit1 = ((($kedekatanJk*0.1)+($kedekatanUs*0.05)+($kedekatanAg*0.05)+($kedekatanNk*0.15)+($kedekatanDpt*0.3)+($kedekatanDdk*0.15)+($kedekatanDs*0.2))/(0.1+0.05+0.05+0.15+0.3+0.15+0.2));
			
		
			
			//Penyimpanan perhitungan ke database sementara
			mysql_query("INSERT INTO sementara (id,
												jarak,
												jk,
												usia,
												nikah,
												pendidikan,
												pendapatan,
												desa,
												agama,
												status)
										VALUES ('$i',
												'$hit1',
												'$data[jk]',
												'$data[usia]',
												'$data[nikah]',
												'$data[pendidikan]',
												'$data[pendapatan]',
												'$data[desa]',
												'$data[agama]',
												'$data[status]')");
		}	
	}

	
	
	//data yang sudah d sorting dari data pertama sampai data nilai K
	$sql3 = mysql_query("SELECT * FROM  `sementara` ORDER BY  `sementara`.`jarak` DESC  LIMIT 0 , $k");
	$x=1;
	
	while($data = mysql_fetch_array($sql3))
		{			
			//memasukkan data yang sudah di sorting mulai dari pertama sampai data nilai k ke dalam database sementara
			mysql_query("INSERT INTO urut (id,
										jarak,
										jk,
										usia,
										nikah,
										pendidikan,
										pendapatan,
										desa,
										agama,
										status)
								VALUES ('$x',
										'$data[jarak]',
										'$data[jk]',
										'$data[usia]',
										'$data[nikah]',
										'$data[pendidikan]',
										'$data[pendapatan]',
										'$data[desa]',
										'$data[agama]',
										'$data[status]')");
								$x=$x+1;
		}	
	

	$sqlrtes = mysql_query("SELECT * FROM  urut ORDER BY id ASC LIMIT 0 , 1");
	while($datates = mysql_fetch_array($sqlrtes))
	{
		if($datates['jarak']>'10') // <<<==== ANGKA BATAS ATUR SENDIRI
		{
			echo "Jarak Data Terlalu Jauh";
		}
		else
		{
			//mencari hasil
			$sqlrx = mysql_query("SELECT * FROM  urut ORDER BY id ASC");
			//$hasil_nam = mysql_fetch_array($sql_nam);
			while($datax = mysql_fetch_array($sqlrx))
			{
				if($datax['jarak']=='0')
				{
					$Status = $datax['status'];
					$Jk = $datax['jk'];
					
					
				echo "<br>Terklasifikasi sebagai Status <b>$Status</b>, dengan Jenis Kelamin <b>$Jk</b>,"; 	
					break;	
				}
				else
				{
					$Status = $datax['status'];
					$Jk = $datax['jk'];
					$Jarak = $datax['jarak'];


				echo "<br>Terklasifikasi sebagai Status <b>$Status</b>, dengan Jarak <b>$Jarak</b>";  
					break;
				}
			}		
		}
	}	


	// langkah terakhir menghapus histori perhitungan pada database
	// $sqls = mysql_query("SELECT * FROM sementara ORDER BY id ASC");
	// $numrows1 = mysql_num_rows($sqls);
	// for ($i=1; $i <= $numrows1; $i++)
	// {
	// 	mysql_query("DELETE FROM sementara WHERE id=$i");
	// }


	// $sql_urut = mysql_query("SELECT * FROM data ORDER BY id ASC");
	// $numrows_urut = mysql_num_rows($sql_urut);
	// for ($i=1; $i <= $numrows_urut; $i++)
	// {
	// 	mysql_query("DELETE FROM urut WHERE id=$i");
	// }


}
?>