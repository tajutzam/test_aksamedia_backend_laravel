# Api Test Backend Intern Aksamedia

## Deskripsi Proyek

Proyek ini adalah aplikasi manajemen divisi dan karyawan yang juga menyediakan API untuk mengelola dan mengakses data nilai. Aplikasi ini dirancang untuk membantu organisasi dalam mengelola data divisi dan karyawan serta memberikan nilai hasil evaluasi karyawan melalui API. Api ini dibuat untuk memenuhi test magang di aksamedia sebagai backend developer

## Fitur Utama

- **Token Authentikasi**: Dengan menggunakan token yang memanfaatkan laravel sacntum agar lebih efisien dan secure.
- **Manajemen Divisi**: API Mengambil Data Divisi.
- **Manajemen Karyawan**: API untuk menambahkan, memperbarui, dan menghapus data karyawan.
- **Nilai RT**: API untuk mendapatkan data nilai RT karyawan.
- **Nilai ST**: API untuk mendapatkan data nilai ST karyawan.

## API Reference

## Api Login
```http
POST /api/login
```

### request

``` json

    username : "admin",
    password : "pasti bisa"

```

### response


``` json

    {
    "status": "success",
    "message": "Login successful",
    "data": {
        "token": "19|wnkf9B8kniCfKVA4kB69CZoOLuX7wdUISFqoqnR57c959afb",
        "admin": {
            "id": "9cbd7fd2-cc43-4842-91b5-08afcb72097a",
            "name": "admin aksamedia",
            "email": "admin@gmail.com",
            "username": "admin",
            "phone": "085607185972"
        }
    }
}

``` 

## Get All Divisions

```http
GET /api/divisions?page=1&per_page=2

```

### request

``` json

    name : "contoh"

``` 

### response

``` json

{
    "status": "success",
    "message": "Success fetch divisions",
    "data": {
        "divisions": [
            {
                "id": "9cbd7fd2-cec0-4fb3-b6b8-889a4af41dfd",
                "name": "Mobile Apps"
            },
            {
                "id": "9cbd7fd2-cf6d-432e-b981-bae01f2aecec",
                "name": "QA"
            }
        ]
    },
    "pagination": {
        "current_page": 1,
        "per_page": 2,
        "total": 17,
        "last_page": 9,
        "first_page_url": "http://localhost:8000/api/divisions?page=1",
        "last_page_url": "http://localhost:8000/api/divisions?page=9",
        "next_page_url": "http://localhost:8000/api/divisions?page=2",
        "prev_page_url": null
    }
}

```


## Get All Employee


```http
GET /api/employees?page=1&per_page=1

```

### request

``` json

    name : "contoh" // nullable,
    division_id : "id divisi"

``` 

### response 

``` json
{
    "status": "success",
    "message": "Success fetch employees",
    "data": {
        "employees": [
            {
                "id": "08ec7d11-5e13-4409-a8ed-326bdd035eee",
                "image": "http://localhost:8000/storage/images/SAxSQiMDXRqu5aC3Xi4QmK8Jq9HK7qoAU4Kuhw1m.jpg",
                "name": "John Doe",
                "phone": "1-845-619-2728",
                "division_id": "9cbd8bd1-9dfa-4b5e-84b6-a685b7833858",
                "position": "Order Filler OR Stock Clerk",
                "division": {
                    "id": "9cbd8bd1-9dfa-4b5e-84b6-a685b7833858",
                    "name": "Mustafa Hayes"
                }
            }
        ]
    },
    "pagination": {
        "current_page": 1,
        "per_page": 1,
        "total": 8,
        "last_page": 8,
        "first_page_url": "http://localhost:8000/api/employees?page=1",
        "last_page_url": "http://localhost:8000/api/employees?page=8",
        "next_page_url": "http://localhost:8000/api/employees?page=2",
        "prev_page_url": null
    }
}

``` 
## Add employeee


```http
post /api/employees

```

### request Form data 

``` json
    {
        image : file,
        name : string,
        phone : string,
        division : id divisi uuid,
        position : string
    }
```

### response json

``` json
    {
        "status": "success",
        "message": "Employee successfully created."
    }
```

## Delete Employee 

```http
delete /api/employees/{id}

```

### response

``` json
    
    // error
    {
        "status": "error",
        "message": "Failed to delete, employee not found"
    }

    // sukses
    {
        "message": "Success delete employee",
        "status": "success"
    }

```

## Update Employee 

```http
put /api/employees/{id}

```

### request Form data 

``` json
    {
        "image" : "file",
        "name" : "string",
        "phone" : "string",
        "division" : "id divisi uuid",
        "position" : "string",
        "_method" : "put" // pada postman kirim menggunakan post kenapa ? karena di laravel method put tidak support file uploaded jadi untuk membuat nya membaca sebagai put tambahkan _method dengan value put pada form data
    }
```

### response

``` json
    
    // error
    {
        "status": "error",
        "message": "Failed to update, employee not found"
    }

    // sukses
    {
        "status": "success",
        "message": "Employee successfully updated."
    }

```

## Loogut

```http
post /api/logout

```
### response

``` json
    // sukses
    {
        "status": "success",
        "message": "Successfully logged out!"
    }

    // error atau sudah logout

    {
        "message": "Unauthenticated."
    }

```

## Nilai RT 

```http
get /api/nilaiRT

```

### response

``` json
{
    [
        
        {
            "nama": "Muhammad Rizal Fatoni",
                "nilaiRt": {
                    "SOCIAL": "10.00",
                    "CONVENTIONAL": "6.00",
                    "INVESTIGATIVE": "5.00",
                    "REALISTIC": "3.00",
                    "ARTISTIC": "2.00",
                    "ENTERPRISING": "2.00"
                 },
            "nisn": "0078019829"
        },
        // dan seterusnya
    ]
}

```

## Nilai string

```http
get /api/nilaiST

```

### response

``` json
{
    [
        
        {
            "nama": "Muhammad Sanusi",
            "listNilai": {
                "Verbal": "208.35",
                "Penalaran": "200.00",
                "Figural": "142.86",
                "Kuantitatif": "89.01"
            },
            "nisn": "0094494403",
            "total": "640.22"
        },
        // dan seterusnya
    ]
}

```





## Cara menjalankan applikasi

untuk membuat database jalankan migrate terlebih dahulu

``` bash
    php artisan migrate
```

lalu jalankan seeder untuk menambahkan data2 dumynya

``` bash
    php artisan db:seed
```

lalu import nilai.sql ke database untuk kebutuhan api NilaiRT dan NilaiST

lalu Jalankan Applikasi dengan perintah berikut

``` bash
    php artisan serve
```

## Cara menjalankan unit testing


```bash
  php artisan test
```

setelah menjalankan testing jalankan seeder ulang karena di testing saya menggunakan refreshdatabase

## 🚀 About Me

Mohammad tajut zamzami . mohammadtajutzamzami07@gmail.com . 085607185972 .  Semoga ketrima menjadi Backend Developer Intern di Aksamedia ya amin 🙏

