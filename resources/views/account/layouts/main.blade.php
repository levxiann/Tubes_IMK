<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Serba Ada</title>

    <link rel="stylesheet" href="{{ asset('/a1/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <div class="mode ms-auto">
                <input type="checkbox" class="checkbox" id="chk" />
                <label class="label" for="chk">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                    <div class="ball"></div>
                </label>
            </div>
        </div>
    </nav>

    @yield('content')    

    
    <nav class="footer fixed-bottom footer-light text-center pt-2 pb-2">
        <span class="footer-text">
            Copyright &copy; 2021 Kelompok IMK
        </span>
    </nav>

<script>
    const chk = document.getElementById('chk');

    chk.addEventListener('change', () => {
        document.body.classList.toggle('dark');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html> 