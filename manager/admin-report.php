<?php
include 'top.php';
?>

<main>
	<h1>Admin Report</h1>
	<?php
                // List of users
                print '<h2>List of Users</h2>';
                $sql = 'SELECT fldName, pmkCreatorId FROM tblTeamCreator ORDER BY pmkCreatorId';
                
                $statement = $pdo->prepare($sql);
                $statement->execute();

                $records = $statement->fetchAll();
                foreach ($records as $record) {
                    print '<p> Creator ID ' . $record['pmkCreatorId'] . ': ' . $record['fldName'] . '</p>';
                }
                
                
                // List of teams
                print '<h2>List of Teams</h2>';
                $sql = 'SELECT fldTeamName, pmkTeamId FROM tblTeam ORDER BY pmkTeamId';
                
                $statement = $pdo->prepare($sql);
                $statement->execute();

                $records = $statement->fetchAll();
                foreach ($records as $record) {
                    print '<p> Team ID ' . $record['pmkTeamId'] . ': ' . $record['fldTeamName'] . '</p>';
                }
                
                // List of members
                print '<h2>List of Members</h2>';
                $sql = 'SELECT fldSpecies, pmkMemberId FROM tblMember ORDER BY pmkMemberId';
                
                $statement = $pdo->prepare($sql);
                $statement->execute();

                $records = $statement->fetchAll();
                foreach ($records as $record) {
                    print '<p> Member ID ' . $record['pmkMemberId'] . ': ' . $record['fldSpecies'] . '</p>';
                }
      ?>
</main>

<?php
include 'footer.php';
?>
