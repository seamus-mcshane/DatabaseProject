<!DOCTYPE html>
<!-- http://localhost/Database%20Website/Login.php -->
<!-- This website template was created by: Seamus McShane-->

<html lang=:en">
<html>
    <head>
        <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css">
        <title>User Page</title> 
        <meta charset="utf-8">
        <meta name="viewport" conent="width=device-width, initial-scale=1">
    </head>
    <body>
        <style>
            body {
              background-image: url('images/wrath-of-godBackground.jpg');
            }
        </style>

        <!-- Use the nav area to ass hyperlink to other pages within the website-->
        <nav>
            <ul>
                <li><a href="Login.php">Login</a> </li>
                <li><a href="User.php">User</a> </li>
                <li><a href="Admin.php">Admin</a> </li>
            </ul>
        </nav>
        <main>
            <p> The content for the page goes here</p>
        </main>

        <table>
            <tr>
                <th>Collection_Id</th>
                <th>Username</th>
                <th>Collection_Name</th>
                <th></th>
            </tr>
            <?php
            session_start();
            if(isset($_POST['username'])){
                echo "Post exited";
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                unset($_POST);
            }
            else{
                echo "didnt use post";
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
            }
            $conn = mysqli_connect("localhost", "root", "", "card_db");
            
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if ($conn->query("SELECT Username,Password FROM users WHERE Username = '$username' AND Password = '$password';")->fetch_assoc()){ 
                    echo $username;
                }
                else{
                    echo "An account with the entered username and password doesnt exist";
                    #pop-up that lets the user know they entered an incorrect username or password
                    #header("Refresh:0; url=http://localhost/Database Website/Login.php"); 
                }
                $sql = "SELECT * FROM collections WHERE Username = '$username'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["Collection_ID"]. 
                        "</td><td>" . $row["Username"] . 
                        "</td><td><a href='Content.php?Collection_ID=".$row['Collection_ID']."'>". $row["Name"].
                        "<td><a href='removeCollection.php?Collection_ID=". $row['Collection_ID']."'>" . "Remove" .
                        "</td></tr>";
                    }
                    echo "</table>";
                } else { echo "0 results"; }
            $conn->close();
            ?>
        </table>
        <form action="newProcessor.php" method="post">
            <label for="Name">Collection Name</label>
            <input type="text" id="Name" name="Name">
            
            <button>Create Collection</button>
        </form>
    </body>
</html>