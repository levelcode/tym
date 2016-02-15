<!-- modal -->
<div id="modal-ingreso-registro" class="st-modal modal-tym" ng-controller="LoginSignUpCtrl" ng-cloak>
    <div class="contenido">
		<span class="cerrar"><i class="fa fa-remove"></i></span>
		<div class="cont">
            <div class="titulo">
                <h1>Ingreso</h1>
            </div>
            <div class="formularios text-left">
        		<div id="formulario-ingreso">
	                <form name="loginForm">
	                    <h3 class="txt-40 text-uppercase c-color3 text-center">Ingreso</h3>

						<div class="form-group">
							<label for="user" class="c-blanco">Usuario</label>
							<input type="text" name="user" ng-model="login.user" id="login-user" class="form-control" ng-maxLength="128" required>
                            <!-- tooltip -->
                            <div ng-if="loginForm.user.$invalid && loginForm.user.$dirty">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="loginForm.user.$error.required && loginForm.user.$dirty">Tu nombre de usuario es obligatorio!</span>
                                    <span ng-if="loginForm.user.$error.maxlength && loginForm.user.$dirty">Es demaciado extenso!</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group">
							<label for="password" class="c-blanco">Password</label>
							<input type="password" name="password" ng-model="login.password" id="login-password" class="form-control" ng-maxLength="68" ng-minLength="passwordMinLengthData" required>
                            <!-- tooltip -->
                            <div ng-if="loginForm.password.$invalid && loginForm.password.$dirty">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="loginForm.password.$error.required && loginForm.password.$dirty">Tu contraseña es obligatoria!</span>
                                    <span ng-if="loginForm.password.$error.maxlength && loginForm.password.$dirty">Es demaciado extensa!</span>
                                    <span ng-if="loginForm.password.$error.minlength && loginForm.password.$dirty" ng-bind="'Debe contener mínimo ' + passwordMinLengthData + ' digitos'"></span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="row">
							<div class="col-xs-6">
								<label>
									<input type="checkbox" name="" id="">
									Recordar contraseña
								</label>
							</div>
							<div class="col-xs-6 text-right">
								<a href="#">¿Has olvidado la contraseña?</a>
							</div>
						</div>
						<br>
						<div class="form-group text-center">
							<button type="button" ng-disabled="loginForm.$invalid" ng-click="doLogin( login )" class="bg-color3 btn c-blanco txt-18"><i ng-if="sendingData" class="fa fa-circle-o-notch fa-spin"></i>&nbsp;{{buttonLoginText}}</button>
                            <!-- tooltip -->
                            <div ng-if="showLoginError">
                                <div class="farma-tooltip-error">
                                    <span>Datos incorrectos!</span>
                                </div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <a href="" id="registro-tym" class="c-color3">Registrarme en TYM</a>
                            </div>
                        </div>
	                </form>
	            </div>

                <div id="formulario-registro">
                	<form name="signUpForm" novalidate>
                        <i class="fa fa-arrow-left" id="btn-atras-ingreso"></i>

                		<h3 class="txt-40 text-uppercase c-color3 text-center">Registro</h3>

                		<div class="form-group">
							<label for="username" class="c-blanco">Nombre de usuario</label>
							<input type="text" name="username" ng-model="signUp.username" id="sign-up-username" class="form-control" ng-maxLength="128" required>
                            <!-- tooltip -->
                            <div ng-if="signUpForm.username.$invalid && (signUpForm.username.$dirty || signUpForm.$submitted)">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="signUpForm.username.$error.required && (signUpForm.username.$dirty || signUpForm.$submitted)">Tu nombre de usuario es obligatorio!</span>
                                    <span ng-if="signUpForm.username.$error.maxlength && signUpForm.username.$dirty">Es demaciado extenso!</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group">
							<label for="email" class="c-blanco">Email</label>
							<input type="email" name="email" ng-model="signUp.email" id="sign-up-email" class="form-control" ng-maxLength="128" ng-pattern="/[\w.]+?\@{1}[\w.]+(\.+[\w.]+)/" required>
                            <!-- tooltip -->
                            <div ng-if="signUpForm.email.$invalid && (signUpForm.email.$dirty || signUpForm.$submitted)">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="signUpForm.email.$error.required && (signUpForm.email.$dirty || signUpForm.$submitted)">Tu correo electrónico es obligatorio!</span>
                                    <span ng-if="(signUpForm.email.$error.maxlength && signUpForm.email.$dirty) && !(signUpForm.email.$error.pattern || signUpForm.email.$error.email)">Es demaciado extenso!</span>
                                    <span ng-if="signUpForm.email.$error.pattern || signUpForm.email.$error.email">Por favor ingresa un correo electrónico válido!</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group" ng-if="signUpForm.email.$valid" >
							<label for="emailConfirmation" class="c-blanco">Escribe nuevamente el email</label>
							<input type="email" name="emailConfirmation" ng-model="signUp.emailConfirmation" ng-change="isEqual( signUp.emailConfirmation, 'e' )" id="sign-up-email-confirmation" class="form-control" ng-maxLength="128" ng-pattern="/[\w.]+?\@{1}[\w.]+(\.+[\w.]+)/" required>
                            <!-- tooltip -->
                            <div ng-if="(signUpForm.emailConfirmation.$invalid && signUpForm.emailConfirmation.$dirty) || ( signUpForm.emailConfirmation.$dirty && !emailComparation )">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="signUpForm.emailConfirmation.$error.required && signUpForm.emailConfirmation.$dirty">Tu correo electrónico es obligatorio!</span>
                                    <span ng-if="(signUpForm.emailConfirmation.$error.maxlength && signUpForm.emailConfirmation.$dirty) && !(signUpForm.emailConfirmation.$error.pattern || signUpForm.emailConfirmation.$error.emailConfirmation)">Es demaciado extenso!</span>
                                    <span ng-if="signUpForm.emailConfirmation.$error.pattern || signUpForm.emailConfirmation.$error.email">Por favor ingresa un correo electrónico válido!</span>
                                    <span ng-if="!emailComparation && signUpForm.emailConfirmation.$dirty && !(signUpForm.emailConfirmation.$error.pattern || signUpForm.emailConfirmation.$error.emailConfirmation) && !signUpForm.emailConfirmation.$error.required">Los correos electrónicos no coinciden.</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group">
							<label for="password" class="c-blanco">Password</label>
							<input type="password" name="password" ng-model="signUp.password" id="sign-up-password" class="form-control" ng-maxLength="64" ng-minLength="passwordMinLengthData" required>
                            <!-- tooltip -->
                            <div ng-if="signUpForm.password.$invalid && (signUpForm.password.$dirty || signUpForm.$submitted)">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="signUpForm.password.$error.required && (signUpForm.password.$dirty || signUpForm.$submitted)">Tu contraseña es obligatoria!</span>
                                    <span ng-if="signUpForm.password.$error.maxlength && signUpForm.password.$dirty">Es demaciado extensa!</span>
                                    <span ng-if="signUpForm.password.$error.minlength && signUpForm.password.$dirty" ng-bind="'Debe contener mínimo' + passwordMinLengthData + ' digitos'"></span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group" ng-if="signUpForm.password.$valid">
							<label for="passwordConfirmation" class="c-blanco">Escribe nuevamente tu password</label>
							<input type="password" name="passwordConfirmation" ng-model="signUp.passwordConfirmation" ng-change="isEqual( signUp.passwordConfirmation, 'p' )" id="sign-up-password-confirmation" class="form-control" ng-maxLength="64" ng-minLength="6" required>
                            <!-- tooltip -->
                            <div ng-if="( signUpForm.passwordConfirmation.$invalid && signUpForm.passwordConfirmation.$dirty ) || ( !passwordComparation && signUpForm.passwordConfirmation.$dirty )">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span ng-if="signUpForm.passwordConfirmation.$error.required && signUpForm.passwordConfirmation.$dirty">Confirmar tu contraseña es obligatorio!</span>
                                    <span ng-if="signUpForm.passwordConfirmation.$error.maxlength && signUpForm.passwordConfirmation.$dirty">Es demaciado extensa!</span>
                                    <span ng-if="signUpForm.passwordConfirmation.$error.minlength && signUpForm.passwordConfirmation.$dirty" ng-bind="'Debe contener mínimo' + passwordMinLengthData + ' digitos'"></span>
                                    <span ng-if="!passwordComparation && signUpForm.passwordConfirmation.$dirty && !signUpForm.passwordConfirmation.$error.maxlength && !signUpForm.passwordConfirmation.$error.minlength && !signUpForm.passwordConfirmation.$error.required">Los correos electrónicos no coinciden.</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group">
							<label for="birthDay" class="c-blanco">Fecha de naciemiento</label>
							<div class="row">
								<div class="col-xs-4">
									<select name="birthDay" ng-model="signUp.birth.day" id="sign-up-birth-day" ng-options="day as day.value for day in days track by day.value" class="form-control" required>
										<option selected disabled value="">Día</option>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="birthMonth" ng-model="signUp.birth.month" id="sign-up-birth-month" ng-options="month as month.label for month in months track by month.id" class="form-control" required>
										<option selected disabled value="">Mes</option>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="birthYear" ng-model="signUp.birth.year" id="sign-up-birth-month" ng-options="year as year.value for year in years track by year.value" class="form-control" required>
										<option selected disabled value="">Año</option>
									</select>
								</div>
							</div>
                            <!-- tooltip -->
                            <div ng-if="( signUpForm.birthDay.$invalid || signUpForm.birthMonth.$invalid || signUpForm.birthYear.$invalid ) && signUpForm.$submitted">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span>Completa tu fecha de nacimiento!</span>
                                </div>
                            </div>
                            <!-- tooltip -->
                        </div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
                                    <select name="gender" ng-model="signUp.gender" id="sign-up-gender" class="form-control" required>
										<option selected disabled value="">Genero</option>
										<option value="M">Masculino</option>
										<option value="F">Femenino</option>
									</select>
                                    <!-- tooltip -->
                                    <div ng-if="signUpForm.gender.$invalid && signUpForm.$submitted">
                                        <div class="arrow-up-error">
                                        </div>
                                        <div class="farma-tooltip-error">
                                            <span>Seleciona un genero!</span>
                                        </div>
                                    </div>
                                    <!-- tooltip -->
								</div>
							</div>
						</div>

						<div class="form-group">
							<label>
								<span class="c-blanco">
									<input type="checkbox" name="acceptTermAndCond" ng-model="signUp.termAndCond" id="sign-up-term-and-cond" required>
									He leído los <a href="#">términos de servicio</a> de TYM</span>
							</label>
                            <!-- tooltip -->
                            <div ng-if="signUpForm.acceptTermAndCond.$invalid && signUpForm.$submitted">
                                <div class="arrow-up-error">
                                </div>
                                <div class="farma-tooltip-error">
                                    <span>Acepta los términos y condiciones!</span>
                                </div>
                            </div>
                            <!-- tooltip -->
						</div>

						<div class="form-group text-center">
							<button type="submit" ng-click="doSignup( signUp )" ng-disabled="sendingData || signUpForm.$invalid" class="bg-color3 btn c-blanco txt-18"><i ng-if="sendingData" class="fa fa-circle-o-notch fa-spin"></i>&nbsp;{{buttonSignupText}}</button>
						</div>
                	</form>
                </div>

        	</div>
    	</div>
    </div>
</div>
