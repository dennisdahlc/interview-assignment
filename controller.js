Controller =
{
    sendEvent: function(event)
    {
        var stringifiedEvent = encodeURI(JSON.stringify(event));
        
        var request = new XMLHttpRequest();
        request.onreadystatechange = this.receiveEvent.bind(this, request);
        request.open("POST", "eventhandler.php", true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("data=" + stringifiedEvent);
    },
    
    sendSelectEvent: function()
    {
        var event = new Object();
        
        event.name = "Select";
        event.field = document.getElementById("Field").value;
        event.operator = document.getElementById("Operator").value;
        event.value = document.getElementById("Value").value;
        
        this.sendEvent(event);
    },
    
    sendResetEvent: function()
    {
        var event = new Object();
        
        event.name = "Reset";
        
        this.sendEvent(event);
    },
    
    receiveEvent: function(request)
    {
        var responseText = "Request failed";
        
        if (request.readyState === 4 && request.status === 200)
        {
            responseText = request.responseText;
        }
        
        document.getElementById("Result").innerHTML = responseText;
    }
};