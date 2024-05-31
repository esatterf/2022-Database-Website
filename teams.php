<?php
include 'top.php';
?>

<main>
	<h2>Teams</h2>
	<p>Below you can find a list of teams submitted by various users, unlike in <a href="index.php">Featured Teams</a> these teams can be submitted anonymously and by anyone so take their validity with a grain of salt. That being said the more ideas the better and those who don’t have the time or skill to get a high rank still deserve recognition. </p>
	<?php
                $sql = 'SELECT fldName, fldTeamName, fldFormat, fldSpecies, fldItem, fldAbility, fldNature, fldIVs, fldEVs, fldMoves, fldLevel FROM tblTeam LEFT JOIN tblTeamCreator ON pmkCreatorId = fnkCreatorId LEFT JOIN tblMember ON pmkTeamId = fnkTeamId ORDER BY pmkTeamId DESC';
                
                $statement = $pdo->prepare($sql);
                $statement->execute();

                $records = $statement->fetchAll();
                $timesLooped = 0;
                $prevTeam = '';
                foreach ($records as $record) {
                	if ($prevTeam != $record['fldTeamName']) {
                	print '<div class="head">';
                    print '<p>' . $record['fldTeamName'] . ' created by ' . $record['fldName'] . '</p>';
                    print '<p>' . 'Format: ' . $record['fldFormat'] . '</p>';
                    print '<p> Members: </p>';
                    $prevTeam = $record['fldTeamName'];
                    print '</div>';
                    }
                    print '<div class = "member">';
                    print '<p>' . $record['fldSpecies'] . ' @ ' . $record['fldItem'] . '</p>';
                    print '<p>Ability: ' . $record['fldAbility'] . '</p>';
                    print '<p>Level: ' . $record['fldLevel'] . '</p>';
                    print '<p>EVs: ' . $record['fldEVs'] . '</p>';
                    print '<p>' . $record['fldNature'] . ' Nature</p>';
                    print '<p>IVs: ' . $record['fldIVs'] . '</p>';
                    print '<p>Moves: ' . $record['fldMoves'] . '</p>';
                    print '<br>';
                    print '</div>';
                    $timesLooped = $timesLooped + 1;
                }
                print '<!-- ' . $timesLooped . '-->';
      ?>
</main>

<?php
include 'footer.php';
?>
