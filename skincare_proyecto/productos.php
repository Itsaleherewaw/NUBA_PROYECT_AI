<?php
$productos = include __DIR__ . '/php/productos-data.php';
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos - Skincare Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-3">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.html">
          <img src="img/logo.png" alt="logo" width="56" height="56" class="me-2 logo">
          <span class="brand-title">Skincare Boutique</span>
        </a>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="navbar-nav ms-auto align-items-lg-center">
            <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
            <li class="nav-item"><a class="nav-link active" href="productos.php">Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-5">
      <div class="container">
        <div class="row mb-4 align-items-center">
          <div class="col-md-8">
            <h1 class="mb-0">Nuestros productos</h1>
            <p class="text-muted">Descubrí nuestra selección de cosmética y cuidado facial.</p>
          </div>
          <div class="col-md-4 text-md-end">
            <a href="#" class="btn btn-outline-secondary me-2">Filtrar</a>
            <a href="#" class="btn btn-primary">Ordenar: Popular</a>
          </div>
        </div>

        <div class="row g-4">
          <?php foreach($productos as $p): ?>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
              <img src="img/<?= htmlspecialchars($p['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nombre']) ?>">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-1"><?= htmlspecialchars($p['nombre']) ?></h5>
                <p class="text-muted small mb-2"><?= htmlspecialchars($p['descripcion']) ?></p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <strong class="price">$<?= number_format($p['precio'], 2, ',', '.') ?></strong>
                  <div>
                    <a href="#" class="btn btn-sm btn-outline-primary me-2">Ver</a>
                    <button class="btn btn-sm btn-primary">Comprar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

      </div>
    </main>

    <footer class="py-4 mt-5">
      <div class="container d-flex justify-content-between align-items-center">
        <small>&copy; 2025 Skincare Boutique</small>
        <div>
          <a href="#" class="me-3 text-decoration-none">Términos</a>
          <a href="#" class="text-decoration-none">Política</a>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
