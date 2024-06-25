document.addEventListener("DOMContentLoaded", function() {
    let submit = document.getElementById("submit");
    let form = document.getElementById("form");
    let inputs = document.querySelectorAll("input");

    let errtourName = document.getElementById("errtourName");
    let errtourImgg = document.getElementById("errtourImgg");
    let verified = document.getElementById("verified");

  
    let loader = document.querySelector(".loader");

   
    function clear() {
        errtourName.innerHTML = "";
        errtourImgg.innerHTML = "";
    }

  
    submit.addEventListener("click", function(event) {
        event.preventDefault(); 

        let formData = new FormData(form);
        let request = new XMLHttpRequest();
        request.open("POST", "add.php");

        request.onload = function () {
            loader.style.display = "none";
            clear();
            
            if (request.status >= 200 && request.status < 300) {
                let response = request.responseText.trim().toLowerCase();
                console.log(response);

                if (response === "tournameempty") {
                    errtourName.innerHTML = "Tour name is empty!";
                } else if (response === "tourimgeempty") {
                    errtourImgg.innerHTML = "Tour image is empty!";
                } else if (response === "notverified") {
                    verified.innerHTML = "Error 404!";
                    verified.style.color = "red";
                    verified.style.textShadow = "1px 1px 12px #e7422c";
                    setTimeout(function () {
                        window.location.replace("error404.php");
                    }, 999);
                } else if (response === "verified") {
                    clear();
                    let iconVerified = document.createElement("img");
                    iconVerified.setAttribute("src", "img/check.gif");
                    iconVerified.id = "iconVerified";
                    verified.appendChild(iconVerified);
                    setTimeout(function () {
                         window.location.replace("../croad_TOUR.php")
                    }, 999);
                } else {
                    verified.innerHTML = "Unexpected error occurred!";
                }
            } else {
                verified.innerHTML = "Server error: " + request.status;
            }
        };

        request.onerror = function () {
            loader.style.display = "none";
            verified.innerHTML = "Request failed!";
        };

        loader.style.display = "block";
        request.send(formData);
    });

    inputs.forEach((input) => {
        input.addEventListener("input", clear);
    });

    let numberclickadd = 0;
    let addtourImgg = document.getElementById("addtourImgg");
    let addimgs = document.getElementById("addimgs");

    addtourImgg.addEventListener("click", function() {
      
        numberclickadd++;
        let imgInput = document.createElement("input");
        imgInput.type = "file";
        imgInput.id = "tourImgg" + (numberclickadd + 1);
        imgInput.name = "tourImgg" + (numberclickadd + 1);
       

        if (numberclickadd >= 4) { 
           addtourImgg.disabled = true;
        }else{
             addimgs.appendChild(imgInput);
        }
    });
});
