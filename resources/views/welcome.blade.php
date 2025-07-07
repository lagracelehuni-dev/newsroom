<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsroom</title>
    <link rel="shortcut icon" href="{{ 'assets/img/@favicon__newsroom--v5.png' }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ 'assets/css/styles.css' }}">
    <link rel="stylesheet" href="{{ 'assets/vendor/remixicon/remixicon.css' }}">
    <link rel="stylesheet" href="{{ 'assets/vendor/fontawesome/css/all.css' }}">
</head>
<body>
    <main class="relative welcomepage">
        <div class="logo-bloc">
            <img src="{{ "assets/img/@favicon__newsroom--v5.png" }}" alt="logo">
        </div>

        <section><span class="loader-40"> </span></section>
    </main>

    @if (isset($redirectTo))
        <script>

            window.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    window.location.replace("{{ $redirectTo }}")
                }, 2000);
            })
        </script> 
    @endif
    
</body>
</html>