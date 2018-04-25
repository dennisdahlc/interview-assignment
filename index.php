<?php

class EventHandler 
{
    public static function handleEvent()
    {
        MySQLHelper::createConnectionToDatabase();
        
        MySQLHelper::initializeDatabase();
        
        MySQLHelper::performSelectOperation();
        
        MYSQLHelper::closeConnection();
    }
}

class MySQLHelper
{
    private static $conn = null;
    
    private static $SQLForCreationOfTable = "CREATE TABLE IF NOT EXISTS users (
            id varchar(36) NOT NULL,
            firstName varchar(255) default NULL,
            lastName varchar(255) default NULL,
            email varchar(255) default NULL
        )";    
    
    private static $SQLForInsertingDatas = array(   "INSERT INTO users (id,firstName,lastName,email) VALUES ('0D00A443-93D3-8573-135D-8946397866A1','Hayes','Cruz','dui@aliquetsem.org'),('352AFADF-0A34-7933-7196-294A3AEEA6CE','Addison','Mcdonald','consectetuer.adipiscing.elit@Duissit.co.uk'),('2381734F-6F6C-1C04-C3C4-8C19F916CB4C','Dante','Hammond','et.arcu.imperdiet@euduiCum.ca'),('3CE4D4E4-D75B-577A-4D5E-2618FA753DEA','Vivien','Davis','Suspendisse.tristique@enimCurabiturmassa.net'),('35000341-23E2-BE57-DDFC-40CD7A26B4E8','Nehru','Moss','vel.turpis@condimentum.com'),('7D45EC5B-00E2-4740-A207-6281826FC959','Orlando','Cameron','elementum.lorem@arcuVestibulumante.com'),('1BDA141B-D319-92D6-D785-9C115D1D8EC5','Cheryl','Pitts','tortor.dictum.eu@cursus.edu'),('BFE85A37-944F-2375-BD31-B9E0B200469E','Rae','Aguilar','semper.dui.lectus@dui.com'),('994B5B47-54AF-D0EB-82E6-DDF8B99CD94D','Rafael','Flynn','sollicitudin.a.malesuada@nibh.edu'),('ABEB7090-D78F-1968-BCD2-4E68422005BD','Zachery','Peterson','vitae@vel.com')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('2C11AED4-BE92-BA92-F619-1C8B99A5C629','Iola','Peck','dapibus.ligula@fringillaporttitor.co.uk'),('715FC868-520F-4E08-8BBC-C2660D0FEB56','Palmer','Colon','Donec.tempus@arcuVestibulumut.org'),('A1C2BB0D-4D4B-4EBF-4390-D4A9B3375DAB','Erica','Mullen','ridiculus.mus@aptenttacitisociosqu.edu'),('20E6EC50-F135-A3D3-9A9B-51423745D162','Raya','Mcdaniel','Nunc@porttitorerosnec.net'),('0CB9F038-AC59-A6C0-2FA6-C8CA6B15A17C','Sigourney','Short','ipsum.Donec@variusNam.com'),('B4230018-6DC5-E389-D65A-158A8D74022F','Maryam','Jordan','euismod@sedturpis.org'),('A860FBAC-2EDD-765F-B81B-274F5E146204','Colt','Strong','Suspendisse.commodo.tincidunt@eget.org'),('244B1B34-918E-F5DF-49A1-F79109A2B61C','Colt','Marquez','magna.malesuada.vel@mi.org'),('A3A7A82F-6145-5D30-6B06-A0B5A3F8B102','Avye','Glass','nec.urna.suscipit@fringilla.edu'),('B65E5C81-099A-6F9B-C0D4-58EE67112BD7','Felicia','Atkins','consectetuer.ipsum.nunc@urnaNullamlobortis.co.uk')", 
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('23E50FC6-87CB-CC5B-8661-4203B3707138','Amena','Joyner','non.magna@quis.com'),('9D5B0EB6-D551-A01D-1D3B-E76F3E0E4A5A','Morgan','Best','arcu.Vivamus@temporestac.org'),('78153B7F-9E18-1716-8F03-CA122CE6EBCF','McKenzie','Shaw','ridiculus@variuset.com'),('1F20D2B0-ECF4-1D7A-15B1-014A3D7F484C','Willa','Hurley','id.ante@metus.net'),('BB72A6A0-1AE1-B967-5843-FDBBD894D807','Quintessa','Noel','ante@porttitorvulputate.co.uk'),('4835C71D-B912-FF7A-6821-1BEDD96E928A','Sandra','Slater','Cras.convallis@etmagna.edu'),('D96D3F86-E040-7C99-6BB9-A3CADFC9F592','Cathleen','Kelley','Aliquam@neceuismod.org'),('2FEB9F02-7E68-F839-5B7A-7C762B7E4EF8','Noelani','Bishop','Donec@urna.net'),('C8559747-7E02-C692-58E9-7054A9F3A2B8','Geoffrey','Massey','dui.nec@Duissitamet.net'),('63B6CF00-882A-3E6A-46D1-D3D991B6D7D7','Latifah','Landry','urna.Nunc.quis@vitae.com')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('22A4D8D9-B885-AD80-BCC5-A53A69DF22E0','Cynthia','Stone','mauris.sagittis.placerat@elementum.org'),('98D4375A-C89B-F61C-8E35-1EA4BBF31C84','Gray','Graves','ac@estconguea.edu'),('B7E63BFC-83D4-3CCF-937B-92A50D0F40A5','Jacob','Skinner','Aliquam.nec@ridiculusmusProin.co.uk'),('9E6375F0-4109-0269-0657-88217898D017','Karleigh','Roth','dictum.eu.placerat@nislMaecenas.net'),('F2163E42-8D26-C71E-46A4-CB5C8ED1C4C4','Todd','Bailey','ut@enimdiamvel.org'),('2BEAC5CE-386E-B339-3D9C-5DD24B40733C','Richard','Mcdaniel','nunc.sit@semperegestasurna.ca'),('1AE5D404-0974-8F05-3519-113119040D7E','Colleen','Drake','Sed.eget.lacus@aaliquet.com'),('0C5DDD21-69AA-FB16-E665-BA42F40DA434','Kenyon','Cotton','ac@lacusUtnec.org'),('F5D51671-5FC7-F38C-136D-3A5A8DF253AE','Callum','Doyle','consectetuer@at.co.uk'),('30C16EEC-524C-3A1E-B7F0-563CD365706F','Clarke','Hale','elit.Curabitur@nonquam.co.uk')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('642D6756-EF43-2EA6-01C7-7741D9619433','Astra','Nunez','tincidunt.tempus.risus@doloregestas.co.uk'),('BE96EC42-CE20-FC91-54C4-706339068B70','Ashely','Hensley','Nulla.eu.neque@vulputate.edu'),('D60E34FC-B7CD-217D-1409-4D523EC19F24','Zahir','Eaton','per.conubia@aliquetlobortisnisi.edu'),('92F1B087-2036-7EE6-6707-54A80ABAF3AB','Rebekah','Merrill','tellus@Pellentesquehabitant.org'),('62799656-16AE-A8CD-AF3B-A2EB30D31491','Roanna','Compton','ornare.Fusce@feugiat.co.uk'),('2A5814DD-C5B9-90FF-7DE0-BA33E8F4E231','Nerea','Mcdowell','consectetuer@ultricesVivamus.ca'),('3B09B756-6DDC-51E9-D661-DEC57FCD1661','Lila','Black','vitae.erat.Vivamus@elitEtiamlaoreet.edu'),('397512D2-7FD4-3E7D-3D2B-97BB398ABC5D','Mari','Talley','amet.diam@magna.ca'),('D4B1F79D-556E-E0E8-1D31-F999CBE7592F','Heidi','Ewing','sed.est.Nunc@atvelit.net'),('123BF1B9-5243-CB7B-FD63-B12E3EF8872F','Jamal','Joseph','Nunc.ut@etrisus.co.uk')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('020AD26A-19B3-E27C-2583-867CA569A654','Quin','Noel','Nulla.aliquet@placerat.org'),('30E48444-69F7-8AB8-23BD-7D4DCE332312','Rhiannon','Ramos','commodo.auctor.velit@nonquamPellentesque.com'),('101CBBC9-BEF3-5DD9-DE56-2A5C01A9344A','Jarrod','Forbes','orci.lacus@sedhendrerita.org'),('C88CCCCE-0CBA-7DBC-04DF-CCCF2C2458C9','Keiko','Cote','adipiscing@aliquamenimnec.net'),('E0B725E1-8AE0-4902-3511-87CD679C440D','Igor','Acosta','arcu.Sed.et@congueelit.org'),('BB784C7B-418C-F2E8-F431-73D4518F137C','Jermaine','Snow','orci@Donec.edu'),('1FD6DB44-F0BE-87DC-3E61-3EC1D245E638','Ezra','Cannon','quis.massa@nisiMaurisnulla.co.uk'),('0EA1EA62-2071-1E08-29F3-4729377B3AF8','Randall','Martinez','est.mollis.non@sagittissemper.org'),('445A942E-B506-9325-5B72-D678D10D43CD','Ava','Lancaster','et.pede.Nunc@lorem.net'),('0DA622DD-C2AF-30CC-9EF9-0060A870B22F','Minerva','Gallegos','habitant@nislNulla.com')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('67BE4EC5-6950-C2A8-2462-B7B2DF5EDAD6','Kuame','Austin','In.at@sit.co.uk'),('8AD9D122-AAB7-B6B0-B67E-29514638C7C4','Nehru','Bell','Maecenas@estNuncullamcorper.co.uk'),('5C4B4251-57DD-BB19-AA58-128DB9741C8D','Karleigh','Hull','in.sodales@nequeNullamut.net'),('78068724-D0BD-15D0-4910-7A0921F01B83','Baxter','Osborne','Nulla@adipiscingfringilla.edu'),('4460478F-3C14-67BF-7996-4377F6DB4267','Octavia','Vang','vestibulum.Mauris@sitamet.edu'),('CD522BBA-DE58-9B91-3019-CE87C234F3A5','Aristotle','Carney','Nulla.tempor.augue@temporaugue.org'),('970B5895-D6AF-3F1F-04AE-1BF08DB7B2E4','Connor','Stark','massa.Quisque.porttitor@lacus.edu'),('F42BB107-6E6D-780F-20D7-483DD2A9044F','Brendan','Huffman','nibh.sit.amet@ligulaNullamenim.edu'),('0CD41DB1-1EF1-80FA-9987-34409A4D2727','Edan','Russo','ac.turpis@euismodac.co.uk'),('4F01F6A5-1227-BC1D-9BF7-F532FF335301','Dorian','Mckinney','ante.ipsum@Integeraliquamadipiscing.co.uk')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('10EBD5C1-2ABC-282A-4224-579731A933AF','Stephen','Swanson','elit.pharetra.ut@nondui.net'),('2B97A3FD-D94C-F050-C21C-856F725F2F3D','Rana','Collins','bibendum@varius.org'),('846D797E-A789-D22B-4E9A-B30A0264A8F9','Genevieve','Colon','est.Nunc@ultriciesadipiscing.edu'),('EE10DD9F-76C6-EC25-9885-25AFAD475E57','Clinton','Barnes','lectus.rutrum@quisaccumsanconvallis.ca'),('63998977-1E32-0490-CF87-8817BCB3CA73','Chiquita','Whitfield','senectus.et@est.org'),('EC5EB609-7647-F2CB-F677-1E720A6C0E05','Andrew','Hess','facilisi.Sed.neque@ultriciesornareelit.co.uk'),('CEE3A2C6-A33B-9EB6-0D89-A6037620E118','Kimberley','Mcfarland','a@gravidamauris.com'),('CE7B1977-483D-A45B-08C8-63F300F7F310','Jerry','Lowery','eget.laoreet.posuere@tincidunt.org'),('E5DA6D64-47BF-44E5-A9F2-BF6FB87C897F','Zachary','Moore','eget.tincidunt.dui@nequesedsem.net'),('185A620C-2E36-DD8C-CCBE-8E5741BD9A1C','Karen','Simon','montes.nascetur.ridiculus@Donec.edu')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('9411E176-8C62-E7F3-663D-020EFC699252','Mari','Morrow','quis@egetipsumDonec.co.uk'),('507E0F5E-B757-F66E-8822-AFA58942E030','Jessamine','Townsend','porttitor@adipiscingelitEtiam.net'),('53B5ACF9-DB58-EE7B-E543-FAD75D3C3A5D','Idona','Hubbard','nulla.Donec@cubiliaCuraeDonec.ca'),('A700E7B0-1B59-1D07-D15E-4BCA16644F76','Jeanette','Roberts','mauris.blandit@arcu.net'),('916EF0EE-BDD6-2C55-37D7-76D86457C59C','Kellie','Byers','aliquet@consectetueradipiscing.org'),('C1C63838-729E-7B69-E9BD-B73A94B746A9','Lee','Burns','iaculis.aliquet@mollisInteger.edu'),('6CF8EC1C-1AE5-AAA5-98F3-E34C1822E00C','Cameron','Sharpe','lorem.tristique.aliquet@urnasuscipit.com'),('6D1C2DF9-A038-64A1-D255-DE2043ABBF77','Ray','Kirk','erat@velit.co.uk'),('C7089694-9276-C1BE-2093-F728CACAB242','Georgia','Ballard','elementum.sem@scelerisque.edu'),('88645CF2-164D-C371-F76E-58EEE107956E','Brett','Sutton','scelerisque.lorem.ipsum@necleoMorbi.org')",
                                                    "INSERT INTO users (id,firstName,lastName,email) VALUES ('9C846116-8094-5B40-0E32-DFBE423AB443','Kaseem','Vargas','iaculis@Nullamfeugiatplacerat.net'),('258A68BB-2884-3804-63BF-C353F910F5E7','Vladimir','Orr','accumsan.laoreet.ipsum@mauris.com'),('BD427875-A3B1-1D4C-AECB-01AD5FCD967F','Jelani','Mcbride','fermentum.convallis.ligula@aliquet.ca'),('2A73F1B9-4B34-9005-7EF4-20C6E069A239','Tashya','Gill','orci.tincidunt.adipiscing@pretiumetrutrum.com'),('559E2C78-0F96-6A7E-244E-FB170A6A3008','Rama','Mccullough','tellus@bibendumullamcorper.edu'),('47E4D5A5-D77D-F5FC-D2A6-5BF675B5A6A3','Igor','Mooney','Sed@vehiculaetrutrum.net'),('5E3C43C0-944A-E71D-0D79-FB926AB6D832','Marny','Graham','lacus@milorem.ca'),('30F30B2E-A8AF-2D21-339B-9F84F88839E5','Aphrodite','Osborne','Curabitur.massa.Vestibulum@eueros.co.uk'),('55A4BAF8-09CB-68C8-C881-E547714FBC16','Colin','Reese','eu@elit.org'),('E7B51383-96F8-D6FB-F416-507292BC1763','Cynthia','Madden','ut.cursus.luctus@utipsumac.org')",
                                                    );
    
    private static $SQLForWipingTable = "DELETE FROM users";
    
    private static $SQLForSelection = "SELECT id, firstname, lastname, email FROM users where EXPRESSION";
    private static $SQLColumnNames = array("id", "firstname", "lastname", "email");
    private static $SQLOperators = array("= 'VALUE'", "<> 'VALUE'", " LIKE '%VALUE%'", " NOT LIKE '%VALUE%'");
    
    public static function createConnectionToDatabase()
    {
        $servername = "localhost";
        $username = "adminUser";
        $password = "Test1234";
        $databaseName = "test";

        self::$conn = new mysqli($servername, $username, $password, $databaseName);
        
        $connectionError = self::$conn->connect_error;
        
        if ($connectionError)
        {
            self::terminateWithErrorMessageAndError("Failed to create connection", $connectionError);
        }
    }
    
    public static function initializeDatabase()
    {
        self::executeSQL(self::$SQLForCreationOfTable, "Failed to create table");
        
        self::executeSQL(self::$SQLForWipingTable, "Failed to wipe table");
        
        for ($index = 0; $index < count(self::$SQLForInsertingDatas); $index++) 
        {
            self::executeSQL(self::$SQLForInsertingDatas[$index], "Failed to insert data");
        } 
    }
    
    public static function performSelectOperation()
    {
        $SQL = self::constructSQLForSelect();
        $result = self::executeSQL($SQL, "Failed to perform select");

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                echo "id: " . $row["id"] . " - Name: " . $row["firstname"]. " " . $row["lastname"] . " " . $row["email"] . "<br>";
            }
        } 
    }
    
    public static function closeConnection()
    {
        self::$conn->close();
    }    
    
    private static function constructSQLForSelect()
    {
        $columnName = self::$SQLColumnNames[2];
        $operator = self::$SQLOperators[2];
        $value = "ey";
        
        $expression = $columnName . str_replace("VALUE", $value, $operator);
        
        $SQL = str_replace("EXPRESSION", $expression, self::$SQLForSelection);
        
        return $SQL;
    }
    
    private static function executeSQL($SQL, $errorMessage)
    {
        $response = self::$conn->query($SQL);
        
        if ($response === FALSE)
        {
            self::terminateWithErrorMessage($errorMessage, $SQL);
        }
        
        return $response;
    }
    
    private static function terminateWithErrorMessage($errorMessage, $SQL)
    {
        self::terminateWithErrorMessageAndError($errorMessage, self::$conn->error, $SQL);
    }
    
    private static function terminateWithErrorMessageAndError($errorMessage, $error, $SQL)
    {
        self::closeConnection();
        die($errorMessage . " with error: " . $error . "<br> SQL: " . $SQL);
    }
}

EventHandler::handleEvent();

?> 