<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CETAK SLIP</title>
    <style>
        @page {
            size: 215mm 140mm potrait;
        }
        @font-face {
            font-family:"1979 Dot Matrix Regular";
            src:url("../../assets/printer/1979_dot_matrix.eot?") format("eot"),url("../../assets/printer/1979_dot_matrix.woff") format("woff"),url("../../assets/printer/1979_dot_matrix.ttf") format("truetype"),url("../../assets/printer/1979_dot_matrix.svg#1979-Dot-Matrix") format("svg");
            font-weight:normal;
            font-style:normal;
        }

        body, h1, h2, h3, h4, h5, h6 {
            font-family: "1979 Dot Matrix Regular";
            font-size: 3mm;
            margin: 0mm;
            padding: 0mm;
            line-height: 4mm;
        }
        .page {
            /*width: 210mm;
            height: 148mm;*/
            position: fixed;
            background: none;
            border: none;
        }
        p {
            margin: 0 0 1mm 0;
            background-color: none;
        }
        div {
            background-color: none;
            /*#f7f7f7;*/
        }
        .title {
            font-weight: bold;
        }
        .list-product {
            height: 62mm;
            overflow: hidden;
            border-top: 0.5mm solid black;
            border-bottom: 0.5mm solid black;
        }
        .list-product p {
            margin: 0;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding:1mm 3mm 0.5mm 0mm;
            border:none;
        }
        .table>thead {
            text-align: left;
        }
        .table>tbody>tr>td:last-child, .table>tbody>tr>th:last-child,.table>thead>tr>td:last-child, .table>thead>tr>th:last-child {
            padding-right: 0mm;
        }
    </style>
    <script src="<?= base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
</head>

