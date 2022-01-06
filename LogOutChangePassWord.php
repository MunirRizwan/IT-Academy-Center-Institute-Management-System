<script>
    function changeUser(user, pass) {
        var newUser = $("#userName").val();
        var oldPass = $("#oldPassword").val();
        var newPass = $("#newPassword").val();
        if (oldPass == pass) {
            $.ajax({
                url: 'ajaxInsertion.php',
                data: {user: user, pass: pass, newUser: newUser, newPass: newPass},
                type: 'POST',
                success: function (data) {
                    if (data == 11) {
                        window.location.href = window.location.href;
                    }

                }
            });

        } else {
            document.getElementById("changeError").innerHTML = " Old New Pass Does Not Match";
        }
    }


</script>