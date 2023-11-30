<?php
    // Veritabanı bağlantısı
    $conn = new mysqli("localhost", "root", "", "pawpath");

    if ($conn->connect_error) {
        die("Veritabanına bağlanırken hata: " . $conn->connect_error);
    }

    // Sayfalama işlemleri
$postsPerPage = 4; // Her sayfada kaç blog gösterilecek
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Hangi sayfa gösteriliyor
$startFrom = ($page - 1) * $postsPerPage; // Bu sayfa hangi sıradan başlayacak

// Blog yazılarını çekme
$sql = "SELECT * FROM blog ORDER BY created_at DESC LIMIT $startFrom, $postsPerPage";
$result = $conn->query($sql);

// Toplam sayfa sayısını bulma
$totalPagesQuery = "SELECT COUNT(*) as total FROM blog";
$totalPagesResult = $conn->query($totalPagesQuery);
$totalPages = ceil($totalPagesResult->fetch_assoc()['total'] / $postsPerPage);




$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Pawpath</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://kit.fontawesome.com/b1573057bf.js" crossorigin="anonymous"></script>
        <style>
            .col-blog{
                background:red;
                padding-top: 3.5em;
                width: calc(50% - 20px);
            margin-bottom: 20px;
            box-sizing: border-box;
                padding-bottom: 3.5em;
                
                }
                .col-blog1{
                margin-top: 5rem;
                display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
                }
                
                
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 0 4px;
            cursor: pointer;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <!--Header-->
            <div class="col-head">
                <div class="col-logo"><img src="../img/logo.png"></div>
                <div class="col-menu">
                    <ul>
                        <li><a href="../php/index.php">Anasayfa</a></li>
                        <li><a href="#">Hizmetlerimiz</a></li>
                        <li><a href="../php/blog.php">Blog</a></li>
                        <li><a href="../php/hakkimizda.php">Hakkımızda</a></li>
                    </ul>
                </div>

                <div class="col-user-act">
                    <ul>
                        <li><a href="../php/login.php">Giriş Yap</a></li>
                        <li><a href="../php/register.php">Kayıt Ol</a></li>
                    </ul>

                    <input type="checkbox" id="check">
                    <label for="check">
                        <i class="fas fa-bars" id="btn"></i>
                        <i class="fas fa-times" id="cancel"></i>
                    </label>

                    <div class="sidebar">
                        <header>PawPath</header>
                        <li><a href="../php/index.php">Anasayfa</a></li>
                        <li><a href="#">Hizmetlerimiz</a></li>
                        <li><a href="../php/blog.php">Blog</a></li>
                        <li><a href="../php/hakkimizda.php">Hakkımızda</a></li>                  
                    </div>
                </div>
            </div>

            <!--blog-->
            <div class="col-aboutus-top">
                <img src="../img/blogimg.png">
            </div>
            <div class="columns col-blog1">
            <?php
   
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-blog'>";
                        echo "<div class='col-blog-title'<h2>" . $row["title"] . "</h2></div>";
                        $contentPreview = substr($row["content"], 0, 50); // İlk 200 karakteri al
                        echo "<p>" . $contentPreview . "...</p>";        
                        echo "<p class='timestamp'>Oluşturulma Tarihi: " . $row["created_at"] . "</p>";
                        echo "</div>";
                   
            }
            
        } else {
            echo "Henüz blog yazısı bulunmuyor.";
        }
        ?>
        </div>
    
        <!-- Sayfalama bağlantıları -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='blog.php?page=$i'>$i</a> ";
            }
            ?>
        </div>
        
    

            <!--Footer-->
            <div class="col-footer col-footer-bg">
                <div class="col-footer1">
                    <div class="col-left">
                        <img src="../img/logo.png"><br>
                        <p>Siz de evcil dostlarınızın sağlığını ve mutluluğunu önemsiyorsanız, doğru adrestesiniz! Evcil hayvanlarınızın hayat kalitesini artırmak ve sağlıklarını korumak için bizimle adım atın!</p>
                    </div>

                    <div class="col-center">
                        <h2>Servislerimiz</h2>
                        <ul>
                            <li><a href="../php/index.php">Anasayfa</a></li>
                            <li><a href="#">Hizmetlerimiz</a></li>
                            <li><a href="../php/blog.php">Blog</a></li>
                            <li><a href="../php/hakkimizda.php">Hakkımızda</a></li>
                        </ul>
                    </div>
                    <div class="col-right">
                        <h6>Geri Dönüşleriniz Bizim İçin Önemli!</h6>
                            <form>
                                <textarea type="text" id="footertext" placeholder="Mesajınızı Buraya Bırakabilirsiniz"></textarea>
                                <button type="submit" id="footerbtn">Gönder</button>
                            </form>
                    </div>
                </div>

                <div class="col-footer-hr"><hr></div>
                <div class="col-footer2">
                    <div class="col-copy">
                        <h4>Gizlilik Politikası</h4>
                        <h4>Hizmet Şartları</h4>
                        <h4>Tasarım ve Altyapı BGY</h4>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>





       