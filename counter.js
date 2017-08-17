$.ajax({
    type : "GET",
    url : "counter.php",
    success: function(data) {document.getElementById("counter").innerHTML = data},
    xhrFields: {
      withCredentials: true
},});
setInterval(function(){
    $.ajax({
        type : "GET",
        url : "counter.php",
        success: function(data) {document.getElementById("counter").innerHTML = data},
        xhrFields: {
            withCredentials: true
     },});
},5000) 
