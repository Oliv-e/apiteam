@extends('admin.master')

@section('title', 'Data Mahasiswa')

@section('route', 'Data Mahasiswa')
@section('css')
    <style>
        .content {
            display: flex;
            flex-direction: column;
            height: 70vh;
        }
        table, td, th {
            border: 1px solid black;
            background: white;
        }
        .table-container {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            margin-top: 20px;
            width: 100%;
            flex: 1;
            padding: 10px;
        }
        td, th {
            padding: 8px;
            text-align: center
        }
        .content-link {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 0 10px;
        }
        .content-link a {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: black;
            border: 1px solid black;
            display: flex;
            align-items: center;
            gap: 10px
        }
        input {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid black;
            text-align: center
        }
    </style>
@endsection
@section('content')

    <div class="content">
        <div class="content-link">
            <a href="{{route('insert-mahasiswa')}}">
                <iconify-icon icon="fluent-mdl2:insert-rows-below"></iconify-icon> Akun & Data Mahasiswa
            </a>
            <input type="text" id="search" placeholder="Ketikkan NAMA atau NIM">
        </div>

        <div class="table-container">
            <table id="mahasiswa-table">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>KODE PRODI</th>
                        <th>Semester</th>
                        <th>KELAS</th>
                        <th>NIP</th>
                        <th>NO HP</th>
                    </tr>
                </thead>
                <tbody id="mahasiswa-table-body">
                    @foreach($data as $mhs)
                        <tr>
                            <td>{{$mhs->nim}}</td>
                            <td>{{$mhs->nama}}</td>
                            <td>{{$mhs->kode_prodi}} || {{$mhs->prodi->nama_prodi}}</td>
                            <td>{{$mhs->semester}}</td>
                            <td>{{$mhs->kelas->abjad_kelas}}</td>
                            <td>{{$mhs->dosen_pembimbing->nip}}</td>
                            <td>{{$mhs->no_hp}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('mahasiswa-table-body');

        searchInput.addEventListener('keyup', () => {
            const searchValue = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const columns = row.getElementsByTagName('td');

                let found = false;
                for (let j = 0; j < columns.length; j++) {
                    const column = columns[j];
                    if (column.textContent.toLowerCase().includes(searchValue)) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
@endsection
