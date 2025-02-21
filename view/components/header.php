<?php 
    include_once('../../../controller/LogoutController.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Mangement System</title>
    <!-- Bootstrap CSS CDN -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../../css/bootsrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <!-- <script src="../../js/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome CDN -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="../../css/fontawesome.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
    <!-- <link rel="stylesheet" href="../../css/boxicons.css"> -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
         <!-- add icon link -->
    <link rel="icon" href=
"../../../assets/images/logo.png" 
        type="image/x-icon" />
</head>
<body class="px-1 px-md-5">
<style>
    
.navbar-brand {
    font-weight: bold;
}

/* .btn-logout {
    background-color: #dc3545;
    color: white;
} */



.dashboard-card {
    background-color: white;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.stat-number a {
    text-decoration: none;
    color: inherit;
}

.stat-number {
    font-size: 3rem;
    font-weight: bold;
    color: #8B4513;
}

.stat-label {
    color: #6c757d;
}

.action-button {
    background-color: #8B4513;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    margin-top: 10px;
}

.recent-activities {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.stats-container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.stats-row {
    display: flex;
    flex: 1;
}


.stats-col {
    flex: 1 1 calc(25% - 15px); /* Adjust card size for responsiveness */
    max-width: calc(25% - 15px);
}

@media (max-width: 768px) {
    .stats-col {
        flex: 1 1 calc(50% - 15px); /* Adjust card size for smaller screens */
        max-width: calc(50% - 15px);
    }
}

@media (max-width: 576px) {
    .stats-col {
        flex: 1 1 100%; /* Full width for very small screens */
        max-width: 100%;
    }
}

.stats-card {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.modal.fade .modal-dialog.modal-dialog-slideright {
    transform: translate(100%, 0);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog.modal-dialog-slideright {
    transform: translate(0, 0);
}

.confirmation-details {
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.detail-item {
    padding: 12px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #495057;
}

.detail-value {
    color: #212529;
}

.table-responsive {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}
</style>

