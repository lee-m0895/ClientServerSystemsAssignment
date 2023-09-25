
var message = "";


//get the total number of notifications
function notify()
{
    let xhr = new XMLHttpRequest();
    //set the html element that represents the amount of notifications
    var noteTotal = document.getElementById("noteTotal");
    xhr.open("GET", "notification.php?count=true", true);
    xhr.onreadystatechange = function ()
    {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE)
        {
            if (xhr.status == OK)
            {
                //total number of notifications
                var values = this.responseText;
                noteTotal.innerText = values;
            }
        }
        else
        {
            console.log('Error: ' + xhr.status);
        }
    }
    xhr.send(null);
}



//get the messages per notification
function showMessages()
{
    let xhr = new XMLHttpRequest();
    var noteTotal = document.getElementById("noteTotal");
    xhr.open("GET", "notification.php?notifications=true", true);
    xhr.onreadystatechange = function ()
    {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE)
        {
            if (xhr.status == OK)
            {

                var values = JSON.parse(this.responseText);
                values.forEach(function (obj) {

                    let url = "lots.php?idHolder=" + obj.lotid +"&select=select"
                    if (message == "")
                    {

                        message = "<a href='"+url+"'><p class='notificationText'>" + obj.message + "</p></a>";
                    }
                    else
                    {
                        message = message + "<a href='"+url+"'><p class='notificationText'>" + obj.message + "</p></a>";
                    }


                });
                document.getElementById("notifications").innerHTML = message;
                console.log(message);
                wipe();
            }
        }
        else
        {
            console.log('Error: ' + xhr.status);
        }
    }
    xhr.send(null);
}


//wipe the notifications from the db
function wipe()
{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "notification.php?wipe=true", true);
    xhr.onreadystatechange = function ()
    {
        let DONE = 4;
        let OK = 200;
        if (xhr.readyState === DONE)
        {
            if (xhr.status == OK)
            {
            }
        }
        else
        {
            console.log('Error: ' + xhr.status);
        }
    }
    xhr.send(null);

}


