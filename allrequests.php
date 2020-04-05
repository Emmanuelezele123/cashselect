<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newpredict";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo 0;
}
if (isset($_POST['cat'])) {


    $category = $_POST['cat'];
} else {
}

switch ($category) {

    case 'signup':

        if (isset($_POST['userName'])) {
            $userName = $_POST['userName'];
            $userName = mysqli_real_escape_string($conn, $userName);
        } else {
            $userName = 0;
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $email = mysqli_real_escape_string($conn, $email);
        } else {
            $email = 0;
        }

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            $password = mysqli_real_escape_string($conn, $password);
            $password = md5($password);
        } else {
            $password = 0;
        }

        if (isset($_POST['phoneNo'])) {
            $phoneNo = $_POST['phoneNo'];
        } else {
            $phoneNo  = 0;
        }

        if (isset($_POST['accountNo'])) {
            $accountNo = $_POST['accountNo'];
            $accountNo = mysqli_real_escape_string($conn, $accountNo);
        } else {
            $accountNo = 0;
        }
        if (isset($_POST['accountName'])) {
            $accountName = $_POST['accountName'];
            $accountName = mysqli_real_escape_string($conn, $accountName);
        } else {
            $accountName = 0;
        }
        if (isset($_POST['bankName'])) {
            $bankName = $_POST['bankName'];
            $bankName = mysqli_real_escape_string($conn, $bankName);
        } else {
            $bankName = 0;
        }

        $amount = 1000;

        $sql3 =  "INSERT INTO users (username,phoneno,email,password,accountno,accountname,bankname,amount ) VALUES ('$userName', '$phoneNo','$email', '$password','$accountNo', '$accountName','$bankName', '$amount')";



        if (mysqli_query($conn, $sql3)) {
            echo 1;
        } else {
            echo 2;
        }


        break;

    case "emailcheck":
        if (isset($_POST['email2'])) {
            $email2 = $_POST['email2'];
            $email2 = mysqli_real_escape_string($conn, $email2);
        } else {
            $email2 = 0;
        }




        $sql1 = "SELECT * FROM users WHERE email='$email2'";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            echo 1;
        } else {
            echo 0;
        };


        break;

    case "phonecheck":
        if (isset($_POST['phone'])) {
            $phoneNo2 = $_POST['phone'];
        } else {
            $phone = 0;
        }




        $sql2 = "SELECT * FROM users WHERE phoneno='$phoneNo2'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            echo 1;
        } else {
            echo 0;
        };


        break;

    case 'login':
        if (isset($_POST['loginemail'])) {
            $loginemail = $_POST['loginemail'];
            $loginemail = mysqli_real_escape_string($conn, $loginemail);
        } else {
            $loginemail = 0;
        }

        if (isset($_POST['loginpassword'])) {
            $loginpassword = $_POST['loginpassword'];
            $loginpassword = mysqli_real_escape_string($conn, $loginpassword);
            $loginpassword = md5($loginpassword);
        } else {
            $loginpassword = 0;
        }

        if (isset($_POST['clicked'])) {
            $clicked = $_POST['clicked'];
            $clicked = mysqli_real_escape_string($conn, $clicked);
        } else {
            $clicked = 0;
        }


        $sql4 = "SELECT * FROM users WHERE (email = '$loginemail' OR phoneno = '$loginemail') AND password = '$loginpassword'";
        $result4 = $conn->query($sql4);
        if ($result4->num_rows > 0) {
            $_SESSION['info'] = $loginemail;
            $_SESSION['clicked'] = $clicked;
            $_SESSION['logged'] = 1;
            echo 1;
        } else {

            echo 0;
        };






        break;
    case 'amountcheck':

        if (isset($_POST['email2'])) {
            $email2 = $_POST['email2'];
        } else {


            $email2 = $_POST['email2'];
        }



        $sql2 = "SELECT * FROM users WHERE email='$email2'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                echo $row['amount'];
            }
        } else {
            echo 0;
        };
        break;

    case 'amountchange':
        if (isset($_POST['email3'])) {
            $email3 = $_POST['email3'];
        } else {


            $email3 = 0;
        }



        $sql2 = "SELECT * FROM users WHERE email='$email3'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

                $amount = $row['amount'];
            }
        } else {
            echo 0;
        };

        $amount = $amount - 50;
        $sql = "UPDATE users SET amount = '$amount' WHERE email = '$email3'";
        $result = $conn->query($sql);
        if ($result) {
            echo $amount;
        } else {
            echo false;
        }
        break;

    case 'playernumber':
        if (isset($_POST['id'])) {

            $club = $_POST['id'];
            $player = [];
        }
        $sql1 = "SELECT * FROM players WHERE club_id=" . $club;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            // output data of each row
            while ($row1 = $result1->fetch_assoc()) {

                $player[] = $row1["number"];
                $_SESSION['club'] = $club;
            }

            

            for ($i = 0; $i < 100; $i++) {
                shuffle($player);
            }

            echo json_encode($player);
        } else {
            $empty = false;
        };
        break;


    case 'players':
        if (isset($_SESSION['club'])) {
            $id = $_SESSION['club'];
        } else {
            $id = 0;
        }
        $sql1 = "SELECT * FROM players WHERE club_id=" . $id;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            // output data of each row
            while ($row1 = $result1->fetch_assoc()) {

                $player[] = $row1;
            }

            for ($i = 0; $i < 100; $i++) {
                shuffle($player);
            }

            echo json_encode($player);
        } else {
            $empty = false;
        };
        break;
}
