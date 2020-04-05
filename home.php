<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newpredict";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo 0;
}

if (isset($_SESSION['logged'])) {
    $id = $_SESSION['logged'];
} else {
    $id = 0;
}

if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    $userArray = array();
    $sql = "SELECT * FROM users WHERE email = '$info' OR phoneno = '$info' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            $userArray[] = $row['password'];
            $userArray[] = $row['email'];
            $userArray[] = $row['phoneno'];
            $userArray[] = $row['username'];
            $userArray[] = $row['accountno'];
            $userArray[] = $row['accountname'];
            $userArray[] = $row['amount'];
            $userArray[] = $row['bankname'];
        }
    } else {
        $empty = false;
    };
} else {
    $info = 0;
}

if (isset($userArray[1])) {
    $idd = $userArray[1];
} else {
    $idd = "none";
}

$sql = "SELECT * FROM matches";
$result = $conn->query($sql);
$empty = true;
$matchesArray = [];
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        $matchesArray[] = $row;
    }
} else {
    $empty = false;
}







function getTeam($id, $conn)
{


    $sql = "SELECT * FROM club WHERE id=" . $id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            $name = $row['name'];
        }
    } else {
        $empty = false;
    };
    return $name;
}

function shortenName($name)
{

    switch ($name) {

        case 'Real Madrid':
            return "R.Madrid";
            break;

        case 'Inter Milan':
            return "Inter";
            break;

        case 'Bayern Munich':
            return "Bayern";
            break;

        case 'Schalke 04':
            return "Schalke";
            break;




        case 'RCD Mallorca':
            return "Mallorca";
            break;

        case 'Bayern Munich':
            return "Bayern";
            break;

        case 'Schalke 04':
            return "Schalke";
            break;

        case 'Crystal Palace':
            return "Crystal";
            break;

        case 'Manchester United':
            return "Manchester";
            break;

        case 'Manchester City':
            return "Manchester";
            break;

        case 'Atletico Madrid':
            return "Atletico";
            break;

        case '':
            return "Everton";
            break;

        case 'Everton':
            return "Everton";
            break;

        default:
            return $name;
            break;
    }
}



?>

<html>

<head>
    <meta charset="utf-8">
    <title>CashSelect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <script src="files/jquery.js"></script>
    <link rel="stylesheet" href="files/main.css">
    <link rel="stylesheet" href="files/main_2.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="files/responsive-2.css">
    <style>
        .money-aaa {}

        .money-bbb {}

        .money-ccc {}
    </style>
</head>

