<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <div class="row" style="display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        align-content: center;">
            <div class="col-lg-4">
                <h2>Login</h2>
                <form method="post" action="index.php?action=login" class="form">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>