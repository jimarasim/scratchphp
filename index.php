<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dream Into Action: Users</title>
        
        <script type="text/javascript">
            function displayMessage(message) {
              document.getElementById("message").innerHTML = message;  
            }
            
            function validateInput() {
                if (
                    document.forms["addUserForm"]["username"].value === "" ||
                    document.forms["addUserForm"]["password"].value === "" ||
                    document.forms["addUserForm"]["email"].value === ""
                ){
                    displayMessage("Must fill all fields");
                    return false;
                }
                
                return true;
            }
        </script>
    </head>
    <body>
        <h1>Dream Into Action: <a href="/scratchphp/index.php">Users</a></h1>
        
        <form id="addUserForm" method="post" action="/scratchphp/index.php" onsubmit="return validateInput();">
            <table border="1">
            <tr>
                <td><h4>UserName:</h4><input type="text" name="username" /></td>
                <td><h4>Password:</h4><input type="password" name="password" /></td>
                <td><h4>Email:</h4><input type="text" name="email" /></td>
                <td><input type="submit" value="Add User" /></td>
            </tr>
            </table>
            <br />
            <span id="message" style="color:red;"></span>
        </form>
        
        <?php
            $user = 'root';
            $pwd = 'Sk8Omlb';
            $db = 'dreamintoaction';
            $host = 'localhost';
            $port = 3306;
            
            $username = filter_input(INPUT_POST,"username");
            $password = filter_input(INPUT_POST,"password");
            $email = filter_input(INPUT_POST,"email");
            
            //connect to database
            $con=mysqli_connect($host,$user,$pwd,$db,$port);
            // Check connection
            if (!$con)
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }
            
            //insert user
            if($username && $password && $email) {
                
                // Perform queries 
                $insertQueryResult = mysqli_query($con,"INSERT INTO users (username,password,email) VALUES ('$username','$password','$email')");                
                if($insertQueryResult) {
                    echo ("ADDED USERNAME:".$username." PASSWORD:".$password." EMAIL:".$email."<br />");  
                } else {
                    echo("COULD NOT ADD $username: " . mysqli_error($con)."<br />");
                }
            }
            
            //show users
            $selectQueryResult = mysqli_query($con,"SELECT id,username,email,password FROM users");
            
            if($selectQueryResult) {
                echo("Users:<br />");
                while($row = mysqli_fetch_assoc($selectQueryResult)) {
                    echo "id: " . $row["id"]. " - username: " . $row["username"]. " - email: " . $row["email"]. "<br>";
                }
            } else {
                echo("COULD RETRIEVE USERS: " . mysqli_error($con));
            }
            mysqli_close($con);
            
        ?>
    </body>
</html>
