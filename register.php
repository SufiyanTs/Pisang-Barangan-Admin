<!DOCTYPE html>
<html lang="en">
    <head>
        <!--meta tags-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--bootstrap CSS-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <?php
            //menyertakan file program koneksi.php pada register
            require('config.php');
             //inisialisasi session
    session_start();

    $error = '';
    $validate = '';
    if (isset($_SESSION['Admins'])) header('Location: index.php');
    //mengecek apakah data username yang diinpukan user kosong atau tidak
    if (isset($_POST['submit'])) {

        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($db, $username);
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($db, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($db, $password);
        $repass = stripslashes($_POST['repassword']);
        $repass = mysqli_real_escape_string($db, $repass);
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if (!empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
            //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
            if ($password == $repass) {
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
                if (cek_nama($username, $db) == 0) {
                    //hashing password sebelum disimpan didatabase
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    //insert data ke database
                    $query = "INSERT INTO Admins (username,email, password ) VALUES ('$username','$email','$password')";
                    $result = mysqli_query($db, $query);
                    //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan
                    if ($result) {
                        $_SESSION['username'] = $username;

                        header('Location: index.php');

                        //jika gagal maka akan menampilkan pesan error
                    } else {
                        $error = 'Register User Gagal !!';
                    }
                } else {
                    $error = 'Username sudah terdaftar !!';
                }
            } else {
                $validate = 'Password tidak sama !!';
            }
        } else {
            $error = 'Data tidak boleh kosong !!';
        }
    }


    //fungsi untuk mengecek username apakah sudah terdaftar atau belum
    function cek_nama($username, $db)
    {
        $nama = mysqLi_real_escape_string($db, $username);
        $query = "SELECT * FROM Admins WHERE username = '$nama'";
        if ($result = mysqLi_query($db, $query)) return mysqLi_num_rows($result);
    }
    ?>
    <section class="container-fluid mb-4">
        <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-and-4">
                <form class="form-container" action="register.php" method="POST">
                    <h4 class="text-center font-weight-bold"> Sign-Up </h4>
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="InputEmail">Alamat Email</label>
                        <input type="email" class="form-control" id="InputEmail" name="email" aria-describeby="emailHelp" placeholder="Masukkan email">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Password</label>
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                        <?php if ($validate != '') { ?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Re-Password </label>
                        <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-Password">
                        <?php if ($validate != '') { ?>
                            <p class="text-danger"><?= $validate; ?></p>
                        <?php } ?>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                    <div class="form-footer mt-2">
                        <p> Sudah punya account? <a href="login.php">Login</a></p>
                    </div>
                </form>
            </section>
        </section>
    </section>

    <!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan yang terakhit Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzOOrT7abK413StQIAqVgRVzpbzo5smXKp4YfRvH+8abtTElPi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+933U146j8kOWLaUAdn689aCwoqbHiSnjAK/18WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqlxyMiZ60WpmZQ5stwEULTy" crossorigin="anonymous"></script>
       </body>
</html>