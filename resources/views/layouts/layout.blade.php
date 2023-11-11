<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="verify-paysera" content="c555aa1694a558eab6dfbea79a94837f">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css"
    rel="stylesheet"
    />
    <!-- jQuery and Popper.js -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->

    <!-- Bootstrap JS -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->

    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
        ></script>

</head>
<body class="m-0 p-0">
    <header>
        <nav class='relative flex flex-wrap items-center navbar navbar-border justify-center'>
            <div class='navbar-brand'>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" />
            </div>
            <div class='w-full text-center font-bold p-2.5 primary-text-color'>
                Šiaulių Auksinio Rato Rotaract Klubo
            </div>
            <div class='w-full text-center font-bold p-2.5 primary-text-color'>
                Support ticket
            </div>
        </nav>
    </header>
    <nav class="navbar fixed-bottom under">
        <div class="container">
            <a 
                class="primary-text-color"
                href="{{ route('home') }}"
            >
            <i class="fas fa-basket-shopping icon-item"></i>
            </a>
            <a 
                class="primary-text-color"
                href="{{ route('profile.view') }}"
            >
            <i class="fas fa-ticket icon-item"></i>
            </a>
            <a 
                class="primary-text-color"
                href="{{ route('winners.view') }}"
            >
                <i class="fas fa-trophy icon-item"></i>
                <!-- <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="26" width="26" xmlns="http://www.w3.org/2000/svg"><path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path><path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path></svg> -->
            </a>
        </div>
    </nav>
    
    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(request('status') === 'success')
                <div class="alert alert-success mt-3" role="alert">
                    Payment completed successfully
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div>
            @yield('content')
        </div>
    </main>
</body>
</html>