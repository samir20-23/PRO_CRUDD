let tours = document.querySelectorAll("#tour");
let clients = document.querySelectorAll("#client");
let views = document.querySelectorAll("#view");
let  reserves = document.querySelectorAll("#reserve");
let books = document.querySelectorAll("#book");


clients.forEach(client => {
    client.addEventListener("click", () => {
        window.location.replace("croad_CLIENT.php") ;
    });
});



tours.forEach(tour => {
    tour.addEventListener("click", () => {
        window.location.replace("croad_TOUR.php"); 
    });
    
});

views.forEach(view => {
    view.addEventListener("click", () => {
        window.location.replace("croad_VIEW.php");
    });
    
});

reserves.forEach(reserve => {
    reserve.addEventListener("click", () => {
        window.location.replace("croad_RESERVE.php");
    });
    
});

books.forEach(book => {
    book.addEventListener("click", () => {
        window.location.replace("croad_BooK.php");
    });
    
});