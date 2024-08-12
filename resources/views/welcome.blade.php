<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Test Backend</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 960px;
        }
        .page-header {
            background-color: #e9f5ff;
            color: black;
            padding: 20px;
            border-radius: 8px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 2rem;
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .alert-info {
            background-color: #e9f5ff;
            border-color: #b6e1ff;
            color: #007bff;
        }
        .footer {
            color: black;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="page-header text-center">
            <h1>Data Nilai RT dan ST</h1>
        </div>
        <div class="alert alert-info mt-4 footer">
            <p class="mb-0">Data Nilai Rt Dan St Cek di console</p>
        </div>
        <div class="alert alert-info mt-4 footer">
            <p class="mb-0">Untuk menjalankan migration, seeder, testing, dan melihat website, silakan lihat File README.md</p>
        </div>
        <footer class="alert alert-info mt-4 footer">
            <h5>Dibuat untuk memenuhi test magang di aksa media oleh <strong>Mohammad Tajut Zamzami</strong></h5>
            <p>Politeknik Negeri Jember</p>
            <p><a href="mailto:mohammadtajutzamzami07@gmail.com">mohammadtajutzamzami07@gmail.com</a></p>
        </footer>
    </div>
    <script src="{{ asset('/') }}js/script.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
