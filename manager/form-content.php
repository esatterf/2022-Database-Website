<?php

//Initilizes the Vatiables
$dataIsGood = false;

// User and team info
$userName = '';
$teamName = '';
$teamFormat = '';
$memberCount = 6;
$members = array();
for ($i = 0; $i < $memberCount; $i++){
	$members[] = new Member();
}
	


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

// Member Class to keep track of the 6 team members and submit them
class Member {
    private $species;
    private $item;
    private $ability;
    private $nature;
    private $iv;
    private $ev;
    private $move;
    private $level;
    private $teamID;
    
    public function __construct(){
    	$this->species = '';
		$this->item = 'No Item';
		$this->ability = '';
		$this->nature = 'Serious';
		$this->iv = '31/31/31/31/31/31';
		$this->ev = '0/0/0/0/0/0';
		$this->move = '';
		$this->level = 100;
		$this->teamID = 0;
    }
    
    public function addInfo($species, $item, $ability, $level, $ev, $nature, $iv, $move, $teamID){
        $this->species = $species;
        $this->item = $item;
        $this->ability = $ability;
        $this->level = $level;
        $this->ev = $ev;
        $this->nature = $nature;
        $this->iv = $iv;
        $this->move = $move;
        $this->teamID = $teamID;
        
    }
    
    // Getters
    
    public function getSpecies(){
        return $this->species;
    }
    
    public function getItem(){
        return $this->item;
    }
    
    public function getAbility(){
        return $this->ability;
    }
    
    public function getLevel(){
        return $this->level;
    }
    
    public function getEVs(){
        return $this->ev;
    }
    
    public function getNature(){
        return $this->nature;
    }
    
    public function getIVs(){
        return $this->iv;
    }
    
    public function getMoves(){
        return $this->move;
    }
    
    public function getTeamID(){
        return $this->teamID;
    }
    
    // Setters
    
    public function setSpecies($new){
        $this->species = $new;
    }
    
    public function setItem($new){
        $this->item = $new;
    }
    
    public function setAbility($new){
        $this->ability = $new;
    }
    
    public function setLevel($new){
        $this->level = $new;
    }
    
    public function setEVs($new){
        $this->ev = $new;
    }
    
    public function setNature($new){
        $this->nature = $new;
    }
    
    public function setIVs($new){
        $this->iv = $new;
    }
    
    public function setMoves($new){
        $this->move = $new;
    }
    
