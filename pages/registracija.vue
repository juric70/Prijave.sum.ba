<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default{
    mounted(){
        this.registrirajSe();
    },
    data() {
    return {
      floatedLabels: {}
    }
  },
    methods: {
        registrirajSe(){
            try {
                axios.post("http://localhost:8000/registracija", {
                }).then(res => {
                navigateTo('/');
            });
        }catch(error){console.log(error);}
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
            <h3 class="title">Registriraj se</h3>
            <input type="text" id="nameInput" name="name" required class="inputField" @focus="floatLabel('name')">
            <NameIcon class="nameIcon">  <label for="name" class="label" :class="{ floated: isFloated('name') }">Ime</label>  </NameIcon>
            <input type="text" id="lastnameInput" name="lastname" required class="input-field" @focus="floatLabel('lastname')">
            <LastnameIcon class="lastnameIcon">  <label for="lastname" class="label" :class="{ floated: isFloated('lastname') }">Prezime</label>  </LastnameIcon>
            <input type="text" id="birthInput" name="birthInput" required class="input-field" @focus="floatLabel('birth')">
            <BirthIcon class="birthIcon">  <label for="birthIcon" class="label" :class="{ floated: isFloated('birth') }">Datum rođenja</label>  </BirthIcon>
            <input type="text" id="email" name="email" required class="inputField" @focus="floatLabel('email')">
            <MailIcon class="mailIcon">  <label for="email" class="label" :class="{ floated: isFloated('email') }">Mail</label>  </MailIcon>
            <input type="text" id="password" name="password" required @focus="floatLabel('password')">
            <PasswordIcon class="passwdIcon">  <label for="password" class="label" :class="{ floated: isFloated('password') }">Lozinka</label>  </PasswordIcon>
            <input type="text" id="submitPassword" name="submitPassword" required @focus="floatLabel('submitPassword')">
            <SubmitPasswordIcon class="submitPasswdIcon">  <label for="sumbitPassword" class="label" :class="{ floated: isFloated('submitPassword') }">Ponovi lozinku</label>  </SubmitPasswordIcon>
            <button type="submit" class="submitButton">Registriraj se</button>
            <div class="text1">Već imate račun?</div>
            <div class="text2">
                <NuxtLink to="/prijaviSe" id="link">Prijavite se</NuxtLink>
            </div>
        </div>
    </div>
</template>

<style scoped>
.square{
    background-color: #eeeeee;
    width: 250px;
    height: 550px;
    position: absolute;
    align-self: center;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 12px;
}
.title {
    color: #205782;
    text-align: center;
    margin-top: 30px;
}
#nameInput {
    width: 160px;
    height: 30px;
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
    padding-top: 10px;
    padding-left: 10px;
    font-size: 12px;
}
.nameIcon {
    width: 24px;
    height: 24px;
    position: absolute;
    top: 90px;
    left: 40px;
    color: #205782;
}
.lastnameIcon {
  width: 24px;
  height: 24px;
  position: absolute;
  top: 155px;
  left: 40px;
  transform: translateY(-50%);
  color: #205782;
}
#lastnameInput {
    width: 160px;
    height: 30px;
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
    padding-top: 10px;
    padding-left: 10px;
    font-size: 12px;
}
.birthIcon {
  width: 200px;
  height: 24px;
  position: absolute;
  top: 212px;
  left: 40px;
  transform: translateY(-50%);
  color: #205782;
}
#birthInput {
    width: 160px;
    height: 30px;
    position: absolute;
    top: 222px;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
    padding-top: 10px;
    padding-left: 10px;
    font-size: 12px;
}
#email {
    width: 170px;
    height: 40px;
    position: absolute;
    top: 280px;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
}
#password {
    width: 170px;
    height: 40px;
    position: absolute;
    top: 340px;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
}
.mailIcon {
    width: 24px;
    height: 24px;
    position: absolute;
    top: 260px;
    left: 40px;
    color: #205782;
}
.passwdIcon {
    width: 24px;
    height: 24px;
    position: absolute;
    top: 320px;
    left: 40px;
    color: #205782;
}
#submitPassword {
    width: 170px;
    height: 40px;
    position: absolute;
    top: 400px;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: #205782;
    border-radius: 10px; 
}
.submitPasswdIcon {
    width: 200px;
    height: 24px;
    position: absolute;
    top: 380px;
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
.submitButton {
  background-color: #205782;
  border: none;
  border-radius: 10px;
  width: 180px;
  height: 40px;
  cursor: pointer;
  position: absolute;
  top: 460px;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
}
.text1 {
    position: absolute;
    top: 90%;
    left: 35%;
    transform: translate(-50%, -50%);
    font-size: 10px;
    color: black;
}
.text2 {
    position: absolute;
    top: 90%;
    left: 65%;
    transform: translate(-50%, -50%);
    font-size: 10px;
    color: #205782;
}
#link {
  color:#205782;
  text-decoration: none;
}
</style>