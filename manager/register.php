<?php

//Initilizes the Vatiables
$dataIsGood = false;


$userName = "";
$email = "";
$accomplishments = "";

// Sanatizes data
function getData($field) {
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}

//function to check for text and numbers
function verifyAlphaNum($testString) {
    return (preg_match("/^([[:alnum:]]|-|\.|\s|\/|\'|&|;|#)+$/", $testString));
}

include "top.php"
?>
<main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $dataIsGood = true;

            // Sanatation
            $userName = getData("txtUserName");
            $email = getData("txtEmail");
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $accomplishments = getData("radAccomplish");

            // Validation
            if ($userName == "") {
                print '<p class="mistake">Your name is blank</p>';
                $dataIsGood = false;
            } elseif (!verifyAlphaNum($userName)) {
                print '<p class="mistake">Your name seems to have an invalid character.</p>';
                $dataIsGood = false;
            }
            if ($email == "") {
                print '<p class="mistake">Your email is blank</p>';
                $dataIsGood = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                print '<p class="mistake">Your email address seems to be invalid.</p>';
                $dataIsGood = false;
            }

            if ($accomplishments != "top500SD" AND $accomplishments != "top10kSV" AND $accomplishments != "Both" AND $accomplishments != "Neither") {
                print '<p class="mistake">Please indicate if you\'ve accomplished any of the following</p>';
                $dataIsGood = false;
            }

            if ($dataIsGood) {
                $sql = "INSERT INTO `tblTeamCreator` (`pmkCreatorId`, `fldName`, `fldEmail`, `fldAccomplishments`) VALUES (?, ?, ?, ?) ";
                $statement = $pdo->prepare($sql);
                $params = array(NULL, $userName, $email, $accomplishments);
                if ($statement->execute($params)) {
                    print '<!-- Record was successfully saved. -->';
                } else {
                    print '<!-- Record was NOT successfully saved. -->';
                    
                }
            }
            if ($dataIsGood) {
                print '<h2>Your data has been harvested, Thank you.</h2>';
                $to = $email;
                $from = 'CS 148 Pokemon Team Manager <Evan.Satterfield@uvm.edu>';
                $subject = 'Team Manager Form';
                            
                $mailMessage = '<p style="font: 16pt arial;">Thanks for registering your name to the Pokemon Team Manager!';
                $mailMessage .=' You\'ll now be able search for your own teams on the main page</p><br>';
                $mailMessage .='<span style="color: dark-grey; padding-right: auto; padding-left: auto;">';
                $mailMessage .='-Team Manager Team</span></p>';
                            
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "From: " . $from . "\r\n";
                            
                $mailSent = mail($to, $subject, $mailMessage, $headers);
                            
                if($mailSent){
                	print "<p>A confirmation email has been sent.</p>";
                }
            }
        }
        ?>

        <h2>Register a user</h2>
        <section>
        	<h3>Register your accomplishments to show up on the main page</h3>
            
            <form action="#"
                  method="POST">
                <fieldset class = "name">
                    <legend>Information</legend>
                    <p>
                        <label class ="required" for ="txtUserName">User Name</label>
                        <input id ="txtUserName"
                               maxlength="32"
                               name ="txtUserName"
                               type ="text"
                               value="<?php print $userName; ?>"
                               required>
                    </p>

                    <p>
                        <label class ="required" for ="txtEmail">Email</label>
                        <input id ="txtEmail"
                               maxlength="50"
                               name ="txtEmail"
                               type ="text"
                               value="<?php print $email; ?>"
                               required>
                    </p>
                </fieldset>

                <fieldset class ="radio">
                    <legend>Do you meet any of the following?</legend>
                    <p>
                        <input type="radio"
                               id ="rad1"
                               name ="radAccomplish"
                               <?php if ($accomplishments == "top500SD") print 'checked'; ?>
                               value="top500SD"
                               required>
                        <label class ="radio-field" for ="rad1">Ranked top 500 on any ladder on the website Pokemon Showdown?</label>
                        
                    </p>
                    <p>
                        <input type="radio"
                               id ="rad2"
                               name ="radAccomplish"
                               <?php if ($accomplishments == "top10kSV") print 'checked'; ?>
                               value="top10kSV"
                               required>
                        <label class ="radio-field" for ="rad2">Ranked top 10,000 on the ofical ranked mode in the actual game?</label>
                        
                    </p>
                    <p>
                        <input type="radio"
                               id ="rad3"
                               name ="radAccomplish"
                               <?php if ($accomplishments == "Both") print 'checked'; ?>
                               value="Both"
                               required>
                        <label class ="radio-field" for ="rad3">Both</label>
                        
                    </p>
                    
                    <p>
                        <input type="radio"
                               id ="rad4"
                               name ="radAccomplish"
                               <?php if ($accomplishments == "Neither") print 'checked'; ?>
                               value="Neither"
                               required>
                        <label class ="radio-field" for ="rad4">Neither</label>
                    </p>
                </fieldset>



                <fieldset class="buttons">
                    <input id = "btnSubmit" 
                           name = "btnSubmit" 
                           type = "submit" 
                           value = "Submit">
                </fieldset>
            </form>
        </section>
  
</main>
<?php
    include "footer.php"
?>
