$(function () {
    $('#submit').on('click', function (e) {

        //avoiding refresh
        e.preventDefault();

        //fetch data from each input
        var name = $('#name').val();
        var email = $('#email').val();
        var msg = $('#msg').val();

        //gather all input data into one var
        var dataString = "name=" + name + "&email=" + email + "&msg=" + msg;

        //checks if any input is empty
        if (name == "" || email == "" || msg == "") {

            // if there's a success class remove it
            if ($('#response').hasClass("alert alert-success")) {
                $('#response').removeClass("alert alert-success");
            }
            $('#response').addClass("alert alert-danger").html('Please fill up all fields').show();
        } else {

            //checking if it's a proper email
            var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var validEmail = regEx.test(email);
            if (!validEmail) {
                $('#response').addClass("alert alert-danger").html('Enter a valid email').show();
            } else {

                // if there's a danger class remove it
                if ($('#response').hasClass("alert alert-danger")) {
                    $('#response').removeClass("alert alert-danger");
                }

                //if message div is hidden show up
                if ($('#response').is(":hidden")) {
                    $('#response').show();
                }

                $.ajax({
                    type: 'post',
                    url: 'index.php',
                    data: dataString,
                    cache: false,
                    success: function (result) {

                        //empties whole form input
                        $('#form-box')[0].reset();

                        // shows message ,delays 3 sec. and div hides
                        $('#response').addClass("alert alert-success").html(result).delay(5000).queue(function (next) {
                            $(this).hide('#response');
                            next();
                        });
                    }
                });
            }
        }
        return false;
    });

});