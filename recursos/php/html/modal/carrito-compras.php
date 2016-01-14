<!-- modal -->
<div id="modal-carrito-compras" class="st-modal modal-tym" ng-controller="shoppingCartCtrl">
    <div class="contenido">
		<span class="cerrar"><i class="fa fa-remove"></i></span>
		<div class="cont">
            <div class="titulo">
                <h1>Carrito de compras</h1>
            </div>
            <!--<button ng-click="read()" class="btn c-blanco bg-color3 txt-12" data-modal="carrito-compras"><i class="fa fa-shopping-cart"></i>&nbsp;leer rines</button>-->
            <div class="container">
            	<div class="row">
            		<div class="col-sm-7">
                        <div ng-if="shoppingcart == undefined" class="alert alert-info bg-color4">
			            	<i>Sin productos</i>
			            </div>
            			<div ng-if="shoppingcart != undefined" class="table-responsive">
			                <table class="tabla text-center">
			                    <thead>
			                        <tr>
			                            <th>ITEM</th>
			                            <th>NOMBRE</th>
			                            <th>PRECIO</th>
			                            <th>CANTIDAD</th>
			                            <th>SUBTOTAL</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                        <tr ng-repeat="(key, product) in shoppingcart.products">
			                            <td>
			                                <img src="recursos/img/muestra-item-llanta.jpg" alt="imagen de producto">
			                            </td>
			                            <td ng-bind="product.name"></td>
			                            <td class="text-right" ng-bind="product.price | currency : '$' : 0"></td>
			                            <td>
			                            	<select name="quantity" ng-model="quantity" id="shop-cant" ng-change="recalculateTotals(key, 'newValue', quantity)" class="form-control">
			                            		<option ng-value="1">1</option>
			                            		<option ng-value="2">2</option>
			                            		<option ng-value="3">3</option>
			                            		<option ng-value="4">4</option>
			                            		<option ng-value="5">5</option>
			                            		<option ng-value="6">6</option>
			                            		<option ng-value="7">7</option>
			                            		<option ng-value="8">8</option>
			                            	</select>
			                            </td>
			                            <td class="text-right" ng-bind="(product.price * product.cant) | currency : '$' : 0"></td>
			                        </tr>
			                        <tr class="text-right">
			                            <td colspan="4">
			                                <b class="txt-24 c-color3">Total:</b>
			                            </td>
			                            <td>
			                                <b class="c-color4 txt-24" ng-bind="shoppingcart.total | currency : '$' : 0"></b>
			                            </td>
			                        </tr>
			                    </tbody>
			                </table>
			            </div>
			            <hr>

                        <div class="row" ng-if="shoppingcart != undefined">
							<div class="col-xs-12 text-uppercase text-left" ng-if="!deliveryAndInstalation">
								<label>
									<input type="checkbox" name="delivery" ng-model="delivery" ng-checked="shoppingcart.shippingFree != undefined && shoppingcart.addDelivery" ng-click="recalculateTotals( 0, 'addDelivery' )" id="checkout-delivery">
									Envío
								</label>
							</div>
                            <div class="col-xs-12 text-uppercase text-left">
								<label>
									<input type="checkbox" name="delivery-and-instalation" ng-model="deliveryAndInstalation" ng-click="recalculateTotals( 0, 'addDeliveryAndinstalation' )" id="checkout-delivery-and-instalation">
									Envío e instalación
								</label>
							</div>
						</div>

			            <div class="alert alert-info bg-color4">
			            	<i>Despachos sin costo a ciudades principales mayor información sobre envíos especiales via e-mail o contacte nuestro asesor en línea.</i>
			            </div>

			            <div class="row">
	            			<div class="col-xs-12 text-right">
	            				<button ng-click="close()" class="btn bg-color3 c-blanco text-uppercase">Volver a la tienda</button>
	            			</div>
	            		</div>
	            		<hr class="visible-xs">
            		</div>
            		<div class="col-sm-5" ng-if="shoppingcart.addDelivery || shoppingcart.addDeliveryAndinstalation">
            			<div class="registro-compra bg-color3 text-left">
            				<h3 class="text-uppercase">Datos de envío</h3>

            				<form>
            					<div class="form-group">
            						<label for="">Nombre:</label>
            						<input type="text" name="userName" ng-model="order.userName" ng-init="order.userName = '<?= $_SESSION['user_name']?>'" id="order-user-name" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">E-Mail:</label>
            						<input type="text" name="email" ng-model="order.email" ng-init="order.email = '<?= $_SESSION['email']?>'" id="order-email" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">Celular:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
                                <div class="form-group">
            						<label for="">Dirección de envío:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">Teléfono fijo:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            				</form>
            			</div>
						<br>
            			<div class="row">
	            			<div class="col-xs-12 text-right">
                                <button ng-disabled="shoppingcart == undefined" class="btn bg-color2 c-blanco text-uppercase">Pagar</button>
	            			</div>
	            		</div>
            		</div>
            	</div>
            </div>
    	</div>
    </div>
</div>
