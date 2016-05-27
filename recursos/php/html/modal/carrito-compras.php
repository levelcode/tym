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
                                        <!-- <th>INSTALACIÓN</th> -->
                                        <th></th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                        <tr ng-repeat="(key, product) in shoppingcart.products">
			                            <td>
                                            <img ng-if="product.type == 'kit completo' || product.type == 'marco placa' || product.type == 'rejilla frontal' || product.type == 'cubierta stops traseros' || product.type == 'exploradoras' || product.type == 'barra de exploradoras' || product.type == 'tanques' || product.type == 'barra antivolco' || product.type == 'plumillas' || product.type == 'barra luces led' || product.type == 'bicicletero' || product.type == 'bicicletero de techo' || product.type == 'filtro de aire' || product.type == 'pijamas para vehiculos' || product.type == 'pitos' || product.type == 'reflejo logo' || product.type == 'rines ciegos' || product.type == 'tapete maletero'"  style="width:50px;height:auto;" ng-src="admin/recursos/img/accesorios/{{product.type}}-products/{{product.img}}.gif" alt="imagen de producto">
			                                <img ng-if="product.type != 'kit completo' && product.type != 'marco placa' && product.type != 'rejilla frontal' && product.type != 'cubierta stops traseros' && product.type != 'exploradoras' && product.type != 'barra de exploradoras' && product.type != 'tanques' && product.type != 'barra antivolco' && product.type != 'plumillas' && product.type != 'barra luces led' && product.type != 'bicicletero' && product.type != 'bicicletero de techo' && product.type != 'filtro de aire' && product.type != 'pijamas para vehiculos' && product.type != 'pitos' && product.type != 'reflejo logo' && product.type != 'rines ciegos' && product.type != 'tapete maletero'" style="width:50px;height:auto;" ng-src="admin/recursos/img/{{product.type}}-products/{{product.img}}.gif" alt="imagen de producto">
			                            </td>
			                            <td ng-bind="product.name"></td>
			                            <td class="text-right" ng-bind="product.price | currency : '$' : 0"></td>
			                            <td>
			                            	<select name="quantity" ng-model="quantity" ng-init="quantity = product.cant" id="shop-cant" ng-change="recalculateTotals(key, 'newValue', quantity)" ng-options="item for item in quantityDropdownItems" class="form-control">
			                            	</select>
			                            </td>
			                            <td class="text-right" ng-bind="(product.price * product.cant) | currency : '$' : 0"></td>
                                        <!-- <td>
                                            <input type="checkbox" name="instalation" ng-model="instalation" id="checkout-instalation">
                                        </td> -->
                                        <td><i style="cursor: pointer;" ng-click="removeProduct( key )" class="fa fa-trash-o"></i></td>
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

                        <div class="row" ng-show="shoppingcart != undefined">
							<div class="col-xs-12 text-uppercase text-left" ng-show="!deliveryAndInstalation">
								<label>
									<input type="checkbox" name="delivery" ng-model="delivery" ng-checked="shoppingcart.shippingFree != undefined && shoppingcart.addDelivery" id="checkout-delivery">
									Envío
								</label>
							</div>
                            <!-- <div class="col-xs-12 text-uppercase text-left">
								<label>
									<input type="checkbox" name="delivery-and-instalation" ng-model="deliveryAndInstalation" ng-click="recalculateTotals( 0, 'addDeliveryAndinstalation' )" id="checkout-delivery-and-instalation">
									Envío e instalación
								</label>
							</div> -->
						</div>

                        <div class="alert alert-info bg-color4" ng-if="localDelivery && delivery">
			            	<i>El envío tiene un costo de : {{shoppingcart.shippingCharge}}</i>
                        </div>
			            <div class="alert alert-info bg-color4" ng-if="!localDelivery && delivery">
			            	<i>Los envíos a ciudades diferente de bogota son realizadas por la empresa ENCOEXPRESS con la siguiente tarifa contra-entrega</i>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Ciudad</th>
                                        <th>1 a 30 Kgs</th>
                                        <th>Seguro mínimo 1 %</th>
                                        <th>Frecuencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(key, value) in tableData">
                                        <td class="text-left" ng-bind="value.city"></td>
                                        <td ng-bind="value.priceWeigth"></td>
                                        <td ng-bind="value.priceSecure"></td>
                                        <td ng-bind="value.time"></td>
                                    </tr>
                                </tbody>
                            </table>
			            </div>

			            <div class="row">
	            			<div class="col-xs-12 text-right">
	            				<button ng-click="close()" class="btn bg-color3 c-blanco text-uppercase">Volver a la tienda</button>
	            			</div>
	            		</div>
	            		<hr class="visible-xs">
            		</div>
            		<div class="col-sm-5" ng-if="shoppingcart.addDelivery || shoppingcart.addDeliveryAndinstalation || delivery">
                        <form name="paymentForm" method="post" action="https://sandbox.gateway.payulatam.com/ppp-web-gateway">
                			<div class="registro-compra bg-color3 text-left">
                				<h3 class="text-uppercase">Datos de envío</h3>


                					<div class="form-group">
                						<label for="">Nombre:</label>
                						<input type="text" name="userName" ng-model="order.userName" ng-init="order.userName = '<?= $_SESSION['user_name']?>'" id="order-user-name" class="form-control" required>
                					</div>
                					<div class="form-group">
                						<label for="">E-Mail:</label>
                						<input type="text" name="email" ng-model="order.email" ng-init="order.email = '<?= $_SESSION['email']?>'" id="order-email" class="form-control" required>
                					</div>
                					<div class="form-group">
                						<label for="">Celular:</label>
                						<input type="text" name="" id="" class="form-control" required>
                					</div>
                                    <div class="form-group">
                						<label for="">Dirección de envío:</label>
                						<input type="text" name="" id="" class="form-control" required>
                					</div>
                                    <div class="form-group">
    									<select name="deliveryCity" ng-model="deliveryCity" id="deliveryCity" ng-change="recalculateTotals( 0, 'addDelivery', deliveryCity )" class="form-control">
    										<option disabled value="">Seleccione una ciudad</option>
                                            <option ng-value="ARMENIA">ARMENIA</option>
                                            <option ng-value="BARRANQUILLA">BARRANQUILLA</option>
                                            <option ng-value="BOGOTA">BOGOTA</option>
                                            <option ng-value="BUCARAMANGA">BUCARAMANGA</option>
                                            <option ng-value="CALI">CALI</option>
                                            <option ng-value="CHIA">CHIA</option>
                                            <option ng-value="CUCUTA">CUCUTA</option>
                                            <option ng-value="FACATATIVA">FACATATIVA</option>
                                            <option ng-value="FUNZA">FUNZA</option>
                                            <option ng-value="FUSAGASUGA">FUSAGASUGA</option>
                                            <option ng-value="IBAGUE">IBAGUE</option>
                                            <option ng-value="LA_MESA">LA MESA</option>
                                            <option ng-value="MADRID">MADRID</option>
                                            <option ng-value="MEDELLIN">MEDELLIN</option>
                                            <option ng-value="PASTO">PASTO</option>
                                            <option ng-value="ZIPAQUIRA">ZIPAQUIRÁ</option>
    									</select>
    								</div>
                					<div class="form-group">
                						<label for="">Teléfono fijo:</label>
                						<input type="text" name="" id="" class="form-control" required>
                					</div>
                                    <input name="merchantId"    type="hidden"  value="{{merchantId}}"   >
                                    <input name="accountId"     type="hidden"  value="{{accountId}}" >
                                    <input name="description"   type="hidden"  value="Test PAYU"  >
                                    <input name="referenceCode" type="hidden"  value="{{referenceCode}}" >
                                    <input name="amount"        type="hidden"  value="{{shoppingcart.total}}"   >
                                    <input name="tax"           type="hidden"  value="0"  >
                                    <input name="taxReturnBase" type="hidden"  value="0" >
                                    <input name="currency"      type="hidden"  value="COP" >
                                    <input name="signature"     type="hidden"  value="ba9ffa71559580175585e45ce70b6c37"  >
                                    <input name="test"          type="hidden"  value="1" >
                                    <input name="buyerEmail"    type="hidden"  value="test@test.com" >
                                    <input name="responseUrl"    type="hidden"  value="http://www.test.com/response" >
                                    <input name="confirmationUrl"    type="hidden"  value="http://www.test.com/confirmation" >

                			</div>
    						<br>
                			<div class="row">
    	            			<div class="col-xs-12 text-right">
                                    <button name="Submit" type="submit" value="Enviar" ng-disabled="(shoppingcart == undefined) || paymentForm.$invalid" class="btn bg-color2 c-blanco text-uppercase">Pagar</button>
    	            			</div>
    	            		</div>
                        </form>
            		</div>
            	</div>
            </div>
    	</div>
    </div>
</div>