<body onload="onbeforeunload()">
    <div class="page">
        <div style="position: fixed;margin-top: 4mm;margin-left: 4mm;">
            <!-- <h2>SLIP GAJI</h2> -->
        </div>
        <div style="position: fixed;margin-top: 12mm;margin-left: 4mm;">
            <p style="max-width:90mm;">
            	Setiabudi Building II, Lt. 6 <br>				
				Jl. HR. Rasuna Said. Kav. 62. Jakarta Selatan</p>
        </div>
        <div style="position: fixed;margin-top: 12mm;margin-left: 110mm;">
            <p>	
                <table>
                    <tr>
                        <td>AOC</td>
                        <td>:</td>
                        <td> <?= $data_print['code']; ?> </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?= $data_print['name']; ?> </td>
                    </tr>
                    <tr>
                        <td>Team</td>
                        <td>:</td>
                        <td><?= ($data_print['team']) ? $data_print['team'] : 0; ?></td>
                    </tr>
                    <tr>
                        <td>Posisi</td>
                        <td>:</td>
                        <td><?= $data_print['position']; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><?= $data_print['status']; ?>   </td>
                    </tr>
                </table>
			</p>
        </div>
        <div style="position: fixed;margin-top: 34mm;margin-left: 4mm;width: 75mm;overflow: hidden;height: 14mm;">
            <p class="title" style="height: 4mm;width: 75mm;overflow: hidden;">
                <!-- <span style="width: 25mm;display: inline-block;"> -->
                <!-- </span> -->
            </p>
        </div>
        <div style="position: fixed;margin-top: 44mm;margin-left: 68mm;width: 54mm;height: 4mm;overflow: hidden;">
        </div>
        <div style="width: 500mm;">
	        <div style="position: fixed;margin-top: 44mm;margin-left: 4mm;width: 180mm;height: 4mm;overflow: hidden; border-bottom: 0.5mm solid black; border-top:0.5mm solid black; ">
		        PENERIMAAN
	        </div>
	        <div style="position: fixed;margin-top: 44mm;margin-left: 128mm;width: 71mm;height: 4mm;overflow: hidden;">
	            POTONGAN
	        </div>
        </div>
       
        <!-- tanda tangan -->
        <div style="position: fixed;margin-top: 114mm; margin-left: 80mm;">
            <div style="position: relative;margin-left: 0mm;background:none;float: left;">
                <p style="text-align: center;width: 100%;">
                    Diserahkan oleh,
                </p>
                <p style="height: 16mm;">
                </p>
                <p style="text-align: center;width: 100%;height: 4mm;">
                    ( FINANCE )
                </p>
            </div>
        </div>

         <div style="position: fixed;margin-top: 114mm; margin-left: 120mm;">
            <div style="position: relative;margin-left: 0mm;background:none;">
		    	<p>Jakarta, &nbsp;<?= str_replace('/',' ', date('d/M/Y')); ?></p>
                <p style="text-align: center;width: 100%;">
                    Diterima oleh,
                </p>
                <p style="height: 11mm;">
                </p>
                <p style="text-align: center;width: 100%;height: 4mm;">
                    ( <?= $this->session->userdata('name'); ?> )
                </p>
            </div>
        </div> 
        <!-- tampung data ke variabel biar gampang -->
        <?php 
            $gaji_pokok     = (
                base64_decode($data_print['basic_sallary'])) ? base64_decode($data_print['basic_sallary']) : "0";
            $gaji_pokok     = substr($gaji_pokok,0,8);
            $tunj_jabatan   = ($data_print['tunjangan_jabatan']) ? base64_decode($data_print['tunjangan_jabatan']) : "0" ;
            $bp_kesehatan_1 = ($data_print['kesehatan_a']) ? base64_decode($data_print['kesehatan_a']) : "0";
            $bp_kesehatan_2 = ($data_print['kesehatan_b']) ? base64_decode($data_print['kesehatan_b']) : "0";
            $pensiun        = ($data_print['pensiun']) ? base64_decode($data_print['pensiun']) : "0";
            $bp_pensiun_1   = ($data_print['bpjs_pensiun_a']) ? base64_decode($data_print['bpjs_pensiun_a']) : "0";
            $bp_pensiun_2   = ($data_print['bpjs_pensiun_b']) ? base64_decode($data_print['bpjs_pensiun_b']) : "0";
            $bp_tk_1        = ($data_print['tenaga_kerja_a']) ? base64_decode($data_print['tenaga_kerja_a']) : "0";
            $bp_tk_2        = ($data_print['tenaga_kerja_b']) ? base64_decode($data_print['tenaga_kerja_b']) : "0";
            $pph_21_a       = ($data_print['pph_pasal_21']) ? base64_decode($data_print['pph_pasal_21']) : "0";
            $pinjaman       = ($data_print['pinjaman']) ? base64_decode($data_print['pinjaman']) : "0";
            $pph_21_b       = ($data_print['tunjangan_pph21']) ? base64_decode($data_print['tunjangan_pph21']) : "0";
            $potongan_lain  = ($data_print['potongan_lain']) ? base64_decode($data_print['potongan_lain']) : "0";
            $komisi         = ($data_print['commision_xtradana']) ? base64_decode($data_print['commision_xtradana']) : "0";
            $thp = ($data_print['thp']) ? base64_decode($data_print['thp']) : '0';
            $bpjs_pensiun = ($pensiun) + ($bp_pensiun_1);
            $tenaga_kerja = ($bp_tk_1) + ($bp_tk_2);

            $total_gaji_bruto = 
                (   
                    $gaji_pokok + 
                    $tunj_jabatan +
                    $bp_tk_1      +
                    $bp_pensiun_1 +
                    $bp_kesehatan_1 +
                    $pph_21_a + 
                    $komisi
                );

            $total_potongan = 
                (
                    $bp_kesehatan_2 +
                    $bpjs_pensiun   + 
                    $tenaga_kerja   +
                    $pph_21_b       +
                    $pinjaman       +
                    $potongan_lain  
                );
            // $total_diterima = ( $total_gaji_bruto ) - ( $total_potongan );

        ?>
        <!-- fix ok -->
        <div style="position: fixed;margin-top: 50mm; margin-left: 4mm;width: 180mm;">
            <!-- <div class="list-product"> -->
            <table width="100%" class="table">
            	<tr>
	                <td>Gaji Pokok <span style="margin-left: 33.5mm;"></span>:&nbsp;&nbsp;<?= $gaji_pokok ?></td>
	                <td></td>
	                <td>BPJS Kesehatan <span style="margin-left: 17.5mm;"></span>: <?= $bp_kesehatan_2 ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Tunjangan Jabatan <span style="margin-left: 16.9mm;"></span>:&nbsp;&nbsp;<?=  $tunj_jabatan; ?></td>
	                <td></td>
	                <td>BPJS Pensiun <span style="margin-left: 22.8mm;"></span>: <?= $bpjs_pensiun ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Tunjangan BPJS TK <span style="margin-left: 17.3mm;"></span>:&nbsp;&nbsp;<?= $bp_tk_1; ?></td>
	                <td></td>
	                <td>BPJS Ketenagakerjaan <span style="margin-left: 4.1mm;"></span>: <?= $tenaga_kerja ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Tunjangan BPJS Pens <span style="margin-left: 12.8mm;"></span>:&nbsp;&nbsp;<?= $bp_pensiun_1 ?></td>
	                <td></td>
	                <td>PPH Pasal 21 <span style="margin-left: 23.2mm;"></span>: <?= $pph_21_a ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Tunjangan BPJS Kesehatan <span style="margin-left: 1.6mm;"></span>:&nbsp;&nbsp;<?=  $bp_kesehatan_1 ?></td>
	                <td></td>
	                <td>Potongan Pinjaman <span style="margin-left: 11.6mm;"></span>: <?= $pinjaman ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Tunjangan PPH 21 <span style="margin-left: 20.3mm;"></span>:&nbsp;&nbsp;<?= $pph_21_b ?></td>
	                <td></td>
	                <td>Potongan Lainnya <span style="margin-left: 13.9mm;"></span>: <?= $potongan_lain ?></td>
            	</tr>
            	<tr>
	                <td colspan="1">Komisi <span style="margin-left: 42.7mm;"></span>: &nbsp;<?= $komisi ?></td>
	                <td></td>
	                <td></td>
            	</tr>
            	<tr>
            		<td colspan="1"></td>
            		<td></td>
            		<td></td>
            	</tr>
            	<tr>
	                <td colspan="1">Total Gaji Bruto <span style="margin-left: 16.6mm;">&nbsp;&nbsp;: &nbsp;<?= number_format($total_gaji_bruto) ?></td>
	                <td></td>
	                <td>Total Potongan <span style="margin-left: 17.7mm;"></span>: <?= number_format($total_potongan) ?></td>
            	</tr>
            	<!-- <tr>
	                <td colspan="1" style="border-bottom: 0.5mm solid black; border-top:0.5mm solid black;">Total Gaji Yang di terima <span style="margin-left: 3mm;">&nbsp;&nbsp;:
                        <span style="margin-left: 0mm;">&nbsp;&nbsp;:</td>
	                <td></td>
            	</tr> -->
            </table>
            <div style="width: 500mm;">
                <div style="position: fixed;margin-left:1mm;width: 177mm;height: 4mm;overflow: hidden; border-bottom: 0.5mm solid black; border-top:0.5mm solid black; ">
                    Total gaji yang diterima
                </div>
                <div style="position: fixed;margin-left: 100.5mm;width: 71mm;height: 4mm;overflow: hidden;">
                    RP <span style="margin-left: 40mm;">&nbsp;: <?= number_format($thp); ?>
                </div>
            </div>
        </div>
    </div>
  <!--   <script>
        window.print();
    </script> -->
</body>
</html>
