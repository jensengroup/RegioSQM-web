$(function()
{


    var frtPdctBtn = $('.frontpage .frontpage-sample');
    var frtInpSmiles = $('.frontpage .frontpage-sample input[type=text]')

    frtPdctBtn.submit(function () {

        frtInpSmiles.blur();

        var smile = frtInpSmiles.val();

        if(smile == "") {
            var promptBox = new $.Prompt()
            promptBox.setMessage('<p>You need to fill in a valid SMILES</p>');
            promptBox.addCancelBtn("Okay");
            promptBox.show();
            return false;
        }

        var loadPrompt = new $.Prompt();
        var loadMsg = $('<div class="main-message"></div>');
        loadPrompt.setTitle('Setting up prediction')
        loadPrompt.setMessage(loadMsg);
        var loadingbar = "<div class=\"loading_bar\"><div class=\"bar\" style=\"width: 100%;\"></div></div>";
        loadMsg.append(loadingbar);
        loadPrompt.show();


        $.ajax({
            method: "POST",
            url: "validate",
            data: { ajax: true, smiles: smile }
        })
        .done(function( msg ) {

            console.log(msg);

            if(msg.length == 32) {
                window.location.href += "results/"+msg;
            }
            else {
                console.log( "Data Saved: " + msg );
            }

        })
        .fail(function (msg) {
            console.log("Connection problem");
            console.log(msg)
        });



        return false;
    });




    var promptLink = $('.promptBoxDemo');

    promptLink.click(function ()
    {
        // Initialize prompt
        var promptBox = new $.Prompt()

        // Set message
        // Can be string...
        promptBox.setMessage('<p>A message string</p>');

        // or more advanced HTML object
        objHtml = $('<p></p>');
        objHtml.html('Hahaha ');
        objHtml.append($('<strong>More</strong>'));
        promptBox.setMessage(objHtml);

        // Set title
        promptBox.setTitle('Another annoying message box');


        // Set response
        promptBox.addResponseBtn('Alert Hello', function() {
            alert('Hello World');
        });

        // Add cancel button, also with a different string
        promptBox.addCancelBtn();

        // Finally Show the result
        promptBox.show()


        return false;
    });

});
