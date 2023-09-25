

function hint(str)
{
    //get the type of search
    var type = document.title;
    console.log(type);
    console.log(str);
    //check if search is empty
    if (str == "") {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
    }
    else
        //if search is not empty run the following
    {
        var xhr = new XMLHttpRequest();
        var e = document.getElementById("selector");
        var value = e.options[e.selectedIndex].value;
        xhr.open("GET", "getBid.php?str="+str+"&searchBy="+value+"&searchType="+ type, true);
        xhr.onreadystatechange = function ()
        {
            var DONE = 4;
            var OK = 200;
            if (xhr.readyState === DONE)
            {
                if (xhr.status === OK)
                {

                    //format the results
                    var hint= "";
                    if (this.responseText == "no results")
                    {
                        //alert console there are no results used for debugging
                        console.log("no results");
                    }
                    else
                    {

                        var liveSearch = document.getElementById("livesearch");
                        liveSearch.innerHTML = "";
                        var values = JSON.parse(this.responseText);
                        console.log(this.responseText);
                        //html setup for result list
                        values.forEach(function (obj) {
                            console.log(obj.title);
                            if (hint == "")
                            {
                                //result from search html
                                let link = "lots.php?idHolder=" + obj.id + "&select=select";
                                hint = "<a href ='"+link+"'><div class='srcResults'><img class='srcThumbnail' width='30' height='30' src="+ obj.url+">" +
                                    " <p class='srcTitle'>"+ obj.title +"</p></div></a>";
                            }
                            else
                            {
                                //result from search html
                                let link = "lots.php?idHolder=" + obj.id + "&select=select";
                                hint = hint + "<a href='"+link+"'><div class='srcResults'><img class='srcThumbnail' width='30' height='30' src="+ obj.url+"> " +
                                    "<p class='srcTitle'>"+ obj.title +"</p></div></a>";
                            }
                        });
                    }
                    //show the hint
                    document.getElementById("livesearch").innerHTML= hint;

                }
                else
                {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
        xhr.send(null);
    }

}