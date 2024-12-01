<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Confirmation</title>
    <style>
      
     .white-card-research .card_button a:hover {
        color: #ffffff;
        background-color: #5E1AD5;
     }
    
        #s4-bodyContainer {
            padding-bottom: 0!important;
        }

   
        .white-card-research .card_button a:hover {
        color: #ffffff;
        background-color: #5E1AD5;
        }

        #s4-bodyContainer {
            padding-bottom: 0!important;
        }
        .row {
            margin-right: 0;
            margin-left: 0;
        }
    

 
       .tags a:before{
        content:"";
        float:left;
        position:absolute;
        top:0;
        left:-12px;
        width:0;
        height:0;
        border-color:transparent #000062 transparent transparent;
        border-style:solid;
        border-width:12px 12px 12px 0;
        }
        .tags a:after{
        content:"";
        position:absolute;
        top:10px;
        left:0;
        float:left;
        width:4px;
        height:4px;
        -moz-border-radius:2px;
        -webkit-border-radius:2px;
        border-radius:2px;
        background:#00c8f9;
        -moz-box-shadow:-1px -1px 2px #004977;
        -webkit-box-shadow:-1px -1px 2px #004977;
        box-shadow:-1px -1px 2px #004977;
        }
        .tags.card-tags {
        margin: 0 auto;
        display: table;
        }
        .tags.card-tags a:before {
        top: -1px;
        }
        .tags li.move_tag a {
            background-color: #7f92ff!important;
            border: 1px solid #7f92ff!important;
        }
        .tags li.move_tag a:before {
            border-color: transparent #7f92ff transparent transparent!important;
        }
        .tags li.purple_tag a {
            background-color: #5e1ad5!important;
            border: 1px solid #5e1ad5!important;
        }
        .tags li.purple_tag a:before {
            border-color: transparent #5e1ad5 transparent transparent!important;
        }
        .tags li.lpurple_tag a {
            background-color: #8653df!important;
            border: 1px solid #8653df!important;
        }
        .tags li.lpurple_tag a:before {
            border-color: transparent #8653df transparent transparent!important;
        }
        .tags li.dblue_tag a {
            background-color: #00B2FF!important;
            border: 1px solid #00B2FF!important;
        }
        .tags li.dblue_tag a:before {
            border-color: transparent #00B2FF transparent transparent!important;
        }
        .tags li.neon_tag a {
            background-color: #00c8f9!important;
            border: 1px solid #00c8f9!important;
        }
        .tags li.neon_tag a:before {
            border-color: transparent #00c8f9 transparent transparent!important;
        }
        .tags li.dneon_tag a {
            background-color: #0099cc!important;
            border: 1px solid #0099cc!important;
        }
        .tags li.dneon_tag a:before {
            border-color: transparent #0099cc transparent transparent!important;
        }
        .tags li.lblue_tag a {
            background-color: #0000c8!important;
            border: 1px solid #0000c8!important;
        }
        .tags li.lblue_tag a:before {
            border-color: transparent #0000c8 transparent transparent!important;
        }
        .tags li.llblue_tag a {
            background-color: #4040ff!important;
            border: 1px solid #4040ff!important;
        }
        .tags li.llblue_tag a:before {
            border-color: transparent #4040ff transparent transparent!important;
        }
    </style>
</head>

<body>

    <p>Hi {{$user->name}}</p>
    <p>Your Weekly Notifications of Events!</p>
    <br>
    @foreach ($events as $event )

    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 30px;">
        <div class="white-card-research p-0" style=" width: 100%;
        padding: 10px;
        background: #ffffff;
        box-shadow: 0px 0px 30px 0px rgb(0 0 0 / 15%);
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0;
        margin-bottom: 30px;
        overflow: hidden;
        position: relative;">

        <img class="w-100" src="{{$event->event_image}}" alt="{{$event->event_name}}" style=" width: 100%;
        height:300px;">
        <h3 class="mt-4 pr-3 pl-3" style="font-weight: 600;
        text-align: center;
        line-height: 1.5em;
        margin-bottom: 20px;
        font-size: 16px;"> {{$event->event_name}}</h3>

        <p style="text-align: center;">
        <span> {{$event->event_name}} </span>
        </p>
        <div class="card_button" style="text-align: center;">
        <a class="btn d-block" href="{{$event->url}}" style="min-width: 14em;
        padding: 10px 18px;
        border: 1px solid #000062;
        background-color: #fdfdfd;
        color: #000062;
        font-size: 14px;
        font-weight: 600;
        margin: 18px 0;
        border: solid 1px #5E1AD5;text-decoration:none;"
        >الدخول</a>
        </div>

        <ul class="tags card-tags" style="
        padding:0;
        right:24px;
        list-style:none;
        margin: 25px auto;
        display: table;">

        <li style="float:left;
        height:24px;
        line-height:24px;
        position:relative;
        font-size:11px;">

        <a style="border: 1px solid #000062;
        margin-left:0px;
        padding:5px 10px 5px 12px;
        background:#000062;
        color:#fff;
        text-decoration:none;
        -moz-border-radius-bottomright:4px;
        -webkit-border-bottom-right-radius:4px;
        border-bottom-right-radius:4px;
        -moz-border-radius-topright:4px;
        -webkit-border-top-right-radius:4px;
        border-top-right-radius:4px;"><span class="ms-rteThemeForeColor-1-0">{{$event->location}} </span> </a>
        </li>
        <li style="float:left;
        height:24px;
        line-height:24px;
        position:relative;
        font-size:11px;">

        <a style="border: 1px solid #000062;
        margin-left:20px;
        padding:5px 10px 5px 12px;
        background:#000062;
        color:#fff;
        text-decoration:none;
        -moz-border-radius-bottomright:4px;
        -webkit-border-bottom-right-radius:4px;
        border-bottom-right-radius:4px;
        -moz-border-radius-topright:4px;
        -webkit-border-top-right-radius:4px;
        border-top-right-radius:4px;"> <span class="ms-rteThemeForeColor-1-0"> {{$event->start_date}}-{{$event->end_date}}</span> </a>
        </li>
        </ul>

        </div> </div>

    @endforeach


</body>
</html>
