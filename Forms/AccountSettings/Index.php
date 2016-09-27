<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Account Settings</title>
    <link rel = "stylesheet" type = "text/css" href = "../../AccountSettings/account-settings.css" >
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <style>
        /*
        TAMUCC COLOR GUIDES:
        BLUE: #0067C5
        GREEN: #007F3E
        SILVER: #9EA2A4
        */

        html{
            min-width:600px;
        }
        body{
            background-color:#fff;
        }

        #thetable
        {
            width:80%;
        }
        #thetable_left
        {
            width: 230px;
            vertical-align: top;
        }

        #thetable_right
        {
            width: 100%;
            vertical-align: top;
        }

        /*_______________________________________________________________________________________*/

        /*_______________________________________________________________________________________*/
        /*Page text Font*/
        h3 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }
        a {
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }
        /*_______________________________________________________________________________________*/
        /* _______________________________________________________________________________________  */
        /*Side menu classes */
        /* Reference: https://designshack.net/articles/navigation/verticalaccordionav/ */

        nav {
            float: left;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            line-height: 1.5;
            margin: 70px 0px 40px 15px;
            width: 240px;
            -webkit-box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            -moz-box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
        }

        .menu-item {
            background: #fff;
            width: 240px;
        }

        /*Menu Header Styles*/
        .menu-item h4 {
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            padding: 7px 12px;
            margin: 0;
        }

        .menu-item h4 a {
            color: white;
            display: block;
            text-decoration: none;
            width: 200px;
        }

        /*Menu Header Styles*/
        .menu-item h4 {
            border-bottom: 1px solid rgba(0,0,0,0.3);
            border-top: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            padding: 7px 12px;

            /*Gradient*/
            background: rgba(0,103,197,1);
            background: -moz-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,103,197,1)), color-stop(91%, rgba(0,103,197,0.89)), color-stop(100%, rgba(0,103,197,0.89)));
            background: -webkit-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -o-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -ms-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: linear-gradient(to right, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0067c5', endColorstr='#0067c5', GradientType=1 );
        }

        .menu-item h4:hover {
            background: rgba(0,127,62,1);
            background: -moz-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,127,62,1)), color-stop(14%, rgba(0,127,62,0.89)), color-stop(100%, rgba(0,127,62,0.89)));
            background: -webkit-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -o-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -ms-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: linear-gradient(to right, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#007f3e', endColorstr='#007f3e', GradientType=1 );
        }

        /*First Item Styles*/
        .alpha p {
            font-size: 13px;
            padding: 8px 12px;
            color: #aaa;
        }
        /*ul Styles*/
        .menu-item ul {
            background: #fff;
            font-size: 13px;
            line-height: 30px;
            list-style-type: none;
            overflow: hidden;
            padding: 0px;
            margin:0;
        }

        .menu-item ul a {
            margin-left: 20px;
            text-decoration: none;
            color: #0067C5;
            display: block;
            width: 200px;
        }

        /*li Styles*/
        .menu-item li {
            border-bottom: 1px solid #eee;
        }

        .menu-item li:hover {
            background: #eee;
        }

        /*ul Styles*/
        .menu-item ul {
            background: #fff;
            font-size: 13px;
            line-height: 30px;
            height: 0px; /*Collapses the menu*/
            list-style-type: none;
            overflow: hidden;
            padding: 0px;
        }

        /*ul Styles*/
        .menu-item ul {
            background: #fff;
            font-size: 13px;
            line-height: 30px;
            height: 0px;
            list-style-type: none;
            overflow: hidden;
            padding: 0px;

            /*Animation*/
            -webkit-transition: height 1s ease;
            -moz-transition: height 1s ease;
            -o-transition: height 1s ease;
            -ms-transition: height 1s ease;
            transition: height 1s ease;
        }
        /* Adjust height of submenu depends on number of submenu items: .menu-item_subN (N = number of submenu items) */
        .menu-item:hover ul {
            height:auto;
        }
        .menu-item_sub3:hover ul {
            height:95px !important;
        }
        .menu-item_sub4:hover ul {
            height:125px !important;
        }
        .menu-item_sub5:hover ul {
            height:158px !important;
        }
        /* _______________________________________________________________________________________  */
        /*Container classes */

        /*Default Container*/
        .container
        {
            margin-right:20px;
            padding:0px;
            height:100%;
        }

        .container > div{
            padding: 5px 1px 5px 1px;
            border-radius: 2px;
        }

        /* _______________________________________________________________________________________  */
        /*utility classes */
        .unselectable
        {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .nowrap
        {
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /*end utility classes */

        /* _______________________________________________________________________________________  */
        /* Button classes*/
        .button
        {
            margin: 10px;
            text-decoration: none;
            font: 1em 'PT Sans Narrow', sans-serif; /*Change the em value to scale the button*/
            display: inline-block;
            text-align: center;
            color: #fff;

            border: 1px solid #9c9c9c; /* Fallback style */
            border: 1px solid rgba(0, 0, 0, 0.3);

            text-shadow: 0 1px 0 rgba(0,0,0,0.4);

            box-shadow: 0 0 .05em rgba(0,0,0,0.4);
            -moz-box-shadow: 0 0 .05em rgba(0,0,0,0.4);
            -webkit-box-shadow: 0 0 .05em rgba(0,0,0,0.4);

        }

        .button, .button span
        {
            -moz-border-radius: .3em;
            border-radius: .3em;
        }

        .button span
        {
            border-top: 1px solid #fff; /* Fallback style */
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            display: block;
            padding: 0.5em 2.5em;

            /* The background pattern */

            background-image: -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.25, rgba(0, 0, 0, 0.05)), color-stop(.25, transparent), to(transparent)),
            -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.25, rgba(0, 0, 0, 0.05)), color-stop(.25, transparent), to(transparent)),
            -webkit-gradient(linear, 0 0, 100% 100%, color-stop(.75, transparent), color-stop(.75, rgba(0, 0, 0, 0.05))),
            -webkit-gradient(linear, 0 100%, 100% 0, color-stop(.75, transparent), color-stop(.75, rgba(0, 0, 0, 0.05)));
            background-image: -moz-linear-gradient(45deg, rgba(0, 0, 0, 0.05) 25%, transparent 25%, transparent),
            -moz-linear-gradient(45deg, rgba(0, 0, 0, 0.05) 25%, transparent 25%, transparent),
            -moz-linear-gradient(45deg, transparent 75%, rgba(0, 0, 0, 0.05) 75%),
            -moz-linear-gradient(45deg, transparent 75%, rgba(0, 0, 0, 0.05) 75%);

            /* Pattern settings */

            -moz-background-size: 3px 3px;
            -webkit-background-size: 3px 3px;
            background-size: 3px 3px;
        }

        .button:hover
        {
            box-shadow: 0 0 .1em rgba(0,0,0,0.4);
            -moz-box-shadow: 0 0 .1em rgba(0,0,0,0.4);
            -webkit-box-shadow: 0 0 .1em rgba(0,0,0,0.4);
        }

        .button:active
        {
            /* When pressed, move it down 1px */
            position: relative;
            top: 1px;
        }

        .button-blue
        {
            background: #4477a1;
            background: -webkit-gradient(linear, left top, left bottom, from(#81a8cb), to(#4477a1) );
            background: -moz-linear-gradient(-90deg, #81a8cb, #4477a1);
            filter:  progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#81a8cb', endColorstr='#4477a1');
        }

        .button-blue:hover
        {
            background: #81a8cb;
            background: -webkit-gradient(linear, left top, left bottom, from(#4477a1), to(#81a8cb) );
            background: -moz-linear-gradient(-90deg, #4477a1, #81a8cb);
            filter:  progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#4477a1', endColorstr='#81a8cb');
        }

        .button-blue:active
        {
            background: #4477a1;
        }


        /*___________________________________*/
        /* Background color: green */
        .bluebtn{
            border-radius:10px;
            color:#ffffff;
            background: rgba(0,103,197,1);
            background: -moz-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,103,197,1)), color-stop(91%, rgba(0,103,197,0.89)), color-stop(100%, rgba(0,103,197,0.89)));
            background: -webkit-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -o-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: -ms-linear-gradient(left, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
            background: linear-gradient(to right, rgba(0,103,197,1) 0%, rgba(0,103,197,0.89) 91%, rgba(0,103,197,0.89) 100%);
        }

        .bluebtn:hover{
            color:#ffffff;
            background: rgba(0,127,62,1);
            background: -moz-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,127,62,1)), color-stop(14%, rgba(0,127,62,0.89)), color-stop(100%, rgba(0,127,62,0.89)));
            background: -webkit-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -o-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: -ms-linear-gradient(left, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            background: linear-gradient(to right, rgba(0,127,62,1) 0%, rgba(0,127,62,0.89) 14%, rgba(0,127,62,0.89) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#007f3e', endColorstr='#007f3e', GradientType=1 );
        }

        /* End Button classes*/
        /* _______________________________________________________________________________________  */


        /*scrollbar style */
        ::-webkit-scrollbar {
            width: 15px;
        }
        ::-webkit-scrollbar-track {
            background-color: #eaeaea;
            border-left: 1px solid #ccc;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #0099FF;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: #73a55b;
        }
        /* end scrollbar style */
        /* _______________________________________________________________________________________  */
        /*table styles */
        .tbl{border-collapse: collapse;width:100%;color:#474E53;overflow-x:scroll;}
        .tbl tr, .tbl th, .tbl td{border:1px solid #D9E5F1;padding: 10px;}
        .tbl thead{}
        .tbl tbody{overflow-y:scroll;}
        .tbl tfoot{}
        .tbl tr{}
        .tbl th{color:#FFFFFF;background-color: #0099FF;}
        .tbl td{}
        .tbl tr:nth-child(odd){background-color:#FFFFFF;}
        .tbl tr:nth-child(even){background-color:#D9E5F1;}

        /* end table styles*/
        /* _______________________________________________________________________________________  */

        /* loader */
        .loader {
            border: 8px solid #f3f3f3; /* Light grey */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            margin:auto;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(720deg); }
        }


        /* end loader */
        /* _______________________________________________________________________________________  */


        /* Font Styles */
        h2
        {
            background: #0067C5;
            color:white;
            /*font-family:"DigifaceWide";*/
            text-align: center;
            font-weight:bold;
            margin: 10px;
            font-size: 30px;
        }
        p
        {
            color:#0067C5;
            /*font-family:"DigifaceWide";*/
            text-align: center;
            margin: 10px;
            font-size: 20px;
        }

        /* End Font Styles */
        /* _______________________________________________________________________________________  */

        form {
            margin: 0 auto;
            margin-left: 240px;
            margin-top: 20px;
        }
        label {
            color: #555;
            display: inline-block;
            margin-left: 5px;
            padding-top: 10px;
            font-size: 15px;
            font-weight:bold;
        }
        div.container {

        }

        article {
            float: left;
            margin-left: 170px;
            padding: 1em;
            overflow: hidden;
            font-size:13px;
            font-family:serif !important;;
            vertical-align:top;
            background-color: #f1f1f1;
            border-radius: 2px;
            border-width: 0px;
            box-shadow: 0px 0px 2px #0c0c0c;
            width: 55%
        }

        footer {
            background: #0079C2;
            position:fixed;
            left:0px;
            bottom:0px;
            height:30px;
            width:100%;

        }
    </style>
</head>
<body>
<header>
    <img width="300px" src="../../Images/Logos/bando-logo-medium.png"/>
</header>
    <?php include '../../Master/sidemenu.php' ?>
<article>
    <h2 style="text-align:center">Account Settings</h2>
    <p style="text-align:center">Update Your Password</p>
    <form id="frm_auth" name="frm_auth" method="post" action="Account_Processing.php">

        <div id="title">
            <table width="50%" style="text-align:center">
                <tr>
                    <td><label class="unselectable" for="username">Current Password</label>
                    </td>
                    <td>
                        <input type="text" id="txtPassword" name="oldpassword" required>
                    </td>
                </tr>
                <tr>
                    <td><label class="unselectable" for="newpassword">New Password</label></td>
                    <td>
                        <input type="password" id="txtPassword" name="newpassword" required>

                    </td>
                </tr>
                <tr>
                    <td><label class="unselectable" for="validatenew">Re-enter Password</label></td>
                    <td>
                        <input type="text" id="txtPassword" name="validatenew" required>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="bluebtn">Change Password</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>

</article>

<footer>
    <span style=" width: 100%; class="unselectable">Copyright <span id="CBI_Year"></span> Conrad Blucher Institute for Surveying and Science </span>
</footer>
<script>
    var date = new Date();
    document.getElementById("CBI_Year").innerHTML = date.getFullYear();
</script>

</body>
</html>

