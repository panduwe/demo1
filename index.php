<?php
error_reporting(0);

include "koneksi.php";

echo "<h2>Uji</h2>
				<form method=POST action='aksi.php' enctype='multipart/form-data'>
					<table>

						<tr>
							<td>1. Jenis Kelamin</td>     
							<td> : </td>
							<td>
								<select name='jk'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='L'>Laki-Laki</option>  
									 <option value='P'>Perempuan</option>  
								 </select> 
							</td>
						</tr>
						<tr>
							<td>2. Usia</td>     
							<td> : </td>
							<td>
								<select name='usia'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='R'>Remaja (12-25 tahun)</option>  
									 <option value='D'>Dewasa (26-45 tahun)</option>  
									 <option value='L'>Lansia (46-65 tahun)</option>  
									 <option value='M'>Manula (65 tahun ke atas)</option>  
								 </select> 
							</td>
						</tr>
						<tr>
							<td>3. Agama</td>     
							<td> : </td>
							<td>
								<select name='agama'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='I'>Islam</option>  
									 <option value='K'>Keisten</option>  
								 </select> 
							</td>
						</tr>
						<tr>
							<td>4. Status Pernikahan</td>     
							<td> : </td>
							<td>
								<select name='nikah'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='S'>Sudah Nikah</option>  
									 <option value='B'>Belum Nikah</option>  
								 </select> 
							</td>
						</tr>
						<tr>
							<td>5. Pendapatan</td>     
							<td> : </td>
							<td>
								<select name='pendapatan'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='A'>Diatas Rp. 3.500.000 / bulan </option>  
									 <option value='M'>Rp. 3.500.000 – Rp. 1.500.00 / bulan </option>  
									 <option value='B'>Dibawah Rp. 1.500.000 / bulan  </option>  
								 </select> 
							</td>
						</tr>
						<tr>
							<td>6. Pendidikan</td>     
							<td> : </td>
							<td>
								<select name='pendidikan'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='SD'>SD</option>  
									 <option value='SLTP'>SLTP</option>  
									 <option value='SLTA'>SLTA</option> 
									 <option value='S1'>S1</option> 
									 <option value='S2'>S2</option> 
								 </select> 
							</td>
						</tr>
						<tr>
							<td>7. Asal Desa</td>     
							<td> : </td>
							<td>
								<select name='desa'>  
									 <option value=''>Silahkan Pilih</option>  
									 <option value='cipadung'>Cipadung</option>  
									 <option value='cisurupan'>Cisurupan</option>  
									 <option value='palasari'>Palasari</option> 
									 <option value='pasir biru'>Pasir Biru</option> 
								</select> 
							</td>
						</tr>

	
						
						<tr><td colspan=2>	<input type=submit value=Proses>
										<input type=button value=Batal onclick=self.history.back()></td></tr>
					</table>
				</form>";


echo "========= data latih =========";
	$sql2 = mysql_query("SELECT * FROM data ORDER BY id ASC");
	echo "<table>
			<thead>
				<th>Data Ke-</th>
				<th>Jenis Kelamin</th>
				<th>Usia</th>
				<th>Agama</th>
				<th>Status Pernikahan</th>
				<th>Pendapatan</th>
				<th>Pendidikan</th>
				<th>Asal Desa</th>
				<th>Status</th>
				
			</thead>";
		while($data = mysql_fetch_array($sql2))
		{
			echo "<tr>
					<td>$data[id]</td>
					<td>$data[jk]</td>
					<td>$data[usia]</td>
					<td>$data[agama]</td>
					<td>$data[nikah]</td>
					<td>$data[pendapatan]</td>
					<td>$data[pendidikan]</td>
					<td>$data[desa]</td>
					<td>$data[status]</td>
					
				</tr>";
		}	
		echo "</table>";

?>