<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? '') ?> | TechStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">TechStore</a>
        
     
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/san-pham">Tất cả sản phẩm</a></li>
                </ul>
                <form class="d-flex" action="/san-pham" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Tìm điện thoại, laptop...">
                    <button class="btn btn-outline-light btn-sm" type="submit">Tìm</button>
                </form>
            </div>
         </div>
    </nav>
    <main class="container py-4">
        <?= $content ?>
    </main>
    <footer class="bg-light py-3 mt-auto text-center"> 
               ©mTechStore. 
    </footer>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html> 