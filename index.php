<?php
session_start();
$tittle = 'Dashboard';
include 'layout/header.php';

// membatasi halaman sebelum login
if (isset($_SESSION['username'])) {
  $month = date("M");
  $year = (int)date("Y");

  $m = ['Jan'=>1, 'Feb'=>2, 'Mar'=> 3, "Apr"=> 4, "May"=>5, "Jun"=>6, "Jul"=>7, "Aug"=>8, "Sep"=>9, "Oct"=>10, "Nov"=>11, "Dec"=>12];
  $monthNumber = $m[$month];
  
  $pengeluaran_str = getPengeluaran($monthNumber, $year);
  $pendapatan_str = getPendapatan($monthNumber, $year);
  $brg_terpinjam_str = getBarangTerpinjam();

  $laba_rugi = (int)$pendapatan_str - (int)$pengeluaran_str;
  if ($laba_rugi < 0) {
      $ket_laba = "Rugi";
      $laba_rugi = abs($laba_rugi);
  } else {
    $ket_laba = "Laba";
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard (<?php echo  $month ?>)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4><b>Rp. <?php echo number_format((float)$pengeluaran_str,2,',','.'); ?></b></h4>

                <p>Pengeluaran perbulan</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4><b>Rp. <?php echo number_format((float)$pendapatan_str,2,',','.'); ?></b></h4>

                <p>Pendapatan perbulan</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h4><b>Rp. <?php echo number_format((float)$laba_rugi,2,',','.'); ?></b></h4>

                <p><?php echo $ket_laba ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h4><b><?php echo $brg_terpinjam_str ?> pcs</b></h4>

                <p>Barang yang dipinjam</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <hr>
        <div class="wrapchart">
          <div id="chart-pengeluaran" class="chart"></div>
          <div id="chart-pendapatan" class="chart"></div>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script>
    
    let pengeluaran = new Object();
    let pendapatan = new Object();

    $(function (){
                $.ajax({
                    method: "GET",
                    url: "bulan-Pengeluaran.php",
                }).success(function(data){
                    let obj_data = JSON.parse(data);
                    pengeluaran = obj_data;
                    console.log(pengeluaran);
                    let bulan = [];
                    let keluar = [];

                    for (let key in pengeluaran) {
                      let obj = pengeluaran[key];
                      keluar.push(obj["sum(harga_beli)"]);
                      bulan.push(obj["date_format(created_at,'%M')"]);
                    }

                    console.log(keluar);
                    console.log(bulan);
                    
                    // chart
                    let options = {
                      series: [{
                        name: "Pengeluaran",
                        data: keluar
                    }],
                      chart: {
                      height: 350,
                      type: 'line',
                      zoom: {
                        enabled: false
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'straight'
                    },
                    title: {
                      text: 'PENGELUARAN',
                      align: 'center'
                    },
                    grid: {
                      row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                      },
                    },
                    xaxis: {
                      categories: bulan,
                    }
                    };

                    let chart = new ApexCharts(document.querySelector("#chart-pengeluaran"), options);
                    chart.render();
                  })
      })
    $(function (){
                $.ajax({
                    method: "GET",
                    url: "bulan-pendapatan.php",
                }).success(function(data){
                    let obj_data = JSON.parse(data);
                    pendapatan = obj_data;
                    console.log(pendapatan);
                    let bulan = [];
                    let masuk = [];

                    for (let key in pendapatan) {
                      let obj = pendapatan[key];
                      masuk.push(obj["sum(total_harga)"]);
                      bulan.push(obj["date_format(created_at,'%M')"]);
                    }

                    console.log(masuk);
                    console.log(bulan);
                    
                    // chart
                    let options = {
                      series: [{
                        name: "Pendapatan",
                        data: masuk
                    }],
                      chart: {
                      height: 350,
                      type: 'line',
                      zoom: {
                        enabled: false
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'straight'
                    },
                    title: {
                      text: 'PENDAPATAN',
                      align: 'center'
                    },
                    grid: {
                      row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                      },
                    },
                    xaxis: {
                      categories: bulan,
                    }
                    };

                    let chart = new ApexCharts(document.querySelector("#chart-pendapatan"), options);
                    chart.render();
                  })
      })
  </script>
<?php

} else {
    header("Location: login-template.php");
    exit();
}

include 'layout/footer.php';

?>