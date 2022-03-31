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
              <div class="box-main-title box-dashboard-text">PC Performance</div>         
              <div class="box-main graph-space">
                  <canvas id="pcp-chart" height="100"></canvas>
                            
                </div>
            </div>
            <div class="col-md-12 col-xl-12">     
              <div class="box-main-title box-dashboard-text">Sleep Time Performance</div>         
              <div class="box-main graph-space">
                  <canvas id="s-chart" height="100"></canvas>
                            
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




@endsection