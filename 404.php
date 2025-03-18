<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .error-container {
            max-width: 600px;
            padding: 30px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
        }
        .error-description {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
        <div class="error-code">404</div>
        <div class="error-message">Oops! Page Not Found</div>
        <p class="error-description">The page you are looking for might have been removed, changed, or is temporarily unavailable.</p>
       
    </div>

</body>
</html>
