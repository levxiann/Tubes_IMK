<main>
    <div class="d-flex flex-column flex-shrink-0 bg-dark" style="width: 4.5rem;">
        <a href="/" class="d-block p-3 link-dark text-decoration-none bg-light" title="Toko Serba Ada" data-bs-toggle="tooltip" data-bs-placement="right">
            <img src="{{asset('/a1/asset/img/wallet.svg')}}" alt="wallet" srcset="" height="32" width="40">
        </a>
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li class="nav-item">
                <a href="{{url('/')}}" class="nav-link py-3 border-bottom @if(session()->has('menu') && session()->get('menu') == 'dashboard') bg-light @else text-white @endif" aria-current="page" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
                <span class="far fa-tachometer"></span>
                </a>
            </li>
            <li>
                <a href="{{url('/stock')}}" class="nav-link py-3 border-bottom" title="Produk" data-bs-toggle="tooltip" data-bs-placement="right">
                <span class="far fa-cubes"></span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link py-3 border-bottom @if(session()->has('menu') && session()->get('menu') == 'discount') bg-light @else text-white @endif" title="Diskon" data-bs-toggle="tooltip" data-bs-placement="right">
                    <span class="far fa-percent"></span>
                </a>
            </li>
            <li>
                <a href="{{url('/order')}}" class="nav-link py-3 border-bottom @if(session()->has('menu') && session()->get('menu') == 'receipt') bg-light @else text-white @endif" title="Struk" data-bs-toggle="tooltip" data-bs-placement="right">
                    <span class="far fa-receipt"></span>
                </a>
            </li>
            <li>
                <a href="{{route('logout')}}" class="nav-link py-3 border-bottom text-white" title="Keluar" data-bs-toggle="tooltip" data-bs-placement="right">
                    <span class="far fa-sign-out"></span>
                </a>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
            <li>
                <div class="nav-link py-3"></div>
            </li>
        </ul>
    </div>