    public function setTeamID($new){
        $this->teamID = $new;
    }
    
    
    public function saveToDatabase($pdo){
    	if ($this->species != ''){
			$sql = "INSERT INTO `tblMember` (`pmkMemberId`, `fnkTeamId`, `fldSpecies`, `fldItem`, `fldAbility`, `fldNature`, `fldIVs`, `fldEVs`, `fldMoves`, `fldLevel`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$statement = $pdo->prepare($sql);
		            $params = array(NULL, $this->teamID , $this->species, $this->item, $this->ability, $this->nature, $this->iv, $this->ev, $this->move, $this->level);
		            //echo $params;
		            if ($statement->execute($params)) {
		                    print '<!-- Record was successfully saved. -->';
		                } else {
		                    print '<!-- Record was NOT successfully saved. -->';
		            }
        }
    }
	
}
?>
<main>
    <article>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $dataIsGood = true;

            // Sanatation
            $userName = getData("txtUserName");
			$teamName = getData("txtTeamName");
			$teamFormat = getData("txtFormat");
			
			for ($i = 0; $i < $memberCount; $i++){
				$members[$i]->setSpecies(getData("txtSpecies" . $i+1));
				$members[$i]->setItem(getData("txtItem" . $i+1));
				$members[$i]->setAbility(getData("txtAbility" . $i+1));
				$members[$i]->setLevel(getData("txtLevel" . $i+1));
				$members[$i]->setEVs(getData("txtEVs" . $i+1));
				$members[$i]->setNature(getData("txtNature" . $i+1));
				$members[$i]->setIVs(getData("txtIVs" . $i+1));
				$members[$i]->setMoves(getData("txtMoves" . $i+1));
			}
			
			print "<!-- UN -->";
			if ($userName == ''){
				$userName = 'anonymous';
			} elseif (!verifyAlphaNum($userName)) {
				print '<p class="mistake">The authors name seems to have an invalid character.</p>';
                $dataIsGood = false;
			}
			
			print "<!-- TN -->";
			if ($teamName == ''){
				print '<p class="mistake">The team name is blank.</p>';
				$dataIsGood = false;
			} elseif (!verifyAlphaNum($teamName)) {
				print '<p class="mistake">The team name seems to have an invalid character.</p>';
                $dataIsGood = false;
			}
			
			print "<!-- TF -->";
			if ($teamFormat == ''){
				print '<p class="mistake">The format is blank.</p>';
				$dataIsGood = false;
			} elseif (!verifyAlphaNum($teamFormat)) {
				print '<p class="mistake">The format seems to have an invalid character.</p>';
                $dataIsGood = false;
			}
			
			$validMembers = 0;
			for ($i = 0; $i < $memberCount; $i++){
				$m = $i+1;
				
				print "<!-- SP{$i} -->";
				if($members[$i]->getSpecies() == ''){
					if($i > 0){
						$validMembers = $i;
						break;
					} else {
						"<p class=\"mistake\">The species of the first team member is blank. You need to have at least one team member.</p>";
					}
				} else if(!verifyAlphaNum($members[$i]->getSpecies())){
					print "<p class=\"mistake\">Team member {$m}'s species name seems to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- IT{$i} -->";
				if($members[$i]->getItem() == ''){
					$members[$i]->setItem("No Item");
				} elseif(!verifyAlphaNum($members[$i]->getItem())){
					print "<p class=\"mistake\">Team member {$m}'s item name seems to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- AB{$i} -->";
				if($members[$i]->getAbility() == ''){
					print "<p class=\"mistake\">Team member {$m} has no ability.</p>";
					$dataIsGood = false;
				} elseif(!verifyAlphaNum($members[$i]->getAbility())){
					print "<p class=\"mistake\">Team member {$m}'s ability seems to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- LV{$i} -->";
				if($members[$i]->getLevel() == ''){
					$members[$i]->setLevel(100);
				} elseif(!verifyAlphaNum($members[$i]->getLevel())){
					print "<p class=\"mistake\">Team member {$m}'s level seems to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- EV{$i} -->";
				if($members[$i]->getEVs() == ''){
					$members[$i]->setEVs("0/0/0/0/0/0");
				} elseif(!verifyAlphaNum($members[$i]->getEVs())){
					print "<p class=\"mistake\">Team member {$m}'s EVs seem to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- NA{$i} -->";
				if($members[$i]->getNature() == ''){
					$members[$i]->setNature('Serious');
				} elseif(!verifyAlphaNum($members[$i]->getNature())){
					print "<p class=\"mistake\">Team member {$m}'s nature seems to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- IV{$i} -->";
				if($members[$i]->getIVs() == ''){
					$members[$i]->setIVs("31/31/31/31/31/31");
				} elseif(!verifyAlphaNum($members[$i]->getIVs())){
					print "<p class=\"mistake\">Team member {$m}'s IVs seem to have an invalid character.</p>";
					$dataIsGood = false;
				}
				
				print "<!-- MV{$i} -->";
				if($members[$i]->getMoves() == ''){
					print "<p class=\"mistake\">Team member {$m} has no moves.</p>";
					$dataIsGood = false;
				} elseif(!verifyAlphaNum($members[$i]->getMoves())){
					print "<p class=\"mistake\">Team member {$m} seems to have a move with an invalid character.</p>";
					$dataIsGood = false;
				}
			}
			
			if($validMembers < 1){
				$dataIsGood = false;
			}


            if ($dataIsGood) {
            	// Get the team creator's ID
            	$sql = "SELECT `pmkCreatorId` FROM `tblTeamCreator` WHERE `fldName` = '{$userName}'";
            	$statement = $pdo->prepare($sql);
                $statement->execute();
                $records = $statement->fetchAll();
                if(count($records) > 0){
                	$creatorId = intval($records[0]['pmkCreatorId']);
                }
                
                // If the creator does not already exist register a new one
                else {
                	$sql = "INSERT INTO `tblTeamCreator` (`pmkCreatorId`, `fldName`, `fldEmail`, `fldAccomplishments`) VALUES (?, ?, ?, ?) ";
		            $statement = $pdo->prepare($sql);
		            $params = array(NULL, $userName, NULL, 'Neither');
		            if ($statement->execute($params)) {
		                print '<!-- Record was successfully saved. -->';
		            } else {
		                print '<!-- Record was NOT successfully saved. -->';
                    
                	}
                }
                
				$sql = "SELECT `pmkCreatorId` FROM `tblTeamCreator` WHERE `fldName` = '{$userName}'";
            	$statement = $pdo->prepare($sql);
                $statement->execute();
                $records = $statement->fetchAll();
                if(count($records) > 0){
                	$creatorId = intval($records[0]['pmkCreatorId']);
                }
            
            
                $sql = "INSERT INTO `tblTeam` (`pmkTeamId`, `fnkCreatorId`, `fldTeamName`, `fldFormat`) VALUES (?, ?, ?, ?);";
                $statement = $pdo->prepare($sql);
                $params = array(NULL, $creatorId, $teamName, $teamFormat);
                
                
                if ($statement->execute($params)) {
                        print '<!-- Record was successfully saved. -->';
                    } else {
                        print '<!-- Record was NOT successfully saved. -->';
                }
                
                $sql = "SELECT `pmkTeamId` FROM `tblTeam` ORDER BY `pmkTeamId` DESC";
            	$statement = $pdo->prepare($sql);
                $statement->execute();
                $records = $statement->fetchAll();
                if(count($records) > 0){
                	$teamId = intval($records[0]['pmkTeamId']);
                }
                
                for ($i = 0; $i < $validMembers; $i++){
					$members[$i]->setTeamID($teamId);
					$members[$i]->saveToDatabase($pdo);
				}
            }

            if ($dataIsGood) {
                print '<h2>Your team has been submitted!</h2>';
            }
        }
        ?>




        <h2>Submit a Team</h2>

        <section>
            <h3>Submit your own team to the team manager!</h3>
            
            

            <?php
//            print '<p>Post Array:</p><pre>';
//            print_r($_POST);
//            print '</pre>';
            ?>

            <form action="#"
                  method="POST">
                <fieldset class = "name">
                    <legend>About the Team</legend>
                    <p>
                        <label class ="required" for ="txtTeamName">Team Name</label>
                        <input id ="txtTeamName"
                               maxlength="32"
                               name ="txtTeamName"
                               type ="text"
                               value="<?php print $teamName; ?>"
                               required>
                    </p>

                    <p>
                        <label class ="required" for ="txtUserName">Author</label>
                        <input id ="txtUserName"
                               maxlength="32"
                               name ="txtUserName"
                               type ="text"
                               value="<?php print $userName; ?>"
                               required>
                    </p>

                    <p>
                        <label class ="required" for ="txtFormat">Format</label>
                        <input id ="txtFormat"
                               maxlength="32"
                               name ="txtFormat"
                               type ="text"
                               value="<?php print $teamFormat; ?>"
                               required>
                    </p>
                </fieldset>
                
				<?php
				
				for ($i = 1; $i <= $memberCount; $i++){
				print '<fieldset class ="member' . $i . '">
					<legend>Member #' . $i . '</legend>
					<p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtSpecies' . $i . '">Species</label>
                        <input id ="txtSpecies' . $i . '"
                               maxlength="32"
                               name ="txtSpecies' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getSpecies() . '" 
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtItem' . $i . '">Held Item</label>
                        <!-- if there is no item just say "no item" -->
                        <input id ="txtItem' . $i . '"
                               maxlength="32"
                               name ="txtItem' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getItem() . '"
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtAbility' . $i . '">Ability</label>
                        <input id ="txtAbility' . $i . '"
                               maxlength="32"
                               name ="txtAbility' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getAbility() . '"
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtEVs' . $i . '">Effort Values (EVs)</label>
                        <input id ="txtEVs' . $i . '"
                               maxlength="32"
                               name ="txtEVs' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getEVs() . '"
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtIVs' . $i . '">Individual Values (IVs)</label>
                        <input id ="txtIVs' . $i . '"
                               maxlength="32"
                               name ="txtIVs' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getIVs() . '"
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for ="txtNature' . $i . '">Nature</label>
                        <input id ="txtNature' . $i . '"
                               maxlength="32"
                               name ="txtNature' . $i . '"
                               type ="text"
                               value="' . $members[$i-1]->getNature() . '"
                               ' . (($i <= 1) ? 'required' : '')  . '>
                    </p>
                    
                    <p>
                        <label ' . (($i <= 1) ? 'class ="required"' : '')  . ' for="txtMoves' . $i . '">Moves</label>
                        <textarea id="txtMoves' . $i . '"
                                  name="txtMoves' . $i . '">' . $members[$i-1]->getMoves() .'</textarea>
                    </p>
                </fieldset>';
                
                }
                
                
                ?>
                    
                <fieldset class="buttons">
                    <input id = "btnSubmit" 
                           name = "btnSubmit" 
                           type = "submit" 
                           value = "Submit">
                </fieldset>
            </form>



        </section>


    </article>
   
</main>
