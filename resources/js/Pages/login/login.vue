<template>
<div class="container" :class="{'right-panel-active':signInLogin}" id="container">
	<div class="form-container sign-up-container">
		<form @submit.prevent="criarConta">
			<h1>Criar Conta</h1>
			<div class="social-container">
				<a href="#" class="social"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                    </svg>
                </a>
				<a href="#" class="social">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                    <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                    </svg>
                </a>
				<a href="#" class="social">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                    </svg>
                </a>
			</div>
			<span>Ou use seu email para se registrar</span>
			<input type="text" placeholder="Nome" v-model="nome"/>
            <p style="color: red;margin:0; font-size: x-small;" v-if="invalidName">Nome inválido</p>
			<input type="email" placeholder="Email" v-model="email"  @invalid="invalidEmail = true" @input="invalidEmail = false"/>
            <p style="color: red;margin:0; font-size: x-small;" v-if="invalidEmail">email invalido</p>
			<input type="password" placeholder="Senha" v-model="password"/>
            <p style="color: red;margin:0; font-size: x-small;" v-if="invalidPassword">Senha deve possuir no mínimo 6 carateres</p>
			<button>Criar conta</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form @submit.prevent="login">
			<h1>Entrar</h1>
			<div class="social-container">
				<a href="#" class="social"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
					<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
				</svg>
			</a>
			<a href="#" class="social">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
					<path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
				</svg>
			</a>
			<a href="#" class="social">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
					<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
				</svg>
			</a>
		</div>
		<span>Ou use email e senha</span>
		<input type="email" placeholder="Email" v-model="email"  @invalid="invalidEmail = true" @input="invalidEmail = false"/>
			<p style="color: red;margin:0; font-size: x-small;" v-if="invalidEmail">email invalido</p>
		<div class="password-container">
			<input :type="inputType" placeholder="Senha" v-model="password"/>
			<button @click="changeInputType" type="button" class="password-toggle">
				<svg  v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
					<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
					<path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
				</svg>
				<svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
					<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
					<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
				</svg>
			</button>
		</div>
			<p style="color: red;margin:0; font-size: x-small;" v-if="invalidPassword">Senha deve possui no mínimo 6 carateres</p>
		<a href="#">Esqueceu a senha?</a>
		<button >Entrar</button>
			<p style="color: red;margin:0; font-size: x-small;" v-if="InvalidCredentials">Email e/ou senha invalido</p>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Já possui conta ?</h1>
				<p>Pressione abaixo para realizar o login na sua conta</p>
				<button class="ghost" id="signIn" @click="loginmethod">Logar</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Não possui conta ?</h1>
				<p>Clique abaixo para criar sua conta</p>
				<button class="ghost" id="signUp" @click="loginmethod">Criar Conta</button>
			</div>
		</div>
	</div>
</div>
  </template>
<script>
import axios from "axios";
import { router } from '@inertiajs/vue3';

export default {

    data() {
        return {
            signInLogin: true,
            email: "",
            password: "",
            errorMessage: "",
            nome: "",
			showPassword: false,
            invalidName: false,
            invalidEmail: false,
            invalidPassword: false,
			InvalidCredentials: false,
        };
    },
    methods: {
        handleInvalidEmail(){
            this.invalidEmail = true
        },

		changeInputType(){
			this.showPassword = !this.showPassword
		},
        validaDados(){
            let invalido = false

            this.invalidName = false
            this.invalidPassword = false

            if(this.nome.length <= 3)
            {
                this.invalidName = true
                invalido = true
            }
            if(this.password.length < 6)
            {
                this.invalidPassword = true
                invalido = true
            }
            
            return invalido
        },
        loginmethod(){
            this.signInLogin = !this.signInLogin
            this.email = "",
            this.password = "",
            this.nome = "",
            this.errorMessage = ""
            this.invalidEmail = false,
			this.InvalidCredentials = false
            this.invalidName = false
            this.invalidPassword = false
        },
        async criarConta(){
            
            if(this.validaDados())
                return 0
            
            try {
                await axios.get('/sanctum/csrf-cookie'); // Get CSRF token
                const response = await axios.post("/register", {
                    email: this.email,
                    password: this.password,
                    name: this.nome
                });
                router.visit('/pedidos');
                
            } catch (error) {
                this.errorMessage = "Invalid credentials";
            }
        },
        async login() {
			this.InvalidCredentials = false
            if(this.password.length < 6)
            {
                this.invalidPassword = true
                return
            }
            
            try {
                await axios.get('/sanctum/csrf-cookie'); // Get CSRF token
                const response = await axios.post("/login", {
                    email: this.email,
                    password: this.password
                });
                
                router.visit('/pedidos');
            } catch (error) {
                this.InvalidCredentials = true
				this.errorMessage = "Invalid credentials";
            }
        },
        async handleGoogleLogin() {
            try {
                // Get the Google OAuth URL from backend
                const response = await axios.get('/api/auth/google');
                window.location.href = response.data.url;
            } catch (error) {
                console.error('Google login error:', error);
            }
            },

        async handleCallback(code) {
        try {
            const response = await axios.get(`/api/auth/google/callback?code=${code}`);
            if (response.data.token) {
            // Store the token in localStorage or Vuex
            localStorage.setItem('auth_token', response.data.token);
            // Redirect to dashboard or home page
            this.$router.push('/dashboard');
            }
        } catch (error) {
            console.error('Callback error:', error);
        }
        }
    },
	computed: {
		inputType()
		{
			return this.showPassword ? 'password': 'text';
		}
	}
};
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
	box-sizing: border-box;
}

