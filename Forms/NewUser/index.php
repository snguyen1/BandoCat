<?php
//for admin use only
include '../../Library/SessionManager.php';
$session = new SessionManager();
if($session->isAdmin()) {
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
}
else header('Location: ../../');
require('../../Library/ControlsRender.php');
$Render = new ControlsRender();
?>
<!doctype html>
<html lang="en">
<!-- HTML HEADER -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>New User</title>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../../Master/bandocat_custom_bootstrap.css">
</head>
<body>
<?php include "../../Master/bandocat_mega_menu.php"; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Put Page Contents Here -->
            <h1 class="text-center">New User</h1>
            <hr>

            <div class="d-flex justify-content-center">
                <div class="card" style="width: 35em;">
                    <div class="card-body">
                        <!--New user input form-->
                        <form id="userForm" class="needs-validation" novalidate>
                            <div class="form-row">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" placeholder="Full Name">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <!-- Username -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Username" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            You need to enter a username.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            These passwords do not match.
                                        </div>
                                    </div>
                                </div>
                                <!-- Retype Password -->
                                <div class="col-md-6">
                                    <div class="form-group" id="retypeGroup">
                                        <label for="retypePassword">Retype Password</label>
                                        <input type="password" class="form-control" id="retypePassword" placeholder="Retype Password" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback" id="invalidRetype">
                                            These passwords do not match.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Password">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <!-- User Permission -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="permissionSelect">User Permission</label>
                                        <select id="permissionSelect" class="form-control" oninput="dropdownPermission()" required>
                                            <?php
                                            $userArray = $DB->GET_USER_ROLE_FOR_DROPDOWN();
                                            unset($userArray[1]);
                                            $Render->GET_DDL_ROLE($userArray, $userArray)
                                            ?>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            You must select the user's permission.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <!-- Button -->
                                <input type="submit" value="Register" class="btn btn-primary"/>
                            </div>
                            <!--User permission description-->
                            <div>
                                <!--Inactive-->
                                <p style="display: none"><?php echo ($DB->GET_USER_ROLE_FOR_DROPDOWN()[0]["description"]); ?></p>
                                <!--Super Admin-->
                                <p style="display: none"><?php echo ($DB->GET_USER_ROLE_FOR_DROPDOWN()[1]["description"]); ?></p>
                                <!--Admin-->
                                <p style="display: none"><?php echo ($DB->GET_USER_ROLE_FOR_DROPDOWN()[2]["description"]); ?></p>
                                <!--Writer-->
                                <p style="display: none"><?php echo ($DB->GET_USER_ROLE_FOR_DROPDOWN()[3]["description"]); ?></p>
                                <!--Reader-->
                                <p style="display: none"><?php echo ($DB->GET_USER_ROLE_FOR_DROPDOWN()[4]["description"]); ?></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- col -->
    </div> <!-- row -->
</div><!-- Container -->
<?php include "../../Master/bandocat_footer.php" ?>


<!-- Complete JavaScript Bundle -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- JQuery UI cdn -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

<!-- Our custom javascript file -->
<script type="text/javascript" src="../../Master/master.js"></script>

<!-- This Script Needs to Be added to Every Page, If the Sizing is off from dynamic content loading, then this will need to be taken away or adjusted -->
<script>
    $(document).ready(function() {

        var docHeight = $(window).height();
        var footerHeight = $('#footer').height();
        var footerTop = $('#footer').position().top + footerHeight;

        if (footerTop < docHeight)
            $('#footer').css('margin-top', 0 + (docHeight - footerTop) + 'px');
    });
</script>
<!-- Page Level Plugin -->
<script>
    //Global variables
    var User = document.getElementById("userForm");
    var userInput = [];

    //Function that is used to display the permission description when the drop-down receives an input//
    function dropdownPermission() {
        var selectedIndex = document.getElementById("permissionSelect").options.selectedIndex;
        var selectedLength = document.getElementById("permissionSelect").options.length;

//For loop that makes the style of all properties in the form element display none//
        for(i=0; i < selectedLength; i++){
            if( $("." + i.toString()).is(":visible")){
                $("." + i.toString()).css("display", "none");
                $("." + i.toString()).css("transition", "opacity 1s ease-out");
            }
        }

//Conditional statement that displays only the selected information linked to the permission drop-down//
        if (selectedIndex > 0){
            $("." + selectedIndex.toString()).css("display", "block");
        }
    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    else if(checkPassword() === false)
                    {
                        alert("The passwords do not match, please fix it!");
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    else if(passwordPattern() === false)
                    {
                        alert("Your password is not strong enough!");
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    else
                    {
                        var i;

                        for (i = 0; i < User.length - 1; i++) {
                            userInput.push(User.elements[i].value);
                        }

                        userInput.splice(2, 2, User.elements[2].value);
                        var userJSON = JSON.stringify(userInput);
                        var user = JSON.parse(userJSON);

                        $.ajax({
                            type: "POST",
                            url: "newuser_processing.php",
                            data: {data: user},
                            success: function (data) {
                                console.log(data);
                                if (data == "NEW") {
                                    console.log(data);
                                    alert("New user created successfully.");
                                }
                                else {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    alert("New user created unsuccessfully, user name already exists.");
                                }
                            }
                        });
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $('#retypePassword').keyup(function() {

        if(checkPassword() === false)
        {
            $('#invalidRetype').show();
            $('#retypeGroup').addClass("has-error has-feedback");
        }
        else
        {
            $('#invalidRetype').hide();
            $('#retypeGroup').addClass("has-succes has-feedback");
        }
    });

    function checkPassword()
    {
        var password = $("#password").val();
        var retypePassword = $("#retypePassword").val();

        return retypePassword === password;
    }

    function passwordPattern()
    {
        // Password must be:
        // one lowercase character
        // one uppercase character
        // one special character
        // no whitespaces
        // one number
        // https://search.proquest.com/docview/1863277285?pq-origsite=summon The link here discusses password strengths and why we use it
        var regex = new RegExp(/^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,32}$/);
        var password = $("#password").val();

        // Make sure you call check password before calling this function
        return regex.test(password);
    }
</script>
</body>
</html>