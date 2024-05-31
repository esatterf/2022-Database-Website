CREATE TABLE `ESATTERF_final`.`tblTeamCreator` (
`pmkCreatorId` INT(11) NOT NULL AUTO_INCREMENT ,
`fldName` VARCHAR(32) NOT NULL DEFAULT 'anonymous' ,
PRIMARY KEY (`pmkCreatorId`))


CREATE TABLE `ESATTERF_labs`.`tblTeam` (
`pmkTeamId` INT(11) NOT NULL AUTO_INCREMENT ,
`fnkCreatorId` INT NOT NULL ,
`fldTeamName` VARCHAR(32) NOT NULL ,
`fldFormat` VARCHAR(32) NOT NULL ,
PRIMARY KEY (`pmkTeamId`)) 


CREATE TABLE `ESATTERF_Final`.`tblMember` (
`pmkMemberId` INT(11) NOT NULL AUTO_INCREMENT , 
`fnkTeamId` INT(11) NOT NULL , 
`fldSpecies` VARCHAR(32) NOT NULL , 
`fldItem` INT(32) NOT NULL ,
`fldAbility` INT(32) NOT NULL , 
`fldNature` ENUM('Hardy','Lonely','Brave','Adamant','Naughty','Bold','Docile','Relaxed','Impish','Lax','Timid','Hasty','Serious','Jolly','Naive','Modest','Mild','Quiet','Bashful','Rash','Calm','Gentle','Sassy','Careful','Quirky') NOT NULL DEFAULT 'Serious' ,
PRIMARY KEY  (`pmkMemberId`))

ALTER TABLE `tblMember`  ADD `fldLevel` INT(3) NOT NULL  AFTER `fldMoves`;

ALTER TABLE `tblMember` CHANGE `fldLevel` `fldLevel` INT(3) NOT NULL DEFAULT '100'; 



SELECT fldName, fldTeamName, fldFormat FROM tblTeam LEFT JOIN tblTeamCreator ON pmkCreatorId = fnkCreatorId;


INSERT INTO `tblMember` (`pmkMemberId`, `fnkTeamId`, `fldSpecies`, `fldItem`, `fldAbility`, `fldNature`, `fldIVs`, `fldEVs`, `fldMoves`, `fldLevel`) VALUES (NULL, '1', 'Charizard', 'Charizardite Y', 'Blaze', 'Timid', '31/0/31/31/31/31', '0/0/4/252/0/252', 'Flamethrower\r\nSolar Beam\r\nScorching Sands\r\nRoost', '100');

ALTER TABLE `tblTeamCreator` ADD `fldEmail` VARCHAR(64) NOT NULL AFTER `fldName`, ADD `fldAccomplishments` ENUM('top500Showdown','top10000MasterBall','both','neither') NOT NULL DEFAULT 'neither' AFTER `fldEmail`; 

INSERT INTO `tblTeam` (`pmkTeamId`, `fnkCreatorId`, `fldTeamName`, `fldFormat`) VALUES (NULL, '1', 'gamers', 'Ubers');
