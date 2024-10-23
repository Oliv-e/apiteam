
# Dokumentasi

SI KOPI Dibuat dan Digunakan Untuk Pembelajaran Kelompok API dan Aplikasi PBL lainnya di semester 5 Angkatan 2022 Prodi Teknik Informatika, Politeknik Negeri Pontianak.

## API
Semua API dibuat menggunakan prefix, jadi pengaksesan API berawalan '/api' .




## Referensi API

#### Login

```http
  POST /api/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id` | `text` | **Required** : NIM / NIP / ID ADMIN |
| `password` | `password` | **Required** : NIM / NIP / ID ADMIN |


#### Mengambil Data Mahasiswa

```http
  GET /api/mahasiswa
```
#### Mengambil Data Dosen

```http
  GET /api/dosen
```
#### Mengambil Data RPS

```http
  GET /api/rps
``` 
#### Mengambil Data Referensi

```http
  GET /api/referensi
``` 
#### Mengambil Data Rekomendasi

```http
  GET /api/rekomendasi
``` 
#### Mengambil Data KHS

```http
  GET /api/rps
``` 
#### Mengambil Data Konsul

```http
  GET /api/konsul
``` 
#### Mengambil Data Janji Temu

```http
  GET /api/janjitemu
``` 
#### Mengambil Data Dokumen

```http
  GET /api/dokumen
``` 
#### Mengambil Data Dokumen yang ditandai

```http
  GET /api/markeddokumen
``` 
