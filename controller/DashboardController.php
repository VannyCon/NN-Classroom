<?php 


require_once('../../../services/DashboardService.php');
$dashboard = new Dashboard();
$benefits = $dashboard->getBenefits();
$disease = $dashboard->getDisease();
$trivia = $dashboard->getTrivia();
?>
