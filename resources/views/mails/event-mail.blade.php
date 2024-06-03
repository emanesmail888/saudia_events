<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Confirmation</title>
    <style>
        .white-card-research {
        width: 100%;
        padding: 10px;
        background: #ffffff;
        box-shadow: 0px 0px 30px 0px rgb(0 0 0 / 15%);
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0;
        margin-bottom: 30px;
        overflow: hidden;
        position: relative;
     }
     .white-card-research img{
        width: 100%;
        height:300px;
     }
     .white-card-research h3 {
        font-weight: 600;
        text-align: center;
        line-height: 1.5em;
        margin-bottom: 20px;
        font-size: 16px;
     }
     .white-card-research ul {
        padding-right: 30px;
     }
     .white-card-research ul li {
        margin-bottom: 10px;
         font-weight: 600;
        font-size: 13px!important;
        line-height: 1.5em;
     }
     .white-card-research .card_description {
        font-size: 13px!important;
            font-weight: 600;
        line-height: 1.5em;
        margin-bottom: 15px;
     }
     .white-card-research .card_button {
        text-align: center;
     }
     .white-card-research .card_button a {
        font-size: 14px;
        font-weight: 600;
        margin: 10px 0;
        border: solid 1px #5E1AD5;
     }
     .white-card-research .card_button a:hover {
        color: #ffffff;
        background-color: #5E1AD5;
     }
     .description-text {
        text-align: right;
        font-size: 16px;

     }
     .description-title{
        text-align: center;
        font-size: 16px;
        font-weight: 600;
     }
     #s4-bodyContainer {
         padding-bottom: 0!important;
     }

     .white-card-research .card_button {
       text-align: center;
    }
    .white-card-research .card_button a {
       font-size: 14px;
       font-weight: 600;
       margin: 10px 0;
       border: solid 1px #5E1AD5;
    }
    .white-card-research .card_button a:hover {
       color: #ffffff;
       background-color: #5E1AD5;
    }
    .description-text {
       text-align: right;
       font-size: 16px;

    }
    .description-title{
       text-align: center;
       font-size: 16px;
       font-weight: 600;
    }
    #s4-bodyContainer {
        padding-bottom: 0!important;
    }
    .row {
        margin-right: 0;
        margin-left: 0;
    }
    ul.top-header-links {
        margin-bottom: 0;
    }
    input[type=password]:hover, input[type=text]:hover {
        border-color: #00d2ff;
    }
    input[type=password], input[type=text] {
        border: 1px solid #ababab;
        background-color: #fff;
        background-color: rgba( 255,255,255,0.85 );
        color: #000062;
    }
    input[type=button], input[type=reset], input[type=submit], button {
        min-width: 6em;
        padding: 7px 10px;
        border: 1px solid #000062;
        background-color: #fdfdfd;
        margin-left: 10px;
        font-family: "loew", sans-serif;
            font-size: 12px;
        color: #000062;
    }
    .srch-advancedtable {
        margin: 10px auto;
        border: none;
        background: #fcfcfc;
        padding: 10px 25px 25px;
        width: -webkit-fill-available;
    }
    div.ms-advsearch-header {
        margin-top: 25px;
        margin-bottom: 20px;
        text-align: center;
        color: #000062;
    }
    .ms-advsrchbutton {
        text-align: inherit;
        padding: 10px;
    }
    .card-gm {
       width: 100%;
       padding: 10px;
       background: #051a31;
       box-shadow: 0px 0px 30px 0px rgb(0 0 0 / 15%);
       -webkit-border-radius: 0px;
       -moz-border-radius: 0px;
       border-radius: 0;
       border: 1px solid #00bdff;
       margin-bottom: 30px;
       overflow: hidden;
       position: relative;
           text-align: center;
    }
    .card-gm img{
        height: 110px;
    }
    .card-gm h3 {
       font-weight: 600;
       text-align: center;
       line-height: 1.5em;
       margin-bottom: 20px;
       font-size: 16px;
           background-color: #c5407e;
        COLOR: WHITE;
    }
    .card-gm ul {
       padding-right: 30px;
    }
    .card-gm ul li {
       margin-bottom: 10px;
       font-size: 13px!important;
       line-height: 1.5em;
    }
    .card-gm .gm_description {
       font-size: 13px!important;
       line-height: 1.5em;
       margin-bottom: 15px;
       COLOR: WHITE;
    }

    ul.tag {
        list-style-type: none;
        margin: 0;
        padding: 0;
        position: inherit;
    }
    ul.tag li {
        display: inline-block;
        color: #ffffff;
        border-radius: 30px;
        padding: 4px 8px;
        margin: 1px;
        font-weight: 300;
        font-size: 10px;
    }
    ul.tag li.tag_general {
        background-color: #7f92ff;
    }
    ul.tag li.tag_tel {
        background-color: #5e1ad5;
    }
    ul.tag li.tag_tech {
        background-color: #0000ff;
    }
    ul.tag li.tag_mail {
        background-color: #00c8f9;
    }
    .tags{
        margin:0;
        padding:0;

        right:24px;
        bottom:-12px;
        list-style:none;
        }
    .tags li, .tags a{
        float:left;
        height:24px;
        line-height:24px;
        position:relative;
        font-size:11px;
        }
        .tags a{
        border: 1px solid #000062;
        margin-left:20px;
        padding:0 10px 0 12px;
        background:#000062;
        color:#fff;
        text-decoration:none;
        -moz-border-radius-bottomright:4px;
        -webkit-border-bottom-right-radius:4px;
        border-bottom-right-radius:4px;
        -moz-border-radius-topright:4px;
        -webkit-border-top-right-radius:4px;
        border-top-right-radius:4px;
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
        <div class="white-card-research p-0">
        <img class="w-100" src="{{$event->event_image}}" alt="{{$event->event_name}}">
        <h3 class="mt-4 pr-3 pl-3"> {{$event->event_name}}</h3>
        <p style="text-align: center;">
        <span> {{$event->event_name}} </span>
        </p>
        <div class="card_button">
        <a class="btn" href="{{$event->url}}">الدخول</a>
        </div>
        <ul class="tags card-tags">
        <li>
        <a><span class="ms-rteThemeForeColor-1-0">{{$event->location}} </span> </a>
        </li>
        <li>
        <a> <span class="ms-rteThemeForeColor-1-0"> {{$event->start_date}}</span> </a>
        </li>
        </ul>

        </div> </div>

    @endforeach

{{-- <table style="width:600px; text-align:right;">
    <thead>
        <th>Image</th>
        <th>Name</th>
        <th>Url</th>
        <th>StartDate</th>
        <th>StartTime</th>
        <th>Duration</th>
        <th>Location</th>
    </thead>
    <tbody>

        @foreach ($events as $event )
        <tr style="margin-bottom: 6px;">
            <td><img src="{{$event->event_image}}" width="100" alt=""></td>
            <td>{{$event->event_name}}</td>
            <td>{{$event->url}}</td>
            <td>{{$event->start_date}}</td>
            <td>{{$event->start_time}}</td>
            <td>{{$event->duration}}</td>
            <td>{{$event->location}}</td>

        </tr>

        @endforeach

    </tbody>
</table> --}}

</body>
</html>
