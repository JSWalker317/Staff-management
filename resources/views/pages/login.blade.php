<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}" >
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </head>
    <body class="container ">
       
        <h3 class="text-center mt-4">Login</h3>
        <form class="container align-items-center m-4" action="{{ route('getLogin') }}" method="post">
            @csrf
            <div class="input-group margin-bottom-sm">
                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                <input class="form-control" type="text" placeholder="Email" name="email">
            </div>
            @if ($errors->has('email'))
                <span class="text-danger"> {{ $errors->first('email') }}</span>
            @endif
            
            <div class="input-group mt-2">
                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                <input class="form-control" type="password" placeholder="Password" name="password">
            </div>

            @if ($errors->has('password'))
                <span class="text-danger"> {{ $errors->first('password') }}</span>
            @endif

            @if (session('message'))
                <ul>
                    <span class="text-danger"> {{ session('message') }}</span>
                </ul>
            @endif
            <div class="row mt-2">
                <div class="col ml-4">
                    <div class="form-group form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="checkbox"> Remember me
                        </label>
                    </div>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </div>
            </div>
        </form>
      
    </body>
</html>
