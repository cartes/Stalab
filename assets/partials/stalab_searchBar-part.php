<div class="row">
    <div class="col-md-7 p-0">
        <form id="product-search" class="form" method="post" action="<?php echo home_url('/buscador-de-productos') ?>">
            <div class="form-group position-relative">
                <input id="adSearch" class="form-control" type="text" name="search" placeholder="Buscar..."
                       autocomplete="off"/>
                <button type="submit" class="search-btn position-absolute" style="z-index: 1500;">
                    <i class="fas fa-search"></i>
                </button>
                <div class="listSearch list-group"></div>
            </div>
        </form>
    </div>
    <div class="col-md-5 p-0">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenu"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Filtros
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                <a href="<?php echo home_url('buscador-de-productos/alfabetico/') ?>" class="dropdown-item"
                   data-value="1">De la A a la Z</a>
                <a href="<?php echo home_url('buscador-de-productos/marcas/') ?>" class="dropdown-item" data-value="2">Marcas</a>
                <a href="<?php echo home_url('buscador-de-productos/accesorios/') ?>" class="dropdown-item"
                   data-value="3">Accesorios</a>
                <a href="<?php echo home_url('buscador-de-productos/muestras/') ?>" class="dropdown-item"
                   data-value="5">Tipo de Muestra</a>
                <a href="<?php echo home_url('buscador-de-productos/campos-de-aplicacion/') ?>" class="dropdown-item"
                   data-value="6">Campo de aplicación</a>
            </div>
        </div>
    </div>
</div>
