<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

</head>
<body>
<h1>Forget Password Email</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card">
                    <h5 class="card-header">You are receiving this email because we received a password reset request for you account!</h5>
                    <div class="card-body">
                        <h5 class="card-title">You can reset password from bellow link:</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ $url }}" class="btn btn-primary">Reset Password</a>
                        <p class="card-text">If you did not request a password reset, no further action is required.</p>
                        <p>Regards</p>
                        <p>Health Insurance Team</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">&copy;<span class="">Health Insurance</span> All rights reserved</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>