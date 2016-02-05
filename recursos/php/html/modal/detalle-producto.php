<div id="detalle-producto" ng-controller="productDetailCtrl">
	<div class="container">
		<div class="cerrar"></div>
		<row>
			<div class="col-sm-10" ng-cloak>
				<div class="row">
					<div class="col-sm-6">
						<p class="txt-13 text-uppercase"><span class="c-color3">Escogiste:</span> {{selectedCar.vehicle.brand}} / {{selectedCar.model.model}} / {{selectedCar.year}}</p>
					</div>
					<div class="col-sm-6">
						<p class="txt-13">Valora este artículo: &nbsp;<i class="st-calificacion valor-0"></i> | Votos (0)</p>
					</div>
				</div>
				<!-- rin -->
				<div ng-if="selectedProductType == 'rin'" class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<img ng-src="admin/recursos/img/rin-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-6">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
								<br>
								<br>
								<span class="c-color4">Tamaño:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.diameter}}" {{selectedProduct.width}}</b><br>
								<span class="c-color4">PCD:</span> <b class="pcd c-blanco txt-18">{{selectedProduct.pcd}}</b><br>
								<!--<span class="c-color4">ET:</span> <b class="et c-blanco txt-18">35</b><br>
								<span class="c-color4">CB:</span> <b class="cb c-blanco txt-18">73.1</b>-->
							</div>
							<div class="col-xs-6 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por rin</span><br>
								<b class="precio txt-24" ng-bind="(selectedProduct.price_client) | currency : '$' : 0"></b><br>
								<!-- <span class="c-color3 text-uppercase">Set x 4:</span><br>
								<b class="precio txt-20" ng-bind="(selectedProduct.price_client) | currency : '$' : 0"></b> -->
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<span class="c-color3 text-uppercase">Descripción:</span><br>
								<b class="precio txt-24" ng-bind="selectedProduct.details"></b><br>
								<!-- <span class="c-color3 text-uppercase">Compatible con los siguientes modelos</span> -->
								<br>
								<br>
								<br>
								<!-- <div class="form-group">
									<select name="" id="" class="form-control">
										<option value="">Seleccione Marca</option>
										<option value="">Chevrolet</option>
										<option value="">Hyundai</option>
										<option value="">Mazda</option>
										<option value="">Renault</option>
										<option value="">BMW</option>
										<option value="">Mercedes</option>
										<option value="">Ford</option>
									</select>
								</div> -->
							</div>
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.details, 1, selectedProduct.price_client, 0, 0, selectedProduct.img, 'rin')" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- rin -->
				<!-- tire -->
				<div ng-if="selectedProductType == 'tire'" class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<img ng-src="admin/recursos/img/tire-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
							<!-- <img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive"> -->
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-7">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
								<br>
								<br>
								<span class="c-color4">Llanta:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.type}}</b><br>
								<span class="c-color4">Marca:</span> <b class="pcd c-blanco txt-18">{{selectedProduct.brand}}</b><br>
								<span class="c-color4">Modelo:</span> <b class="et c-blanco txt-18">{{selectedProduct.model}}</b><br>
								<span class="c-color4">Indice de velicidad:</span> <b class="cb c-blanco txt-18">{{selectedProduct.speed_rate + '(Km/h)'}}</b><br>
								<span class="c-color4">Indice de carga:</span> <b class="cb c-blanco txt-18">{{selectedProduct.weigth_rate + '(Kg)'}}</b>
							</div>
							<div class="col-xs-5 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por llanta</span><br>
								<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
								<span class="c-color3 text-uppercase">Set x 4:</span><br>
								<b class="precio txt-20" ng-bind="(selectedProduct.price_group) | currency : '$' : 0"></b>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<br>
								<br>
								<br>
								<!-- <span class="c-color3 text-uppercase">Compatible con los siguientes modelos</span>
								<br>
								<div class="form-group">
									<select name="" id="" class="form-control">
										<option value="">Seleccione Marca</option>
										<option value="">Chevrolet</option>
										<option value="">Hyundai</option>
										<option value="">Mazda</option>
										<option value="">Renault</option>
										<option value="">BMW</option>
										<option value="">Mercedes</option>
										<option value="">Ford</option>
									</select>
								</div> -->
							</div>
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'tire')" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- tire -->
				<!-- seat -->
				<div ng-if="selectedProductType == 'portaequipaje'" class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<img ng-src="admin/recursos/img/portaequipajes-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-8">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock_unit"></b></span>
								<br>
								<br>
								<span class="c-color4">Caracteristica:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.details}}</b><br>
							</div>
							<div class="col-xs-4 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por articulo</span><br>
								<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'portaequipaje')" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- seat -->
				<!-- light -->
				<div ng-if="selectedProductType == 'light_hid'" class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<img ng-src="admin/recursos/img/light-hid-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-8">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock"></b></span>
								<br>
								<br>
								<span class="c-color4">Caracteristica:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.detail}}</b><br>
							</div>
							<div class="col-xs-4 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por rin</span><br>
								<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'light_hid')" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- light -->
				<!-- tank -->
				<div ng-if="selectedProductType == 'tank'" class="row producto">
					<div class="col-sm-6">
						<div class="imagen">
							<!-- <img ng-src="admin/recursos/img/tank-products/{{selectedProduct.img}}.gif" alt="" class="img-responsive"> -->
							<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive">
						</div>
					</div>
					<div class="col-sm-6">
						<span class="nombre" ng-bind="selectedProduct.brand"></span><br>
						<span class="descripcion" ng-bind="selectedProduct.brand+' '+selectedProduct.referencie"></span>
						<br>
						<br>
						<div class="row">
							<div class="col-xs-8">
								<span class="unidades text-center c-color3">Unidades <b class="c-blanco" ng-bind="selectedProduct.stock"></b></span>
								<br>
								<br>
								<span class="c-color4">Caracteristica:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.detail}}</b><br>
								<span class="c-color4">Color:</span> <b class="tamano c-blanco txt-18" >{{selectedProduct.color}}</b><br>
							</div>
							<div class="col-xs-4 text-right">
								<br>
								<br>
								<span class="c-color3 text-uppercase">Precio por rin</span><br>
								<b class="precio txt-24" ng-bind="(selectedProduct.price) | currency : '$' : 0"></b><br>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xs-12 text-right">
								<button ng-click="addToShoppingCart(selectedProduct.id, selectedProduct.referencie, selectedProduct.referencie, '000000', 1, selectedProduct.referencie, 1, selectedProduct.price, 0, 0, selectedProduct.img, 'tank')" class="btn btn-info c-color2 text-uppercase"><i class="fa fa-shopping-cart"></i>&nbsp; Añadir producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- tank -->

				<hr>

				<div class="row productos-compatibles" ng-if="selectedProductType == 'rin'">
					<div class="col-xs-12 text-center">
						<h3 class="c-color4 text-left">Llantas compatibles para tu vehículo</h3>
						<div class="text-center" ng-if="loadingCompatibles && (tiresCompatible != undefined)">
							<br>
							<p class="txt-16">cargando...</p>
							<br>
							<img src="recursos/img/preloader-productos.gif" alt="">
						</div>
						<div ng-if="tiresCompatible == undefined && selectedProductType == 'rin'" class="alert alert-info bg-color4">
			            	<i>Sin productos Compatibles</i>
			            </div>
						<ul id="slider-productos-compatibles" ng-show="showComptariblesProducts && tiresCompatible.length > 0">
							<!--<li ng-repeat="tire in tiresCompatible">
								<a ng-click="sendToProductDetail( tire, 'tire' )">
									 <img ng-src="admin/recursos/img/tire-products/{{tire.img}}.gif" alt=""><br>
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>{{tire.brand}} - {{tire.referencie}}</span>
								</li>-->

							<!-- <li ng-repeat="tire in tiresCompatible | limitTo:5	track by $index">
								<a ng-click="sendToProductDetail( tire, 'tire' )">
									<img ng-src="admin/recursos/img/tire-products/{{tire.img}}.gif" alt=""><br>
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>{{tire.brand}} - {{tire.referencie}}</span>
								</a>
							</li> -->
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>205-50-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>185-55-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>195-50-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>205-50-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>185-55-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>205-50-R15</span>
								</a>
							</li>
							<li>
								<a href="#">
									<img ng-src="recursos/img/foto-producto.jpg" alt="" class="img-responsive" width="200">
									<span>195-50-R15</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-2 text-center te-puede-interesar">
				<h5 class="text-uppercase txt-18 c-color4">Te puede interesar</h5>
				<i class="st-separador"></i>

				<div class="tipo">
					<div class="cuadro">
						<span>Tapate maletero</span>
					</div>
					<div class="foto img1">
						<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
					</div>
				</div>
				<div class="tipo">
					<div class="cuadro">
						<span>Pijamas</span>
					</div>
					<div class="foto img2">
						<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
					</div>
				</div>
				<div class="tipo">
					<div class="cuadro">
						<span>Plumillas</span>
					</div>
					<div class="foto img3">
						<a href="" class="btn text-uppercase bg-color3 txt-11 c-blanco">Comprar<br>Ahora</a>
					</div>
				</div>
			</div>
		</row>
	</div>
</div>
