document.addEventListener("DOMContentLoaded", function() {
    let submit = document.getElementById("submit");
    let form = document.getElementById("form");
    let inputs = document.querySelectorAll("input");
    
    let errclientFullname = document.getElementById("errclientFullname");
    let erremail = document.getElementById("erremail");
    let verified = document.getElementById("verified");
    let loader = document.querySelector(".loader");

    function clearErrors() {
        errclientFullname.innerHTML = "";
        erremail.innerHTML="";
        verified.innerHTML = "ADD";
    }

    submit.addEventListener("click", function(event) {
        event.preventDefault();

        let formData = new FormData(form);
        let request = new XMLHttpRequest();
        request.open("POST", "add.php");

        request.onload = function() {
            loader.style.display = "none";
            clearErrors();

            if (request.status >= 200 && request.status < 300) {
                let response = request.responseText.trim().toLowerCase();
                console.log(response);
                
                if (response === "clientfullnameempty") {
                    errclientFullname.innerHTML = "Client Fullname is empty!";
                } else if (response === "aredyemail") {
                    erremail.innerHTML = "aredy email!";
                } else if (response.startsWith("notverified")) {
                    verified.innerHTML = "Error 404!";
                    verified.style.color = "red";
                    verified.style.textShadow = "1px 1px 12px #e7422c";
                    setTimeout(function() {
                        window.location.replace("error404.php");
                    }, 999);
                } else if (response === "verified") {
                    let iconVerified = document.createElement("img");
                    iconVerified.setAttribute("src", "img/check.gif");
                    iconVerified.id = "iconVerified";
                    verified.appendChild(iconVerified);
                    setTimeout(function() {
                        window.location.replace("../croad_CLIENT.php");
                    }, 999);
                } else {
                    verified.innerHTML = "Unexpected error occurred!";
                }
            } else {
                verified.innerHTML = "Server error: " + request.status;
            }
        };

        request.onerror = function() {
            loader.style.display = "none";
            verified.innerHTML = "Request failed!";
        };

        loader.style.display = "block";
        request.send(formData);
    });

    inputs.forEach((input) => {
        input.addEventListener("input", clearErrors);
    });
});
