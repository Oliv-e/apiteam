<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
<div class="sidebar">
    <div class="logo">
        <div class="logo-header">
            <img src="{{asset('css/assets/logopolnep.png')}}" class="logo-img" alt="Logo Polnep">
            <h2>SI KOPI</h2>
        </div>
        <span>SISTEM APLIKASI KELOLA API</span>
    </div>
    <div class="menu">
        <div class="link-menu">
            <a href="{{route('dashboard')}}" class="link">
                <iconify-icon icon="mdi:home"></iconify-icon>
                <span>Dashboard</span>
            </a>
            <a href="#" class="link" id="userdata">
                <iconify-icon icon="fa-solid:users"></iconify-icon>
                <span>Data</span>
            </a>
            <a href="{{route('mahasiswa')}}" class="link data hidden">
                <span>Mahasiswa</span>
            </a>
            <a href="{{route('dosen')}}" class="link data hidden">
                <span>Dosen</span>
            </a>
            <a href="{{route('staff')}}" class="link data hidden">
                <span>Staff Admin</span>
            </a>
        </div>
        <div class="logout-menu">
            <a href="{{route('logout')}}" class="link">
                <iconify-icon icon="bx:log-out"></iconify-icon>
                <span>LOGOUT</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.getElementById('userdata').addEventListener('click', function (e) {
        const element = document.getElementsByClassName('data');
        for (var i = 0; i < element.length; i++) {
            element[i].classList.toggle("hidden");
        }
    })
</script>