<body>
    <div class="inner" style="display: none" ;></div>
    <div class="modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Log In</div>
                    <div class="acc">Get back to your account</div>
                </div>
                <div class="part-b"><img id="imgLog" style="cursor: pointer;" src="images\img\Group 32.png" /></div>
            </div>
            <div class="input">
                <input type="text" class="loginemail" placeholder="Email Address or Phone No" />
                <input type="password" class="loginpassword" placeholder="Password" />
            </div>
            <div class="forgot">Forgot Password?</div>
            <button class="log-in">Log In</button>
            <div class="sign" id="sign-create" style="cursor: pointer;">New User ? <span>Create account</span></div>
        </div>

    </div>
    <div class="password-modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Change Password</div>
                    <div class="acc">We want to protect your account</div>
                </div>
                <div class="part-b"><img src="images\img\Group 32.png" /></div>
            </div>
            <div class="input">
                <input type="password" class="old" placeholder="Old Password" />
                <input type="password" class="new" placeholder="New Password" />
            </div>
            <button class="change">Change</button>
        </div>

    </div>
    <div class="deposit-modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Deposit Money</div>
                    <div class="acc">Money used for playing to win 100k</div>
                </div>
                <div class="part-b"><img src="images\img\Group 32.png" /></div>
            </div>
            <div id="amount">
                <input type="text" class="amount" placeholder="Enter amount" />
            </div>
            <button class="deposit">Deposit</button>
        </div>

    </div>

    <div class="withdraw-modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Withdraw Money</div>
                    <div class="acc">Collect your cash you won</div>
                </div>
                <div class="part-b"><img src="images\img\Group 32.png" /></div>
            </div>
            <div id="amount">
                <input type="text" class="amount" placeholder="Enter Amount" />
            </div>
            <button class="deposit">Withdraw</button>
        </div>

    </div>




    <div class="create1-modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Create Account</div>
                    <div class="acc-b">Step 1 - <span>Your Personal Information</span></div>
                </div>
                <div class="part-b"><img id="imgCr" src="images\img\Group 32.png" /></div>
            </div>
            <div class="create-input">
                <div>
                    <input type="text" class="user-name" placeholder="Username" />
                    <input type="text" class="emailCre" placeholder="Email Address" />

                </div>
                <div id="res-input">
                    <input type="text" class="phoneNo" placeholder="Phone Number" />

                    <input type="password" class="passwordCre" placeholder="Password" />

                </div>
            </div>
            <div></div>
            <div class="for" style="margin-top:-1rem;"><span style="color: #000;">Have an account?&nbsp;</span>Log In</div>
            <button id="createFirst" style="margin-top: 2rem; margin-bottom:2rem;">Next</button>
        </div>

    </div>
    <div class="create2-modal" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Create Account</div>
                    <div class="acc-b">Step 2 - <span>Your Bank Account Details</span></div>
                </div>
                <div class="part-b"><img id="imgCr" src="images\img\Group 32.png" /></div>
            </div>
            <div class="create-input1">
                <div>
                    <input type="text" id="input" class="account-name" placeholder="Account Name" />
                    <input type="text" id="input" class="account-no" placeholder="Account Number" />

                </div>
                <div>
                    <select class="bankName">
                        <option disabled selected value="">Select your bank</option>
                        <option value="Access Bank Plc">Access Bank Plc </option>
                        <option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
                        <option value="Fidelity Bank Plc">Fidelity Bank Plc </option>
                        <option value="FIRST BANK NIGERIA LIMITED">FIRST BANK NIGERIA LIMITED</option>
                        <option value="First City Monument Bank Plc">First City Monument Bank Plc </option>
                        <option value="Globus Bank Limited">Globus Bank Limited </option>
                        <option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc </option>
                        <option value="Citibank Nigeria Limited">Citibank Nigeria Limited </option>
                        <option value="Heritage Banking Company Ltd">Heritage Banking Company Ltd</option>
                        <option value="Key Stone Bank">Key Stone Bank </option>
                        <option value="Polaris Bank">Polaris Bank </option>
                        <option value="Providus Bank">Providus Bank </option>
                        <option value="Stanbic IBTC Bank Ltd">Stanbic IBTC Bank Ltd</option>
                        <option value="Standard Chartered Bank Nigeria Ltd">Standard Chartered Bank Nigeria Ltd</option>
                        <option value="Sterling Bank Plc">Sterling Bank Plc</option>
                        <option value="SunTrust Bank Nigeria Limited">SunTrust Bank Nigeria Limited</option>
                        <option value="Titan Trust Bank Ltd">Titan Trust Bank Ltd</option>
                        <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
                        <option value="United Bank For Africa Plc">United Bank For Africa Plc</option>
                        <option value="Unity Bank Plc">Unity Bank Plc</option>
                        <option value="Wema Bank Plc">Wema Bank Plc</option>
                        <option value="Zenith Bank Plc">Zenith Bank Plc</option>

                    </select>
                </div>
            </div>
            <div class="for" style="margin-top:-1rem; font-size:1rem;"><span style="color: #000;">Have an account?&nbsp;</span>Log In</div>

            <div class="button-button"><button id="prev" style="margin-top: 1.4rem;">Previous</button><button id="compCre" style="margin-top: 1.4rem;">Create Account</button></div>

        </div>

    </div>
    <div class="edit-profile" style="display: none;">
        <div class="iv">
            <div class="modal-head">
                <div class="part-a">
                    <div class="log">Edit Profile</div>
                    <div class="acc">Change your profile details</div>
                </div>
                <div class="part-b"><img src="images\img\Group 32.png" /></div>
            </div>
            <div class="edit-head">
                <div>Personal Information</div>
                <div style="background: black;color:white;">Bank Account</div>>
            </div>

            <div class="create-input1">
                <div>
                    <input type="text" id="input" class="account-name" placeholder="Account Name" />
                    <input type="text" id="input" class="account-no" placeholder="Account Number" />

                </div>
                <div>
                    <select id="select">
                        <option selected value="">Select your bank</option>
                        <option value="Access Bank Plc">Access Bank Plc </option>
                        <option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
                        <option value="Fidelity Bank Plc">Fidelity Bank Plc </option>
                        <option value="FIRST BANK NIGERIA LIMITED">FIRST BANK NIGERIA LIMITED</option>
                        <option value="First City Monument Bank Plc">First City Monument Bank Plc </option>
                        <option value="Globus Bank Limited">Globus Bank Limited </option>
                        <option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc </option>
                        <option value="Citibank Nigeria Limited">Citibank Nigeria Limited </option>
                        <option value="Heritage Banking Company Ltd">Heritage Banking Company Ltd</option>
                        <option value="Key Stone Bank">Key Stone Bank </option>
                        <option value="Polaris Bank">Polaris Bank </option>
                        <option value="Providus Bank">Providus Bank </option>
                        <option value="Stanbic IBTC Bank Ltd">Stanbic IBTC Bank Ltd</option>
                        <option value="Standard Chartered Bank Nigeria Ltd">Standard Chartered Bank Nigeria Ltd</option>
                        <option value="Sterling Bank Plc">Sterling Bank Plc</option>
                        <option value="SunTrust Bank Nigeria Limited">SunTrust Bank Nigeria Limited</option>
                        <option value="Titan Trust Bank Ltd">Titan Trust Bank Ltd</option>
                        <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
                        <option value="United Bank For Africa Plc">United Bank For Africa Plc</option>
                        <option value="Unity Bank Plc">Unity Bank Plc</option>
                        <option value="Wema Bank Plc">Wema Bank Plc</option>
                        <option value="Zenith Bank Plc">Zenith Bank Plc</option>

                    </select>
                </div>
            </div>

            <div class="create-input1" style="display: none;">
                <div>
                    <input type="text" id="input" class="account-name" placeholder="First Name" />
                    <input type="text" id="input" class="account-no" placeholder="Last Name" />

                </div>
                <div>
                    <input type="email" class="select" placeholder="Email Address" />
                </div>
            </div>
            <div class="button-button"><button style="background: #fff;color:#439539; border:2px #439539 solid;margin-top: 1.2rem;">Change Password</button><button style="margin-top: 1.2rem;">Save Details</button></div>


        </div>

    </div>
    <div class="nav-account" style="display: none" ;>
        <div class="close-nav"><img src="images\img\Group 32.png" /></div>
        <button id="nav-log">Log In</button>
        <button id="nav-create" style="margin-top: 1rem;">Create Account</button>
        <div>Home</div>
        <div>About Us</div>
        <div>T & C</div>
        <div>My Predictions</div>
        <div>Legal Terms</div>
    </div>
    <div class="nav-account2" style="display: none;">
        <div class="close-nav"><img src="images\img\Group 32.png" /></div>
        <div style="font-weight: bold; margin-top:1.3rem;"><?php echo $userArray[3]; ?></div>
        <div style="margin-top: 0.2rem; font-size:1.5rem; font-weight:bold; display:flex; flex-direction:row; color:#439539; align-items:center;">Balance -&nbsp; <img src="images\img\naira (2).png" style="width:1.5rem; height:1.5rem;" /><?php echo $userArray[6]; ?></div>

        <button>Edit Profile</button>
        <button id="deposit-btn" style="margin-top: 1rem;">Deposit Money</button>
        <button id="withdraw-btn" style="margin-top: 1rem;">Withdraw Money</button>
        <div>Home</div>
        <div>About Us</div>
        <div>T & C</div>
        <div>My Predictions</div>
        <div>Legal Terms</div>
    </div>

    <div class="my-predictions" style="display:none;">
        <div class="pred-head">
            <div style="margin-left: 2rem;">Your Predictions</div><img style="margin-right: 2rem;" src="images\img\Group 32.png" />
        </div>
        <div class="search"><img src="images\img\search.png" />&nbsp;&nbsp;<input type="text" placeholder="Search prediction by key" /></div>
        <div class="predict-container">
            <div class="each-predict">
                <div class="predict-date">Today</div>
                <div class="predict">
                    <div class="predkey">AR67WWTWY</div>
                    <div class="predict-b">
                        <img src="images\team\en-3.png" />
                        &nbsp;
                        <div class="team">
                            <div class="team-name">Chelsea FC</div>
                            <div class="t">See Prediction</div>
                        </div>
                    </div>
                    <div class="predict-c">
                        <div class="win">Winnings - <span>£30,000,000</span></div>

                        <div class="tim"><img src="images\img\calendar-60.png" />&nbsp; 18:00 | 26th Sept, 2019</div>
                    </div>
                    <div class="predict-d"><button>Won</button></div>
                </div>
            </div>
            <div class="each-predict">
                <div class="predict-date">26 Sept 2019</div>
                <div class="predict">
                    <div class="predkey">AR67WWTWY</div>
                    <div class="predict-b">
                        <img src="images\team\en-3.png" />
                        &nbsp;
                        <div class="team">
                            <div class="team-name">Chelsea FC</div>
                            <div class="t">See Prediction</div>
                        </div>
                    </div>
                    <div class="predict-c">
                        <div class="win">Winnings - <span>£30,000,000</span></div>

                        <div class="tim"><img src="images\img\calendar-60.png" />&nbsp; 18:00 | 26th Sept, 2019</div>
                    </div>
                    <div class="predict-d"><button style="background: red;">Lost</button></div>
                </div>
            </div>
        </div>
    </div>


    <div class="save" style="display:none;">
        <div class="save-close"><img src="images\img\Group 32.png" /></div>
        <div class="save-success">Your prediction was successful</div>
        <img src="images\img\Group 25.png" class="confirm" />
        <div class="pkey">Predict Key : <span>3ERYNT</span></div>
        <div class="phead">
            <div style="margin-left:1rem;">Team</div>
            <div style="margin-right:1rem;">Odds</div>
        </div>
        <div class="ppred">
            <div style="margin-left:1rem;">Chelsea</div>
            <div style="margin-right:1rem;">500</div>
        </div>
        <div class="winn">
            <div style="margin-left:1rem;">Winnings</div>
            <div style="margin-right:1rem;font-size:2rem;">$5000</div>
        </div>
    </div>

    <div class="predict-now" style="display: none;">
        <div class="hea">Prediction Slip</div>
        <div class="each-p">
            <div style="margin-left: 1.5rem">
                <div>Chelsea</div>
                <div style=" font-family: 'Google Sans', Tahoma, Geneva, Verdana, sans-serif;
    font-weight:bold;
    font-size:0.8rem; color:#ccc;">26th Sept, 2014</div>
            </div><img style="margin-right: 1.5rem" src="images\img\Group 32.png" />
        </div>
        <div class="odds">
            <div style="margin-right: 2rem;">500 odds</div>
        </div>
        <button type="submit" class="see-btn">See Prediction</button>

        <input type="text" class="amt" placeholder="Type amount here" />

        <div class="amont"><button>$100</button><button>$200</button><button>$500</button><button>$1000</button></div>

        <div class="winni">
            <div class="" style="margin-left: 2rem;">Winnings</div>
            <div class="" style="margin-right: 2rem;">$300,000</div>
        </div>
        <button type="submit" class="amt-btn">Submit Prediction</button>

    </div>


    <div class="prediction-preview">
        <div class="h">
            <div class="preh">
                <div class="preh-a"><img src="images\team\en-3.png" /></div>
                <div class="preh-b">Chelsea</div>
            </div><img src="images\img\Group 32.png" />
        </div>

        <div class="formation">
            <div class="form-a">Formation</div>
            <div class="form-b">4-2-3-1</div>
        </div>
        <div class="lineup">
            <div class="lineup-a">Lineups</div>
            <div class="lineup-b">Henry , Arthur , Messi , Paul , Sambo , Peter , Will , Henry , Arthur , Messi , Paul , Sambo , Peter , Will</div>
        </div>
        <div class="subs">
            <div class="subs-a">Substitution</div>
            <div class="subs-b">
                <div>
                    <div><img src="images\img\ic_arrow_forward_36px.png" />
                        <div class="sub-name">Messi</div>
                    </div>

                    <div><img src="images\img\back.png" />
                        <div class="sub-name">Henryhhhhhhh</div>
                    </div>
                </div>
                <div>
                    <div><img src="images\img\ic_arrow_forward_36px.png" />
                        <div class="sub-name">Sambo</div>
                    </div>

                    <div><img src="images\img\back.png" />
                        <div class="sub-name">Paul</div>
                    </div>
                </div>
                <div>
                    <div><img src="images\img\ic_arrow_forward_36px.png" />
                        <div class="sub-name">Smith</div>
                    </div>

                    <div><img src="images\img\back.png" />
                        <div class="sub-name">Willkkkkkkkkk</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="prediict" style="display:none">
        <div class="h">
            <div class="preh">
                <div class="preh-a"><img src="images\team\en-3.png" /></div>
                <div class="preh-c">
                    <div style="font-weight: 400;">Chelsea</div>
                    <div>Odds : 300</div>
                </div>
            </div><img src="images\img\Group 32.png" />
        </div>
        <div class="select-contain">
            <select class="form-select">
                <option selected="true" disabled>Choose your formation</option>
                <option>4-5-4</option>
                <option>5-4-1</option>
                <option>4-6-2</option>
            </select>
        </div>
        <div class="select-contain">

            <div class="se-line">Select your lineup vs Crystal Palace</div>
            <div class="se-pl">Selected Players - Messi,Ronaldo,Pique,Van</div>
            <button class="add">Add 11 players</button>
            <button class="cancel">Cancel lineup</button>
        </div>
    </div>



    <div class="instruct" style="display: none;">
        <div class="instruct-text">Instructions</div>
        <div class="instruction">You are to quickly select the team's lineup provided in 40 seconds to win the cash prize.</div>
        <button style="cursor: pointer;" id="start">Start Now</button>
        <button id="balk" style="cursor: pointer;background: red; margin-top:1rem; margin-bottom:4rem;">Back</button>
    </div>

    <div class="game">
        <div class="game-time">
            <div class="div">Time Remaining : </div> &nbsp; <div id="timeRemain" class="span">00:30</div>
        </div>
        <div class="game-numbers">
            <div class="pper">Players to be selected below are in black </div>
            <div class="numbers">

            </div>
            <div class="pper">Click on their names below with their numbers above</div>
        </div>
        <div class="game-players">




        </div>
    </div>

    <div class="deposit-option" style="display: none;">
        <div class="opt">Deposit Option</div>
        <div class="deposit-pay">Pay&nbsp;<img src="images\img\naira (2).png" /><span>150 naira</span>&nbsp;with </div>
        <div class="pay-option">
            <div>Credit Card</div>
            <div>Airtime</div>
        </div>

    </div>

    <div class="congrats" style="display: none;">
        <img src="images\img\Group 25.png" />
        <div class="con-cash">Congratulations</div>
        <div class="con-detail" id="con-detail">on winning 100k now</div>
        <button id ="take-cash" style="margin-top: 2rem;">Take Cash</button>
        <button style="cursor:pointer;" class="try-again">Go Home</button>
    </div>

    <div class="failed" style="display: none;">
        <img src="images\img\Group 32.png" />
        <div class="con-cash">Time Up</div>
        <div class="con-detail">You did not complete selection in 40 seconds</div>
        <button style="cursor:pointer;" class="try-again" style="margin-top: 2rem;">Try Again</button>
    </div>

    <div class="container">

        <div class="head">
            <div class="a"></div>
            <div class="b"><img src="images/img/facebook.png" /><img src="images/img/twitter.png" />
                <div class="predict-tuts"><img src="images/img/ic_play_circle_outline_48px.png" />
                    <div>How to win</div>
                </div>
            </div>
        </div>
        <div class="header">
            <div class="aa">
                <div class="text"><span class="span">Cash</span>Select</div>
            </div>

            '<div class="bp">
                <div class="nav">Menu<img src="images\img\ic_menu_48px.png" /></div>
                <div class="button-container"><button type="submit" id="logIn">Log In</button><button type="submit" id="accCreate">Create Account</button></div>

            </div>';
            <div class="bs">
                <div class="nav">Menu<img src="images\img\ic_menu_48px.png" /></div>

                <div class="prof-d">
                    <div class="bs-a">Username : <?php echo $userArray[3]; ?></div>
                    <div class="bs-b" style="margin-bottom: 0.5rem;">Avaliable balance : &nbsp;<img src="images\img\naira.png" style="width:0.8rem; height:0.8rem;" /><span style="font-weight: bold;"><?php echo $userArray[6]; ?></span></div>
                    <div class="bs-c"><button>Edit Profile</button><button>Deposit Money</button></div>
                </div>
            </div>
        </div>
        <div class="n-guard">
            <div class="n">
                <div class="item">
                    <div class="a1">Home</div>
                    <div class="b2"></div>
                </div>
                <div class="item">
                    <div class="a1">About Us</div>

                </div>
                <div class="item">
                    <div class="a1">T&C</div>

                </div>
                <div class="item">
                    <div class="a1">Legal Terms</div>

                </div>
                <div class="item">
                    <div class="a1">My Predictions</div>

                </div>
            </div>
        </div>

        <div class="body">
            <div class="a">
                <div class="league-container">
                    <div class="head">
                        <div class="lea">League Involved</div> <img class="ima" src="images\img\otherArrow.png" />
                    </div>
                    <div class="diva"><img class="im" src="images/img/soccer.png" /> Premier League</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> La Liga</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> Ligue 1</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> Bundesliga</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> Serie A</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> UCL</div>
                    <div class="diva"><img class="im" src="images\img\soccer-ball (2).png" /> UEL</div>
                </div>
            </div>
            <div class="b">
                <div class="market-image">
                    <div></div>
                    <div style="background: #439539;"></div>
                    <div></div>
                </div>
                <div class="odds-center">
                    <div class="prediction-container">
                        <?php

                        shuffle($matchesArray);
                        foreach ($matchesArray as $m) {

                            $price =  rand(50,100);
                            if(isset($_SESSION['price'])){
                            $_SESSION['price'] = $price;
                            }
                            if (isset($m['league']) && isset($m['secondId']) && isset($m['firstId'])) {

                                $fimg = "images/team/" . $m['league'] . "-" . $m['firstId'] . ".png";
                               
                                $simg = "images/team/" . $m['league'] . "-" . $m['secondId'] . ".png";

                                $firstclub = getTeam($m['firstId'], $conn);
                               // $firstclub = substr($firstclub, 0, 10);
                                  $firstclub = shortenName($firstclub);
                                $secondclub = getTeam($m['secondId'], $conn);
                               // $secondclub = substr($secondclub, 0, 10);
                               $secondclub = shortenName($secondclub);
                                echo ' <div class="prediction-item">
                           <div class="all">
                               <div>Today</div>
                           </div>
                           <div class="b">
                               <div class="first" id="' . $m['firstId'] . '" style="">
                                   <div style="margin-left:0.5rem;">' . $firstclub . '</div><img style="margin-left: 0.5rem;" src="' . $fimg . '" />
                               </div>
                               <div class="vs">VS</div>
                               <div class="second" id="' . $m['secondId'] . '"><img src="' . $simg . '" />
                                   <div style="margin-left: 0.5rem;margin-right:0.5rem;">' . $secondclub . '</div>
                               </div>
                           </div>
                           <div class="ca">
                               <div class="amtt-btn" id="' . $m['firstId'] . '"><img src="images\img\naira.png" style="width:1.5rem; height:1.5rem;" />'.$price.'K</div>
                               <div class="amtt-btn" id="' . $m['secondId'] . '"><img src="images\img\naira.png" style="width:1.5rem; height:1.5rem;" />'.$price.'K</div>
                           </div>
                       </div>';
                            } else {
                                echo "<div>Empty</div>";
                            }
                        }

                        ?>

                    </div>
                </div>
            </div>
            <div class="c"></div>
        </div>

        <div class="sponspor">
            <div id="text" style="margin-top: 4rem; font-weight:bold;">Sponspors</div>
            <div class="sponsp-contain" style="margin-top: 2rem; margin-bottom:6rem;">
                <div><img src="images\img\ncc_logo.f4fca015.png" /> </div>
                <div id="img-s"><img src="images\img\lslb_logo.c02e88db.png" /></div>
                <div id="img-s"><img src="images\img\nlrc_logo.9e753263.png" /></div>
            </div>
        </div>
        <div class="contact">
            <div class="c">
                <div>
                    <div id="con">Contact Us</div>
                    <textarea placeholder="Write a message or complaint"></textarea>
                    <button>Send Message</button>
                </div>
            </div>
            <div class="d">
                <div class="con">Home</div>
                <div>About Us</div>
                <div>Terms & Conditions</div>
                <div>Privacy Policy</div>
                <div>How to win</div>
            </div>
        </div>

        <div class="footer">
            <div class="awe">
                <div><img src="images\img\email-84.png" />&nbsp; support@newpredict.com</div>
                <div><img src="images\img\phone-2.png" />&nbsp; 09026734567</div>
            </div>
            <div class="bwe">
                <div>NewPredict is registered and licensed by Federal Republic Of Nigeria under license of BN 234-65-78</div>
            </div>
            <div class="cwe">Copyright 2020 NewPredict All Right Reserved</div>
        </div>
    </div>


