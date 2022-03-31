@extends('admin.layout.app')
@section('content')

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
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
        <div class="col-lg-4 col-12">
          <!-- small box -->
          <a href="{{route('users.index') }}">
            <div class="small-box bg-orange">
              <div class="inner">
                <p>Total Users</p>
                <h3>{{$user_total_count}}</h3>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
                <!-- <i class="ion ion-bag"></i> -->
              </div>
            </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
          <!-- small box -->
          <a href="{{route('log.index') }}">
            <div class="small-box bg-blue">
              <div class="inner">
                <p>Total Request Served</p>
                <h3>{{$activity_count}}</h3>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <p>Total Time Spend</p>
              <h3>{{$time_sepent_log}}  Minutes</h3>
            </div>
            <div class="icon">
              <i class="ion ion-navicon-round"></i>
            </div>
          </div>
        </div> 
        <!-- ./col -->
        {{--<div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <p>Total Earning</p>
              <h3>20</h3>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>--}}
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
    
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
     <section class="content">
      <div class="container-fluid">
          <div class="row">          
            <div class="col-md-6 col-xl-6">     
              <div class="box-main-title box-dashboard-text">Gender</div>         
              <div class="box-main graph-space">
                <canvas id="gender-chart_pie" height="250"></canvas>             
              </div>
            </div>
            <div class="col-md-6 col-xl-6">  
              <div class="box-main-title box-dashboard-text">Age</div>           
              <div class="box-main graph-space">
                <form>                
                  <canvas id="age-chart_pie" height="250"></canvas>
                </form>
              </div>
            </div>
          </div> 

          <div class="row">          
            <div class="col-md-6 col-xl-6">     
              <div class="box-main-title box-dashboard-text">Users</div>         
              <div class="box-main graph-space">
                <canvas id="pie-chart" height="250"></canvas>             
              </div>
            </div>
            <div class="col-md-6 col-xl-6">  
              <div class="box-main-title box-dashboard-text">Request Served</div>           
              <div class="box-main graph-space">
                <form>                
                  <canvas id="activity-chart" height="250"></canvas>
                </form>
              </div>
            </div>
          </div>
           <!--  <div  class="row">
              <div class="col-md-12 col-xl-12">   
                <div class="box-main-title box-dashboard-text">Conversion Rates</div>            
                <div class="box-main graph-space">
                  <canvas id="visitors-chart" height="250"></canvas>             
                </div>
              </div>
            </div> -->
             
      </div>
    </div><!-- /.container-fluid -->
  </section>
    <!-- /.content -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
 <!---------------------------------->
<script>
    // Event Day Wise
  $(function(){
      //get the pie chart canvas
      var cData5 = JSON.parse(`<?php echo $gender_data['gender_data']; ?>`);
      var ctx = $("#gender-chart_pie");
 
      //pie chart data
      var data = {
        labels: cData5.data,
        datasets: [
          {
            label: "Use Action Count",
            data: cData5.label,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Gender Wise Count",
          fontSize: 18,
          fontColor: "#FFF"
        },
        legend: {
          display: false,
          position: "bottom",
          labels: {
            fontColor: "#FFF",
            fontSize: 16
          }
        },
        scales: {
            yAxes: [{
                display: false,
                stacked: false,
                ticks: {
                    min: 0, // minimum value
                    //max: 100, // maximum value
                    stepSize: 1
                }
            }]
        }
      };
 
      //create Pie Chart class object
      var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
      });
 
  });
</script>


<script>
    // Event Day Wise
  $(function(){
      //get the pie chart canvas
      var cData51 = JSON.parse(`<?php echo $age_data['age_data']; ?>`);
      var ctx = $("#age-chart_pie");
 
      //pie chart data
      var data = {
        labels: cData51.data,
        datasets: [
          {
            label: "Use Action Count",
            data: cData51.label,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Age Wise Count",
          fontSize: 18,
          fontColor: "#FFF"
        },
        legend: {
          display: false,
          position: "bottom",
          labels: {
            fontColor: "#FFF",
            fontSize: 16
          }
        },
        scales: {
            yAxes: [{
                display: false,
                stacked: false,
                ticks: {
                    min: 0, // minimum value
                    //max: 100, // maximum value
                    stepSize: 5
                }
            }]
        }
      };
 
      //create Pie Chart class object
      var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
      });
 
  });
</script>


<script>
  $(function(){
      //get the pie chart canvas
      var cData = JSON.parse(`<?php echo $chart_data['chart_data']; ?>`);
      var ctx = $("#pie-chart");
 
      //pie chart data
      var data = {
        labels: cData.label,
        datasets: [
          {
            label: "",
            data: cData.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Weekly User Count ",
          fontSize: 18,
          fontColor: "#FFF"
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#FFF",
            fontSize: 16
          }
        },
        scales: {
            yAxes: [{
                display: true,
                stacked: true,
                ticks: {
                    min: 0, // minimum value
                    //max: 100, // maximum value
                    stepSize: 5
                }
            }]
        }
      };
 
      //create Pie Chart class object
      var chart = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });
 
  });
</script>

<script>
  $(function(){
      //get the pie chart canvas
      var cData1 = JSON.parse(`<?php echo $actions_use_data['actions_use_data']; ?>`);
      var ctx = $("#activity-chart");
 
      //pie chart data
      var data = {
        labels: cData1.data,
        datasets: [
          {
            label: "",
            data: cData1.label,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "",
          fontSize: 18,
          fontColor: "#FFF"
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#FFF",
            fontSize: 16
          }
        },
        scales: {
            yAxes: [{
                display: true,
                stacked: true,
                ticks: {
                    min: 0, // minimum value
                    //max: 100, // maximum value
                    stepSize: 5
                }
            }]
        }
      };
 
      //create Pie Chart class object
      var chart1 = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });
 
  });
</script>


@stop
