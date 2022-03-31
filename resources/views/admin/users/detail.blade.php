@extends('admin.layout.app')
@section('content')

 <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Manage User </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>  

    <section class="content">
        <div class="container-fluid">
            <div class="box-main">
                <div class="box-main-top">
                    <div class="box-main-title">User Details &nbsp;<a href="{{URL('public/docs')}}/'SLEEP - '.$users->id.'-'.$today.'.csv'"><i class="fas fa-file-csv " aria-hidden="true"></i></a> </div>
                   
                </div>
                <div class="row">          
                    <div class="col-md-6 col-xl-6">    
                        <div class="profile-img">
                            @if(!empty($user->photo))
                                 <img src="{{ URL('public/images/users') }}/{{ $users->photo }}" alt="" style="height:100px;width: 100px;">
                            @else
                                <img src="{{ URL('public/avatar.png') }}" alt="" style="height:100px;width: 100px;">
                            @endif
                        </div>
                        <br>
                        <div>
                            <label class="lableClass">{{ $users->name }}</label>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Email</b> : {{ $users->email }}
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Login_type</b> :
                                {{ $users->user_type == '1' ? 'Email Login' : 'Social Login'  }}  
                                
                                
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Status</b> : {{ $users->user_status == '1' ? 'Active' : 'Blocked'  }}
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Hight</b> : {{ $users->height }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Weight</b> : {{ $users->weight }}
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Gender</b> : {{ $users->gender }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">    
                        <div class="row">
                            <div class="col-sm-12">
                                <b class="lableClass">Activities Type</b> : {{ @$getAllActivities->activities_type }}
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Average Bed Time</b> : {{ @$getAllActivities->activities_avg_bed_time }}
                                
                                
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Average Wakeup</b> : {{ @$getAllActivities->activities_avg_wake_up }}
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Target Sleep</b> : {{ @$getAllActivities->activities_target_sleep }}
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass"> Workout</b> : {{ @$getAllActivities->activities_avg_workout }}
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Execrise Goal</b> : {{ @$getAllActivities->activities_execrise_goal }}
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Session Per Week</b> : {{ @$getAllActivities->activities_session_per_week }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Average Mindfulness</b> : {{ @$getAllActivities->activities_avg_mindfulness }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass">Mindfulness Goal</b> : {{ @$getAllActivities->activities_mindfulness_goal }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                 <b class="lableClass"> Mindfulness Session Per Week</b> : {{ @$getAllActivities->activities_mindfulness_session_per_week }}
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="row">    
                    @if(!empty($getUsercsv))
                        <div class="col-md-4 col-xl-4">
                            <br><br>
                            <a href="{{Url('users/Usercsv/'.$users->id)}}" style="cursor:pointer">
                                                    
                            <button class="btn btn-success btn-sm">Download User CSV &nbsp;<i class="fas fa-file-csv " aria-hidden="true"></i></button></a>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <br><br>
                            <a href="{{Url('users/Sleepcsv/'.$users->id)}}" style="cursor:pointer">
                          
                                <button class="btn btn-success btn-sm">Download Sleep CSV &nbsp;<i class="fas fa-file-csv " aria-hidden="true"></i></button>
                            </a>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <br><br>
                            <a href="{{Url('users/Heartcsv/'.$users->id)}}" style="cursor:pointer">
                          
                                <button class="btn btn-success btn-sm">Download Heart CSV &nbsp;<i class="fas fa-file-csv " aria-hidden="true"></i></button>
                            </a>   
                        </div>
                    @endif    
                </div>  
            </div>   
        </div>
    </section>    

    
   
    <section class="content">
        <div class="container-fluid">
          <div class="row">          
            
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">PCP </div>         
              <div class="box-main graph-space">
                  <canvas id="pcp-chart" height="100"></canvas>
                            
                </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Sleep Time </div>         
              <div class="box-main graph-space">
                  <canvas id="pst-chart" height="100"></canvas>
                            
                </div>
            </div>

            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Sleep Performance</div>         
              <div class="box-main graph-space">
                  <canvas id="dsp-chart" height="100"></canvas>
                            
                </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Exercise Performance</div>         
              <div class="box-main graph-space">
                  <canvas id="dep-chart" height="100"></canvas>
                            
                </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Exercise Intensity</div>         
              <div class="box-main graph-space">
                  <canvas id="dei-chart" height="100"></canvas>
                            
                </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Events Tracking</div>         
              <div class="box-main graph-space">
                  <canvas id="event-day-wise-chart" height="100"></canvas>
                            
              </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text"><!-- weekly Events Logs --></div>         
              <div class="box-main graph-space">
                  <canvas id="event-weekly-wise-chart" height="100"></canvas>
                            
              </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text"><!-- Montly Events Logs --></div>         
              <div class="box-main graph-space">
                  <canvas id="event-montly-wise-chart" height="100"></canvas>
                            
              </div>
            </div>
          </div>   
        </div>

        <!-------------------------->
        <div class="container-fluid">
          <div class="row">          
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Time Spent</div>         
              <div class="box-main graph-space">
                  <canvas id="event-day-wise-chart_pie" height="100"></canvas>
                            
              </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text"><!-- weekly Events Logs --></div>         
              <div class="box-main graph-space">
                  <canvas id="event-weekly-wise-chart_pie" height="100"></canvas>
                            
              </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text"><!-- Montly Events Logs --></div>         
              <div class="box-main graph-space">
                  <canvas id="event-montly-wise-chart_pie" height="100"></canvas>
                            
              </div>
            </div>

            
          </div>   
        </div>

        <!------------------>
        
        </div><!-- /.container-fluid -->

    </section>
    



    <script type="text/javascript">

        function doSearch(){
            var query=$("#search").val();
            $.ajax({
                url: "{{ route('users.search') }}",
                type: 'GET',
                data: {
                    keyword:query,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('tbody').html(data);
                }
            });
        }

        function ChangeStatus(Id, Status)
        {

            $("#LoadingProgress").fadeIn('fast');
            
            $.ajax({
                url: "{{ URL('/users/change-status') }}/"+Id+"/"+Status,
                type: "GET",
                contentType: false,
                cache: false,
                processData:false,
                success: function( data, textStatus, jqXHR ) {
                    window.location.reload();
                    $("#LoadingProgress").fadeOut('fast');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                
                }
            });
        }


    </script>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>


<!----------------------------------->
<script>
    // pcp Sleep Performace
  $(function(){
      //get the pie chart canvas
      var cDatapcp = JSON.parse(`<?php echo $pcp_chart_data_new['pcp_chart_data_new']; ?>`);
      var ctx = $("#pcp-chart");
 
      //pie chart data
      var data = {
        labels: cDatapcp.label,
        datasets: [
          {
            label: "",
            data: cDatapcp.data,
            fontSize: 28,
            backgroundColor: [
              "#33a9ff",
                
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
          text: "PCP Performance",
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
        type: "line",
        data: data,
        options: options
      });
 
  });
</script>

<!------------------------------------>

<!----------------------------------->
<script>
    // pst Sleep Performace
  $(function(){ //pst
      //get the pie chart canvas
      var cDatapst = JSON.parse(`<?php echo $pcp_chart_data_new['pcp_chart_data_new']; ?>`);
      var ctx = $("#pst-chart");
 
      //pie chart data
      var data = {
        labels: cDatapst.label,
        datasets: [
          {
            label: "",
            data: cDatapst.data,
            fontSize: 28,
            backgroundColor: [
              "#33a9ff",
                
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
          text: "Sleep Times Performance",
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

<!------------------------------------>
<script>
    // Daily Sleep Performace
  $(function(){
      //get the pie chart canvas
      var cData12 = JSON.parse(`<?php echo $dsp_chart_data_new['dsp_chart_data_new']; ?>`);
      var ctx = $("#dsp-chart");
 
      //pie chart data
      var data = {
        labels: cData12.label,
        datasets: [
          {
            label: "",
            data: cData12.data,
            fontSize: 28,
            backgroundColor: [
              "#33a9ff",
                
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
          text: "Sleep Performance",
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
        type: "line",
        data: data,
        options: options
      });
 
  });
</script>
<script>
    // Exercise Performance
  $(function(){
      //get the pie chart canvas
      var cData14 = JSON.parse(`<?php echo $dep_chart_data_new['dep_chart_data_new']; ?>`);
      var ctx = $("#dep-chart");
 
      //pie chart data
      var data = {
        labels: cData14.label,
        datasets: [
          {
            label: "",
            data: cData14.data,
            fontSize: 28,
            backgroundColor: [
              "#ef5804",
                
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
          text: "Exercise Performance",
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
        type: "line",
        data: data,
        options: options
      });
 
  });
</script>
<script>
    // Exercise
  $(function(){
      //get the pie chart canvas
      var cData15 = JSON.parse(`<?php echo $dei_chart_data_new['dei_chart_data_new']; ?>`);
      var ctx = $("#dei-chart");
 
      //pie chart data
      var data = {
        labels: cData15.label,
        datasets: [
          {
            label: "",
            data: cData15.data,
            fontSize: 28,
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
          text: "Exercise Intensity",
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



<!---------------------------------->
<script>
    // Event Day Wise
  $(function(){
      //get the pie chart canvas
      var cData2 = JSON.parse(`<?php echo $event_day_wise_row_data['event_day_wise_row_data']; ?>`);
      var ctx = $("#event-day-wise-chart");
 
      //pie chart data
      var data = {
        labels: cData2.data,
        datasets: [
          {
            label: "",
            data: cData2.label,
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
          text: "Daily Request Served Count",
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
<script>
    // Event Weekly Wise
  $(function(){
      //get the pie chart canvas
      var cData3 = JSON.parse(`<?php echo $chart_data_weekly['chart_data_weekly']; ?>`);
      var ctx = $("#event-weekly-wise-chart");
 
      //pie chart data
      var data = {
        labels: cData3.label,
        datasets: [
          {
            label: "",
            data: cData3.data,
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
          text: "Weekly Request Served Count",
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
<script>
    // Event Monlty Wise
  $(function(){
      //get the pie chart canvas
      var cData4 = JSON.parse(`<?php echo $chart_data_montly['chart_data_montly']; ?>`);
      var ctx = $("#event-montly-wise-chart");
 
      //pie chart data
      var data = {
        labels: cData4.label,
        datasets: [
          {
            label: "",
            data: cData4.data,
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
          text: "Montly Request Served Count",
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
<!------------------------------------>
<!-----------------Pie---------------->
<!---------------------------------->
<script>
    // Event Day Wise
  $(function(){
      //get the pie chart canvas
      var cData5 = JSON.parse(`<?php echo $day_wise_time_spent_data['day_wise_time_spent_data']; ?>`);
      var ctx = $("#event-day-wise-chart_pie");
 
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
          text: "Daily Time Spend IN Minutes",
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
    // Event Weekly Wise
  $(function(){
      //get the pie chart canvas
      var cData6 = JSON.parse(`<?php echo $weekly_wise_time_spent_data['weekly_wise_time_spent_data']; ?>`);
      var ctx = $("#event-weekly-wise-chart_pie");
 
      //pie chart data
      var data = {
        labels: cData6.label,
        datasets: [
          {
            label: "Weekly Use Action Count ",
            data: cData6.data,
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
          text: "Weekly Time Spend IN Minutes",
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
    // Event Monlty Wise
  $(function(){
      //get the pie chart canvas
      var cData7 = JSON.parse(`<?php echo $montly_wise_time_spent_data['montly_wise_time_spent_data']; ?>`);
      var ctx = $("#event-montly-wise-chart_pie");
 
      //pie chart data
      var data = {
        labels: cData7.label,
        datasets: [
          {
            label: "Montly Use Action Count",
            data: cData7.data,
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
          text: "Montly Time Spend IN Minutes",
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
<!------------------------------------>
<!------------------------------------>


@endsection