</body>

<script type="text/javascript">
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }







    function check(play) {


        for (var i = 0; i < 11; i++) {
            if (play == playerNumberArray[i]) {
                return true;
            }
        }
        return false;
    }

    function getplayer() {
        var playerhtml = "";
        for (var j = 0; j < players.length; j++) {
            playerhtml += '<div clicked="true"  id="' + players[j].number + '" class="diver"><div id="a"><div id="b">' + players[j].number + '</div></div><div id="c">' + players[j].fullName + '</div></div></div>';
        }
        $(".game-players").html(playerhtml);

    }

    var clicked;
    var id = <?php echo $id ?>;
    var userName;
    var counted = 0;
    var phoneNo;
    var email;
    var password;
    var bankName;
    var players;
    var playerNumberArray;
    var accountNumber;
    var accountName;
    var activated = false;
    var loginemail;
    var loginpassword;
    var t;
    if (id) {

        $('.bp').css({
            'display': 'none'
        });











    } else {
        $('.bs').css({
            'display': 'none'
        });

    }
    activated = true;
    $(".bankName").change(function() {
        bankName = $(this).children("option:selected").val();
    });

    $(".amtt-btn").click(function() {
        var aid = $(this).attr("id");



        var DATA = "id=" + aid + "&cat=playernumber";
        $.ajax({
            type: "POST",
            url: "allrequests.php",
            data: DATA,
            dataType: 'json',
            success: function(res) {
                playerNumberArray = res;
            }
        });

        $('.instruct').slideDown();
        $('.inner').css({
            'display': 'block'
        });


        var DATA = "cat=players";
        $.ajax({
            type: "POST",
            url: "allrequests.php",
            data: DATA,
            dataType: 'json',
            success: function(res) {

                players = res;
                getplayer();
            }
        });
    });

   var price = <?php echo $price?>;
    $(document).on('click', '.diver', function() {

        $("#con-detail").text("on winning "+price+"k now")
        var id = $(this).attr("id");
        clicked = $(this).attr("clicked");
        if (clicked == "true") {
            $(this).attr("clicked", "false");


            if (check(id)) {

                counted++;

                if (counted == 11) {
                    $(".congrats").slideDown();
                    $(".game").slideUp();

                        clearInterval(t);
                }
                $("#" + id).remove();
                $('#player-' + id).css({
                    'display': 'none'
                });

                alert("Correct");


            } else {
                alert("Click on players that their numbers are in the black box");
            }
        } else {

        }
     

    });

    $(".numbers div").click(function(){
            alert("emma");
        });

        $(document).on('click', '.numbers div', function() {
            alert("Click on their names below that their numbers are here ");

        });


    $(document).ready(function() {
        $("#take-cash").click(function(){
         //$(".withdraw-modal").slideDown();
         //$(".nav-account2").slideUp();
         alert("Not for testing yet");
     });
     $("#withdraw-btn").click(function(){
         //$(".withdraw-modal").slideDown();
         //$(".nav-account2").slideUp();
         alert("Not for testing yet");
     });
 $("#deposit-btn").click(function(){
   // $(".withdraw-modal").slideDown();
       //  $(".nav-account2").slideUp();
       alert("Not for testing yet");
     });

        $("#nav-log").click(function(){
            $(".nav-account").slideUp();
            $(".modal").slideDown();
        });
        $("#nav-create").click(function(){
            $(".nav-account").slideUp();
            $(".create1-modal").slideDown();
        });

        $(".try-again").click(function() {
         //   $(".failed").slideUp();
          //  $(".instruct").slideDown();
            window.location.replace("home.php");
        });











        $("#start").click(function() {
            activated = false;
            if (id) {



                var DATA = 'email2=' + '<?php echo $idd ?>' + '&cat=amountcheck';

                $.ajax({
                    type: "POST",
                    url: "allrequests.php",
                    data: DATA,
                    success: function(result) {


                        if (result >= 50) {

                            var DATA = 'email3=' + '<?php echo $idd ?>' + '&cat=amountchange';

                            $.ajax({
                                type: "POST",
                                url: "allrequests.php",
                                data: DATA,
                                success: function(res) {
                                    if (res) {
                                        var playercombination = "";
                                        for (var i = 0; i < 11; i++) {
                                            playercombination += "<div id=player-" + playerNumberArray[i] + ">" + playerNumberArray[i] + "</div>";

                                        }
                                        $(".numbers").html(playercombination);
                                          var random_time = [40,30];
                                          random_time.sort(() => Math.random() - 0.5);
                                        var time = random_time[0];

                                        t = setInterval(function() {

                                            time = time - 1;
                                            if (time == 0) {
                                                if (counted == 11) {
                                                    $(".congrats").slideDown();
                                                    $(".game").slideUp();
                                                } else {
                                                    $(".failed").slideDown();
                                                    $(".game").slideUp();
                                                }
                                            }
                                            t = time;
                                            if (t < 10) {
                                                t = "0" + t;
                                            } else {

                                            }
                                            $(".game-time .span").text("00:" + t)
                                            if (time == 0) {

                                            }
                                        }, 1000);

                                        $(".instruct").slideUp();
                                        $(".game").slideDown();


                                    }
                                }
                            });

                        } else {
                            alert("Your account is low. Please deposit in your account. Session cost 50 naira ");


                        }

                    }
                });


            } else {
                $(".modal").slideDown();
                $(".instruct").slideUp();
                $('.inner').css({
                    'display': 'block'
                });
            }
        });



        $("#balk").click(function() {
            $('.instruct').slideUp();
            $('.inner').css({
                'display': 'none'
            });
        });







        $(".close-nav").click(function() {
            $('.nav-account').css({
                'display': 'none'
            })
            $('.nav-account2').css({
                'display': 'none'
            })
            $('.inner').css({
                'display': 'none'
            })
        });

        $(".nav").click(function() {
            if (id) {
                $('.nav-account2').css({
                    'display': 'flex'
                })
                $('.inner').css({
                    'display': 'block'
                })
            } else {
                $('.inner').css({
                    'display': 'block'
                })
                $('.nav-account').css({
                    'display': 'flex'
                })
            }
        });




        $("#sign-create").click(function() {
            $('.create1-modal').slideDown();
            $('.modal').slideUp();
        });

        $(".for").click(function() {
            $('.create1-modal').slideUp();
            $('.create2-modal').slideUp();
            $('.modal').slideDown();
        });





        $(".log-in").click(function() {
            loginemail = $(".loginemail").val();
            loginpassword = $(".loginpassword").val();
            if (loginemail < 0 && loginpassword < 0) {
                alert("Fields cannot be empty");
            }

            var DATA = 'loginemail=' + loginemail + '&loginpassword=' + loginpassword + '&cat=login';

            $.ajax({
                type: "POST",
                url: "allrequests.php",
                data: DATA,
                success: function(result) {


                    if (result == 1) {

                        window.location.replace("home.php");
                    } else {
                        alert("Incorrect username or password");

                    }



                }
            });













        });

        $("#compCre").click(function() {
            accountNumber = $(".account-no").val();
            accountName = $(".account-name").val();
            if (isNaN(accountNumber)) {
                alert("Account number must be a number");
            } else {

                if (!((accountNumber.length >= 10) && (accountNumber.length <= 12))) {
                    alert("Invalid account number");
                } else {
                    if (accountName.length < 0) {
                        alert("Account name must not be empty");
                    } else {
                        if (bankName == undefined) {
                            alert("Please select your bank");
                        } else {
                            var DATA = 'userName=' + userName + '&password=' + password + '&email=' + email + '&phoneNo=' + phoneNo + '&accountNo=' + accountNumber + '&accountName=' + accountName + '&bankName=' + bankName + '&cat=signup';
                            $.ajax({
                                type: "POST",
                                url: "allrequests.php",
                                data: DATA,
                                success: function(result) {

                                    if (result == 1) {

                                        alert("Your account has been created");
                                        $('.modal').slideDown();
                                        $('.create2-modal').slideUp();
 $("input").val('');
                                    } else {

                                    }
                                }
                            });







                        }
                    }
                }

            }

        });

        $("#createFirst").click(function() {
            userName = $(".user-name").val();
            phoneNo = $(".phoneNo").val();
            email = $(".emailCre").val();
            password = $(".passwordCre").val();


            if (userName.length < 2) {

                alert("Username should not be less than two characters")

            } else {


                if (isNaN(phoneNo)) {
                    alert("Phone Number is not valid");
                } else {

                    if (phoneNo.length != 11) {
                        alert("Phone Number should  be 11 characters")

                    } else {
                        if (password.length < 6) {
                            alert("Password should be 6 or more characters");
                        } else {

                            if (email.length == 0) {

                                alert("Email can not be empty");
                            } else {
                                if (validateEmail(email)) {



                                    var DATA = 'email2=' + email + '&cat=emailcheck';
                                    $.ajax({
                                        type: "POST",
                                        url: "allrequests.php",
                                        data: DATA,
                                        success: function(result) {


                                            if (result == 1) {
                                                alert("Email address has been used before");
                                            } else {


                                                var DATA = 'phone=' + phoneNo + '&cat=phonecheck';
                                                $.ajax({
                                                    type: "POST",
                                                    url: "allrequests.php",
                                                    data: DATA,
                                                    success: function(result) {


                                                        if (result == 1) {
                                                            alert("Phone Number has been used before");
                                                        } else {


                                                            $('.create1-modal').slideUp();
                                                            $('.create2-modal').slideDown();



                                                        }



                                                    }
                                                });

                                            }



                                        }
                                    });



                                } else {
                                    alert("Invalid Email");
                                }

                            }



                        }



                    }
                }
            }


        });

        $("#prev").click(function() {
            $('.create2-modal').slideUp();
            $('.create1-modal').slideDown();
        });









        $("#logIn").click(function() {
            $('.modal').slideDown();
            $('.modal').css({
                'display': 'flex'
            });
            $('.inner').css({
                'display': 'block'
            });
        });
        $("#accCreate").click(function() {
            $('.create1-modal').slideDown();
            $('.create1-modal').css({
                'display': 'flex'
            });
            $('.inner').css({
                'display': 'block'
            });

        });
        $("#imgLog").click(function() {
            $('.modal').slideUp();
            $("input").val('');
            if (activated) {
                setTimeout(function() {
                    $('.inner').css({
                        'display': 'none'
                    })
                }, 500);
            } else {
                $(".instruct").slideDown();
            }
        });


        $("#imgCr").click(function() {
            $("input").val('');
            $('.create1-modal').slideUp();
            $('.create2-modal').slideUp();
            if (activated) {
                setTimeout(function() {
                    $('.inner').css({
                        'display': 'none'
                    })
                }, 500);
            }
        });

    });
</script>

</html>