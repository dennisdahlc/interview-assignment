<html>
    <head>
        <title>Programming Test</title>
        <script type='text/javascript' src="controller.js"></script>
    </head>
    <body>
        Select from Users where
        <select id="Field">
            <option value="0">Id</option>
            <option value="1">First name</option>
            <option value="2">Last name</option>
            <option value="3">Email</option>
        </select>
        <select id="Operator">
            <option value="0">Equals</option>
            <option value="1">Not equals</option>
            <option value="2">Contains</option>
            <option value="3">Not contains</option>
        </select>
        <input id="Value" type="Text"/>
        <input id="SubmitSelect" type="Button" value="Submit" onclick="Controller.sendSelectEvent()"/>
        <br><br>
        <div id='Result' style="width:600px;height:300px;overflow:visible;overflow-x:scroll;white-space:nowrap;overflow-y:scroll;border:solid 1px">   
        </div>
        <br>
        <input id="ResetDatabase" type="Button" value="Reset database" onclick='Controller.sendResetEvent()'/>
    </body>
</html>