body {
	background: #f6f5f7;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	height: 100vh;
	margin: -20px 0 50px;
}

h1 {
	font-weight: bold;
	margin: 0;
}

h2 {
	text-align: center;
}

p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
}

span {
	font-size: 12px;
}

a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

button {
	border-radius: 20px;
	border: 1px solid #d1e1fc;
	background-color: #717f99;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
}

button:active {
	transform: scale(0.95);
}

button:focus {
	outline: none;
}

button.ghost {
	background-color: transparent;
	border-color: #FFFFFF;
}

form {
	background-color: #FFFFFF;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 50px;
	height: 100%;
	text-align: center;
}

input {
	background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
}

.container {
	background-color: #fff;
	border-radius: 10px;
  	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
			0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
	width: 768px;
	max-width: 100%;
	min-height: 480px;
}

.form-container {
	position: absolute;
	top: 0;
	height: 100%;
	transition: all 0.6s ease-in-out;
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}

.container.right-panel-active .sign-in-container {
	transform: translateX(100%);
}

.sign-up-container {
	left: 0;
	width: 50%;
	opacity: 0;
	z-index: 1;
}

.container.right-panel-active .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.6s;
}

@keyframes show {
	0%, 49.99% {
		opacity: 0;
		z-index: 1;
	}
	
	50%, 100% {
		opacity: 1;
		z-index: 5;
	}
}

.overlay-container {
	position: absolute;
	top: 0;
	left: 50%;
	width: 50%;
	height: 100%;
	overflow: hidden;
	transition: transform 0.6s ease-in-out;
	z-index: 100;
}

.container.right-panel-active .overlay-container{
	transform: translateX(-100%);
}

.overlay {
	background: #FF416C;
	background: -webkit-linear-gradient(to right, #7f7bb7, #899bd4);
	background: linear-gradient(to right, #7f7bb7, #899bd4);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: 0 0;
	color: #FFFFFF;
	position: relative;
	left: -100%;
	height: 100%;
	width: 200%;
  	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  	transform: translateX(50%);
}

.overlay-panel {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 40px;
	text-align: center;
	top: 0;
	height: 100%;
	width: 50%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.overlay-left {
	transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
	transform: translateX(0);
}

.overlay-right {
	right: 0;
	transform: translateX(0);
}

.container.right-panel-active .overlay-right {
	transform: translateX(20%);
}

.social-container {
	margin: 20px 0;
}

.social-container a {
	border: 1px solid #DDDDDD;
	border-radius: 50%;
	display: inline-flex;
	justify-content: center;
	align-items: center;
	margin: 0 5px;
	height: 40px;
	width: 40px;
}

footer {
    background-color: #222;
    color: #fff;
    font-size: 14px;
    bottom: 0;
    position: fixed;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 999;
}

footer p {
    margin: 10px 0;
}

footer i {
    color: red;
}

footer a {
    color: #3c97bf;
    text-decoration: none;
}

@media(max-width: 758px)
{
    input{
        font-size: small;
    }
}

.password-container {
  	position: relative;
	width: 100%;
}

.password-toggle {
  position: absolute;
  right: 5px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;

}

.password-container input {
  width: 100%; /* Ensure the input takes the full width of the container */
  padding-right: 40px; /* Add padding to the right to make space for the toggle button */
}

.password-toggle svg {
  color: #888; /* Icon color */
}

/* Styling to make the button part of the input visually */
.password-container::after {
  position: absolute;

 }
</style>
