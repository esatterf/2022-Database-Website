<?php
include 'top.php';
?>

<main>
	<h2>Featured Teams</h2>
	<p>These are teams that are submitted by users who have acheived high rankings on either the in game ranked mode or on the browser-based battle simulator pokemon showdown. These teams are from users who have tagged themselves as high ranking players. There’s no actual verification to this so it’s a system of trust but it’s nice to be able to filter out the random teams and look at ones that were made by someone who sort of knows what they’re doing. Team building is a skill for sure but piloting a team is it’s own beast, not all teams are equally easy to play so don’t expect to have success with a team just because someone else did.</p>
	<p>If you want to look at all teams check out <a href="teams.php">All Teams</a></p>
	<?php
                //$sql = 'SELECT fld, fldWrong, fldFix FROM tblIssues';
                $sql = 'SELECT fldName, fldTeamName, fldFormat, fldSpecies, fldItem, fldAbility, fldNature, fldIVs, fldEVs, fldMoves, fldLevel FROM tblTeam LEFT JOIN tblTeamCreator ON pmkCreatorId = fnkCreatorId LEFT JOIN tblMember ON pmkTeamId = fnkTeamId WHERE fldAccomplishments != \'neither\' ORDER BY pmkTeamId DESC';
                
                //fldName, fldTeamName, fldFormat
                
                // fldIsuue, fldWrong, fldFix

                $statement = $pdo->prepare($sql);
                $statement->execute();

                $records = $statement->fetchAll();
                $timesLooped = 0;
                $prevTeam = '';
                print '<!-- Bob said I should use divs here -->';
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
