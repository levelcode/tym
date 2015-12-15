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
						<h5 class="text-uppercase">Te puede interesar</h5>
						<i class="st-separador"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>