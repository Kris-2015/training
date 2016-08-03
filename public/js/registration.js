/*
 * @author: mfsi_krishnadev
 * @access: public
 * @purpose: validation of registration form
 * @param: none
 * @return: string
*/

function validation()
{
    validateText();

    //validateNumber();

    validateEmail();

    validatePassword();
}
$(document).ready(function(){

   validation(); 
});

function validateText()
{
    $('#firstname').on('focus keypress keydown blur', function(){
        var alpha_exp = /^[A-Za-z]+$/;
        var text = $(this).val().trim();

        if(text == "")
        {
            $(".error").css("visibility","visible");
            $("#firstname_error").text("This is required.");
            //$(this).next("span").text("Only alphabets are allowed");   
        }
        else if(!text.match(alpha_exp))
        {
            $(".error").css("visibility","visible");
            $("#firstname_error").text("Only alphabets are allowed");
        }
        else
        {
            $(".error").css("visibility", "hidden");
        }
    });

    $('#middlename').on('focus keypress keydown blur', function(){
        var alpha_exp = /^[A-Za-z]+$/;
        var text = $(this).val().trim();

        if(!text.match(alpha_exp))
        {
            $(".error").css("visibility","visible");
            $("#middlename_error").text("Only alphabets are allowed");
        }
        else
        {
            $(".error").css("visibility", "hidden");
        }
    });

    $('#lastname').on('focus keypress keydown blur', function(){
        var alpha_exp = /^[A-Za-z]+$/;
        var text = $(this).val().trim();

        if(text == "")
        {
            $(".error").css("visibility","visible");
            $("#lastname_error").text("This is required.");
            //$(this).next("span").text("Only alphabets are allowed");   
        }
        else if(!text.match(alpha_exp))
        {
            $(".error").css("visibility","visible");
            $("#lastname_error").text("Only alphabets are allowed");
        }
        else
        {
            $(".error").css("visibility", "hidden");
        }
    });
}

/*function validateNumber()
{
    
}
*/

function validatePassword()
{
    $("#Password").on('focus keypress keydown blur', function(){
        var password_exp = /^[a-zA-Z0-9]*$/;
        var password_strength = /((?=.*d)(?=.*[a-z])(?=.*[A-Z]).{8,15})/gm;
        var password = $(this).val().trim();
        var confirm_password = $('#cpassword').val().trim();

        if(password == "")
        {
            $(".error").css("visibility","visible");
            $("#password_error").text("This is required");
        }
        else if(!password.match(password_exp))
        {
            $(".error").css("visibility","visible");
            $("#password_error").text("Password must contain atleast 1 number, one uppercase and one lowercase ");
        }
        else if(password == confirm_password)
        {
            $(".error").css("visibility","visible");
            $("#cpassword_error").text("Password don't match");
        }
    });
}

function validateEmail()
{
    $("#email").on('focus keypress keydown blur', function(){
        //var mail_exp =/^[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]$/;//{2,4}
        var mail = $(this).val().trim();

        if(mail == "")
        {
            $(".error").css("visibility","visible");
            $("#email_error").text("This is required");
        }
        else if(!mail.match(mail_exp))
        {
            $(".error").css("visibility","visible");
            $("#email_error").text("Invalid mail address")
        }
        else
        {
            $(".error").css("visibility","hidden");
        }
    });
}