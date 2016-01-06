<div id="catalogo-accesorios" ng-controller="productListHeader">
	<div class="catalogo">
		<i class="indicador"></i>
		<div class="contenido">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10" ng-cloak>
						<p class="txt-13 text-right"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
						<section id="accesorio-tipo">
							<div class="text-center">
								<br>
								<p class="txt-11">Cargando accesorios...</p>
								<br>
								<img src="recursos/img/preloader-productos.gif" alt="">
							</div>
						</section>
					</div>
					<div class="col-sm-2 text-center">
						<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
						<i class="st-separador"></i>

						<div class="tipo">
							<div class="cuadro">
								<span>Tanques</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-tanques.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Racks</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-racks.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
						<div class="tipo">
							<div class="cuadro">
								<span>Bicicleteros</span>
							</div>
							<div class="foto">
								<img src="recursos/img/img-bicicleteros.jpg" alt="" class="img-responsive">
							</div>
							<a href="" class="btn text-uppercase btn-info c-blanco">Comprar<br>Ahora</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>