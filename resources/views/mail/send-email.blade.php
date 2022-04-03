<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

  body{
    font-family: 'Source Sans Pro', sans-serif;
    color: #CCC;
  }
@media(max-width: 991px){
    .containerclass{
        width: 90%!important;
        margin-top: 100px!important;
    }
    .img{
    background-size: contain!important;
    background-position: inherit!important;
    height: 40vh!important;
    width: 100%!important;
    margin-top: 30px!important;
    }
}
</style>
</head>
<body>
    <div style="width: 90%;margin: auto;" class="containerclass">
        
        <h2 style="text-align:center;font-weight: bold;font-size: 18px;margin-top:30px;">Hello,</h2>
    
        <p style="text-align:center;margin-top:20px;font-weight: bold;"><img src="{{URL('public/32.png')}}">Please, use the verification code below to access Prdikt app.</p>
    
        <h2 style="text-align:center;font-weight: bold;font-size: 32px;">{!! stripslashes( $data['message']) !!}</h2>
    
        <p style="text-align:center;margin-top:20px;font-weight: bold;">If you didn't request it, you can ignore this email or let us know.</p>
    
        <p style="margin-top:20px;font-weight: bold;">From Prdikt.</p>

        <p style="margin-top:20px;font-weight: bold;"><img src="{{URL('public/32(2).png')}}"> <img src="{{URL('public/32(3).png')}}">Have the question about the closed beta? We'd love to answer! Just hit reply or read some answer <a href="https://prdikt.notion.site/Closed-Beta-FAQ-8215ee2742ad446f9ad6242972059fcc" style="color: #35797a;">here</a></p>

        <span style="border-bottom:1px solid grey;width: 100%;display: block;margin-top:40px;"></span>

        <h4 style="font-weight:bold;">TDLR;</h4>
       
        <p style="font-weight:bold;">
            <span>PROBLEM :</span> It is impossible to know when productivity will be high in the future, yet every business professional has to schedule critical activities.
        </p> 
        <p style="font-weight:bold;">
            <span>SOLUTION :</span> An app that uses wellness and fitness tech powered by AI to predict future peaks and dips of performance capacities. 
        </p> 
        <p style="font-weight:bold;">
            <span>VALUE :</span> The right thing are scheduled for the right time - when cognitive capacities are the highest, maximising the flow and productivity.
        </p>  
    </div>
    <div style="background-color: #292929;text-align:center;padding-top: 80px;margin-top: 100px;">
        <div style="display: block;margin:auto;">
             <span style="margin-right: 15px;margin-left:15px;display: inline-block;border-radius:100%;border: 1px solid #fff;padding:8px;"><img src="{{URL('public/unnamed(1).png')}}" height="20px;"></span> 
             <span style="margin-right: 15px;margin-left:15px;display: inline-block;border-radius:100%;border: 1px solid #fff;padding:8px;"><img src="{{URL('public/unnamed(2).png')}}" height="20px;"></span> 
             <span style="margin-right: 15px;margin-left:15px;display: inline-block;border-radius:100%;border: 1px solid #fff;padding:8px;"><img src="{{URL('public/unnamed(3).png')}}" height="20px;"></span> 
        </div>
        <div style="padding:0px 10px;">
            <div class="img" style="background-image: url('https://prdikt.notion.site/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2Ff9e1f40f-82a0-475e-8f3b-60dcf807e1ad%2Fbakcground_LI.jpeg?table=block&id=4f31746a-d0e9-4fea-805a-62a647a5fcbe&spaceId=67511a22-cb68-4317-82a9-69bf3dfcc16a&width=2000&userId=&cache=v2');background-position: center;background-repeat: no-repeat;background-size: cover;height: 40vh;width: 100%;margin-top: 30px;">
            </div>
        </div>
    </div>
</body>
</html>
