<div id="navbar">
    <div class="markDiv"><a href="/index.php">Todo<sup>2</sup></a></div>
    
    <div id="searchbar">
        <form action="" method="GET"> 
            <input type="text" name="searchquery" placeholder="Type here to search">
            <button type="submit">Find</button>
        </form>
    </div>
    
<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); 
include "conn.php";
	session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        if (isset($_SESSION["uid"]) && isset($_SESSION["username"])) {
            echo "<button id='usermenu'>".$_SESSION['username']."</button>";
        } else if (isset($_COOKIE["stay"])) {
            if ($_COOKIE["stay"] != "") {
                $cookie = $conn->real_escape_string($_COOKIE["stay"]);
                $query = "SELECT user_id FROM cookies WHERE value = '$cookie'";
                $res = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($res) == 0) {
                    setcookie("stay", "", time() - 9999999, "/");
                } else if (mysqli_num_rows($res) > 1) {
                    $query = "DELETE FROM cookies WHERE value = '$cookie'";
                    mysqli_query($conn, $query);
                    setcookie("stay", "", time() - 9999999, "/");
                    mysqli_close($conn);
                } else if (mysqli_num_rows($res) === 1) {
                    $UID = mysqli_fetch_array($res)["user_id"];
                    $query = "SELECT username, id FROM user WHERE id = '$UID' LIMIT 1";
                    $res = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($res);
                    session_start();
                    $_SESSION["uid"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    echo "<button id='usermenu'>".$_SESSION['username']."</button>";    
                }
            } else {
                goto end;
            }
        } else {
            goto end;
        }
    } else {
        end:
        mysqli_close($conn);
        echo '<a href="login.php"><button>Log In</button></a>';
    }
    ?>
 
   <div id="userActions" style="display:none;">
        <a href="/components/logOut.php"><button>Log out</button></a>
        <a href="/components/settings.php"><button>Account settings</button></a>
        <a href="/index.php?displayMode=1"><button>Completed tasks</button></a>
        <?php 
        if (isset($_SESSION["isAdmin"])) {
            if ($_SESSION["isAdmin"] == 1) {
                echo '
                <form action="/components/admin.php" method="POST">
                    <button type="submit" name="blank" value="">Control pane</button>
                </form>';
            }
        }
        ?>
    </div>
</div>

