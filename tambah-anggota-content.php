<?php
include 'db/koneksi.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    // Insert the new member into the database
    $query = "INSERT INTO anggota (nama_lengkap, jenis_kelamin, tanggal_lahir, no_telpon, email, alamat, status_anggota, tanggal_daftar) 
              VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$full_name, $gender, $date_of_birth, $phone, $email, $address, $status]);

    // Redirect to the members list page after insertion
    header("Location: anggota.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #007bff;
        }

        .card-body {
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Add New Member</h4>
            </div>
            <div class="card-body">
                <!-- Member addition form -->
                <form action="tambah-anggota-content.php" method="POST">
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select class="form-control" name="gender" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">                            <option value="Perempuan">Female</option>
</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">No Telepon</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Member Status</label>
                        <select class="form-control" name="status">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Suspend">Ditangguhkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Tambah Member</button>
                </form>
            </div>
        </div>

        <div class="footer">
            <a href="route/anggota.php">Kembali ke daftar member</a>
        </div>
    </div>

    <!-- Add jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

