<?php
///////// counting unclear cases
$query = $conn->prepare("SELECT COUNT(*) AS unclearCOUNT FROM triage WHERE CLEARorNOT=? && Triage_timestamp LIKE '{$date}%'");
$query->bind_param('s',$casestate);
$query->execute();
$query->bind_result($numberOfunclear);
$query->fetch();

$query->close();

///////// counting clear cases

$casestate2="clear";

$query = $conn->prepare("SELECT COUNT(*) AS clearCOUNT FROM triage WHERE CLEARorNOT=? && Triage_timestamp LIKE '{$date}%' ");
$query->bind_param('s',$casestate2);
$query->execute();
$query->bind_result($numberOfclear);
$query->fetch();


$query->close();

///////// counting low cases

$state1="Low";
$query = $conn->prepare("SELECT COUNT(*) AS Lowcount FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%'");
$query->bind_param('s',$state1);
$query->execute();
$query->bind_result($numberOflow);
$query->fetch();


$query->close();

///////// counting medium cases

$state2="Medium";
$query = $conn->prepare("SELECT COUNT(*) AS medcount FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%'");
$query->bind_param('s',$state2);
$query->execute();
$query->bind_result($numberOfmed);
$query->fetch();


$query->close();

///////// counting high cases

$state3="high";
$query = $conn->prepare("SELECT COUNT(*) AS highcount FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%'");
$query->bind_param('s',$state3);
$query->execute();
$query->bind_result($numberOfhigh);
$query->fetch();

$query->close();

///////// counting low % cases

$query = $conn->prepare("SELECT COUNT(*) FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%' && CLEARorNOT='{$casestate}' ");
$query->bind_param('s',$state1);
$query->execute();
$query->bind_result($percentagOflow);
$query->fetch();



$query->close();
///////// counting medium % cases

$query = $conn->prepare("SELECT COUNT(*) FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%' && CLEARorNOT='{$casestate}' ");
$query->bind_param('s',$state2);
$query->execute();
$query->bind_result($percentageOfmed);
$query->fetch();

$query->close();


///////// counting high % cases


$query = $conn->prepare("SELECT COUNT(*) FROM triage WHERE severity_level=? && Triage_timestamp LIKE '{$date}%' && CLEARorNOT='{$casestate}' ");
$query->bind_param('s',$state3);
$query->execute();
$query->bind_result($percentageOfHigh);
$query->fetch();

$query->close();

///////// counting area size cases

$query = $conn->prepare("SELECT Area_size FROM Area WHERE Area_level=? ");
$query->bind_param('s',$state1);
$query->execute();
$query->bind_result($lowsize);
$query->fetch();

$query->close();
$query = $conn->prepare("SELECT Area_size FROM Area WHERE Area_level=? ");
$query->bind_param('s',$state2);
$query->execute();
$query->bind_result($medsize);
$query->fetch();

$query->close();
$query = $conn->prepare("SELECT Area_size FROM Area WHERE Area_level=? ");
$query->bind_param('s',$state3);
$query->execute();
$query->bind_result($highsize);
$query->fetch();
$query->close();
///////active doctors
$clinicnum=1;
$activity_state='Active';
$query = $conn->prepare("SELECT COUNT(*) FROM doctor WHERE clinicNumber=? && Activity_state=? ");
$query->bind_param('is',$clinicnum,$activity_state);
$query->execute();
$query->bind_result($low_Active);
$query->fetch();

$query->close();
$clinicnum=2;
$activity_state='Active';
$query = $conn->prepare("SELECT COUNT(*) FROM doctor WHERE clinicNumber=? && Activity_state=? ");
$query->bind_param('is',$clinicnum,$activity_state);
$query->execute();
$query->bind_result($med_Active);
$query->fetch();

$query->close();
$clinicnum=3;
$activity_state='Active';
$query = $conn->prepare("SELECT COUNT(*) FROM doctor WHERE clinicNumber=? && Activity_state=? ");
$query->bind_param('is',$clinicnum,$activity_state);
$query->execute();
$query->bind_result($high_Active);
$query->fetch();


$query->close();



?>