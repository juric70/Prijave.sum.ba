<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default{
    mounted(){
    },
    data() {
    return {
      floatedLabels: {}
    }
  },
    methods: {
        async prijaviSe(){
            await axios.get("http://localhost:8000/sanctum/csrf-cookie");
            try {
                await axios.post("http://localhost:8000/login", {
                    email: document.getElementById("email").value,
                    password: document.getElementById("password").value,
                }).then(res => {
                    location.href = '/';
            });
        }catch(error){
            console.log(error);
            if(error.response.status == 422)alert("Niste dobro unijeli podatke!");
            else if(error.response.status == 404){
            alert("Već ste ulogirani!");
            navigateTo('/');
            }
            document.getElementById("password").value = "";
        }
    },
    floatLabel(inputId) {
      this.floatedLabels[inputId] = true
    },
    isFloated(inputId) {
      return this.floatedLabels[inputId]
    }
}
}

</script>

<template>
    <div class="square">
      <div class="inputWrapper">
        <h3 class="title">Prijavi se</h3>
        <input type="text" id="email" name="email" required class="inputField" @focus="floatLabel('email')">
        <div class="mailIcon">  <label for="email" class="label" :class="{ floated: isFloated('email') }">Mail</label>  </div>
        <input type="text" id="password" name="password" required @focus="floatLabel('password')">
        <div class="passwdIcon">  <label for="password" class="label" :class="{ floated: isFloated('password') }">Lozinka</label>  </div>
        <button type="button" class="loginButton" @click="prijaviSe">Prijavi se</button>
        <button type="submit" class="eduButtonLeft">
            <NuxtLink to="https://aai.sum.ba/sso/module.php/core/loginuserpass.php?AuthState=_a843172e772ea3620d057673cf235745ab869f963c%3Ahttps%3A%2F%2Faai.sum.ba%2Fsso%2Fsaml2%2Fidp%2FSSOService.php%3Fspentityid%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fsimplesaml%252Fmodule.php%252Fsaml%252Fsp%252Fmetadata.php%252Fmoodle-sum-sp%26RelayState%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fmoodle%252Fauth%252Fsimplesaml%252Findex.php%253Flast_page%253D%26cookieTime%3D1734347783" id="eduLink"></NuxtLink>
        </button>
        <button type="submit" class="eduButtonRight">
            <NuxtLink to="https://aai.sum.ba/sso/module.php/core/loginuserpass.php?AuthState=_a843172e772ea3620d057673cf235745ab869f963c%3Ahttps%3A%2F%2Faai.sum.ba%2Fsso%2Fsaml2%2Fidp%2FSSOService.php%3Fspentityid%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fsimplesaml%252Fmodule.php%252Fsaml%252Fsp%252Fmetadata.php%252Fmoodle-sum-sp%26RelayState%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fmoodle%252Fauth%252Fsimplesaml%252Findex.php%253Flast_page%253D%26cookieTime%3D1734347783" id="eduLink">Prijava putem eduID</NuxtLink>
        </button>
        <div>
            <div class="text1">Nemate račun?</div>
            <div class="text2">
                <NuxtLink to="/register" id="link">Registrirajte se</NuxtLink>
            </div>
            <div class="text3">
                <NuxtLink to="/register" id="link">Zaboravili ste lozinku?</NuxtLink>
            </div>
        </div>
    </div>
    </div>
</template>

<style scoped>
.square{
    background-color: #eeeeee;
    width: 250px;
    height: 400px;
    position: absolute;
    align-self: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 12px;
}
.title {
    color: #205782;
    text-align: center;
    margin-top: 30px;
}
#email {
    width: 170px;
    height: 40px;
    position: absolute;
    top: 27%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
}
#password {
    width: 170px;
    height: 40px;
    position: absolute;
    top: 42%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
}
.mailIcon {
    width: 24px;
    height: 24px;
    position: absolute;
    top: 90px;
    left: 40px;
    color: #205782;
}
.passwdIcon {
    width: 24px;
    height: 24px;
    position: absolute;
    top: 150px;
    left: 40px;
    color: #205782;
}
.label {
    font-size: 12px;
  transition: all 0.3s ease;
  position: absolute;
  top: 10px;
  left: 10px;
}
.label.floated {
  top: 0px;
  left: 5px;
  font-size: 10px;
  color: #123456;
}
.loginButton {
  background-color: #205782;
  border: none;
  border-radius: 10px;
  width: 180px;
  height: 40px;
  cursor: pointer;
  position: absolute;
  top: 240px;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
}
.eduButtonLeft {
  background-color: #205782;
  border: none;
  border-radius: 10px 0px  0px 10px;
  width: 50px;
  height: 40px;
  cursor: pointer;
  position: absolute;
  top: 290px;
  left: 24%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
}
.eduButtonRight {
  background-color: #2196f3;
  border: none;
  border-radius: 0px 10px 10px 0px;
  width: 130px;
  height: 40px;
  cursor: pointer;
  position: absolute;
  top: 290px;
  left: 60%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
  font-size: 10px;
}
.text1 {
    position: absolute;
    top: 340px;
    left: 32%;
    transform: translate(-50%, -50%);
    font-size: 10px;
    color: black;
}
.text2 {
    position: absolute;
    top: 340px;
    left: 65%;
    transform: translate(-50%, -50%);
    font-size: 10px;
    color: #205782;
}
.text3 {
    position: absolute;
    top: 360px;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 10px;
    color: #205782;
}
#link {
  color:#205782;
  text-decoration: none;
}
#eduLink {
    text-decoration: none;
    color: white;
}
</style>