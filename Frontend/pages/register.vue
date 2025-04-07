<script>
import axios from 'axios';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';
import { Croatian } from "flatpickr/dist/l10n/hr.js";
axios.defaults.withCredentials = true;

export default{
    mounted(){
      flatpickr("#birthInput", {
      dateFormat: "d.m.Y", 
      allowInput: false, 
      locale: Croatian 
    });
    },
    data() {
    return {
      floatedLabels: {},
      inputHeights: {},
      birth: null,
      inputValues: {},
      errors: {
        general: "",
      },
      
      }
  },
    methods: {
      async registrirajSe(){
    this.errors = {};
    const { name, lastname, birth, email, password, submitPassword } = this.inputValues;
    if (!name || !lastname || !birth || !email || !password || !submitPassword) {
      this.errors.general = "Popunite sva polja!";
      return;
   }
    let localDatum = new Date();
    let unesenDatum = new Date(document.getElementById("birthInput").value);
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    if(document.getElementById("password").value != document.getElementById("submitPassword").value){
      this.errors.submitPassword = "Šifre se ne podudaraju";  
      return;  
    }
    else if(localDatum.getTime() < unesenDatum.getTime()){
      this.errors.birthInput = "Neispravan unos datuma!";
      return;
    }
    else{
        try {
        await axios.post("http://localhost:8000/register", {
            email: document.getElementById("email").value,
            name: document.getElementById("nameInput").value,
            lastname: document.getElementById("lastnameInput").value,
            password: document.getElementById("password").value,
            datumRodjenja: document.getElementById("birthInput").value,
        }).then(res => {
          location.href = '/';
        });
        //let {data} = await axios.get("http://localhost:8000/api/user");
        }catch(error){
        if(error.response.status == 404){
          this.errors.general = "Već ste ulogirani!";
          setTimeout(() => {
           location.href = '/';
          }, 2000);
        }
        else if(error.response.status == 422){
          this.errors.general = error.response.data.message || "Došlo je do greške!";
        } else {
            this.errors.general = "Došlo je do greške pri registraciji!";
          }
        }
    }
    },

    floatLabel(inputId) {
      this.floatedLabels[inputId] = true
      this.inputHeights[inputId] = '70px'
    },
    resetHeight(inputId) {
      this.inputHeights[inputId] = '50px'
      if (!this.inputValues[inputId] || this.inputValues[inputId] === '') 
      this.floatedLabels[inputId] = false;
    },
    isFloated(inputId) {
      return this.floatedLabels[inputId]
    },
    handleInput(inputId, event) {
      this.inputValues[inputId] = event.target.value; // Sprema vrijednost unosa
      if (event.target.value) {
        this.floatedLabels[inputId] = true; // Ako je unesena vrijednost, labela ostaje gore
      }
    }
}
}


</script>

<template>
    <div class="text1"> DOBRODOŠLI!</div>
    <div class="text2"> PRIJAVE</div>
    <div class="square">
        <div class="inputWrapper">
            <h3 class="title">Registriraj se</h3>
            <div class="inputContainer">
                <input type="text" id="nameInput" name="name" 
                required 
                class="inputField" 
                :style="{ height: inputHeights.name }" 
                @focus="floatLabel('name')" 
                @blur="resetHeight('name')" 
                @input="handleInput('name', $event)" 
                v-model="inputValues.name">
                <label for="nameInput" class="label" :class="{ floated: isFloated('name') }">Ime</label>  
            </div>
            <div class="inputContainer">
                <input type="text" id="lastnameInput" name="lastname" 
                required
                class="inputField" 
                :style="{ height: inputHeights.lastname }" 
                @focus="floatLabel('lastname')" 
                @blur="resetHeight('lastname')" 
                @input="handleInput('lastname', $event)" 
                v-model="inputValues.lastname">
                <label for="lastnameInput" class="label" :class="{ floated: isFloated('lastname') }">Prezime</label>  
            </div>
            <div class="inputContainer">
                <input type="text" id="birthInput" name ="birth"
                required                
                :class="{'inputField': true, 'input-error': errors.birthInput}" 
                :style="{ height: inputHeights.birth }" @focus="floatLabel('birth')"
                @blur="resetHeight('birth')" 
                @input="handleInput('birth', $event)" 
                v-model="inputValues.birth"/>
                <label for="birthInput" class="label" :class="{ floated: isFloated('birth'),  }">Datum rođenja</label> 
                <p v-if="errors.birthInput" class="error-msg">{{ errors.birthInput }}</p>
              </div>
            <div class="inputContainer">
                <input type="text" id="email" name="email" 
                required class="inputField" 
                :style="{ height: inputHeights.email }"
                :class="{'inputField': true, 'input-error': errors.email}" 
                @focus="floatLabel('email')" 
                @blur="resetHeight('email')" 
                @input="handleInput('email', $event)" 
                v-model="inputValues.email">
                <label for="email" class="label" :class="{ floated: isFloated('email') }">Mail</label>  
                <p v-if="errors.email" class="error-msg">{{ errors.email }}</p>
            </div>
            <div class="inputContainer">
                <input type="password" id="password" name="password" 
                required 
                :class="{'inputField': true, 'input-error': errors.submitPassword}" 
                :style="{ height: inputHeights.password }" 
                @focus="floatLabel('password')" 
                @blur="resetHeight('password')" 
                @input="handleInput('password', $event)" 
                v-model="inputValues.password">
                 <label for="password" class="label" :class="{ floated: isFloated('password') }">Lozinka</label> 
            </div>
            <div class="inputContainer">
                <input type="password" id="submitPassword" name="submitPassword" 
                required :class="{'inputField': true, 'input-error': errors.submitPassword}" 
                :style="{ height: inputHeights.submitPassword }" 
                @focus="floatLabel('submitPassword')" 
                @blur="resetHeight('submitPassword')" 
                @input="handleInput('submitPassword', $event)" 
                v-model="inputValues.submitPassword">
                <label for="submitPassword" class="label" :class="{ floated: isFloated('submitPassword') }">Ponovi lozinku</label> 
                <p v-if="errors.submitPassword" class="error-msg">{{ errors.submitPassword }}</p> 
            </div>
            <p v-if="errors.general" class="error-msg general-msg">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#721c24" class="size-6" >
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
              </svg>
              {{ errors.general }}</p>
            <button type="button" class="submitButton" @click="registrirajSe">Registriraj se</button>
            <div class="text3">Već imate račun?
                <NuxtLink to="/login" id="link">Prijavite se</NuxtLink>
            </div>
        </div>
    </div>
    <div>
        <Footer/>
    </div>
</template>

<style scoped>
.square{
    background-color:#FFFFFF2E;
    width: 450px;
    height: 750px;
    align-self: center;
    justify-self: center;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center; 
    justify-content: center; 
}
.inputWrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.inputContainer {
  position: relative;
  margin-bottom: 20px;
  width: 300px;
}
.inputField {
  font-family: Inter;
  font-weight: 500;
  font-size: 18px;
  line-height: 100%;
  letter-spacing: 5%;
  color: black;
  width: 100%;
  height: 50px;
  border-radius: 10px; 
  padding-top: 10px;
  padding-left: 10px;
  padding-right: 10px;
}
.title {
    color: #FFFFFF;
    text-align: center;
    margin-bottom: 60px;
    font-family: Inter;
    font-weight: 700;
    font-size: 29px;
    line-height: 100%;
    letter-spacing: 5%;
}

.label {
    transition: all 0.3s ease;
    position: absolute;
    top: 10px;
    left: 10px;
    color:#094776;
    font-family: Inter;
    font-weight: 400;
    font-size: 16px;
    line-height: 100%;
    letter-spacing: 5%;
    padding-top: 7px;

}
.label.floated {
  top: 0px;
  color: #094776;
  font-family: Inter;
  font-weight: 400;
  font-size: 12px;
  line-height: 100%;
  letter-spacing: 5%;

}
.submitButton {
  background-color:#D22D3A;
  border: none;
  border-radius: 10px;
  width: 300px;
  height: 50px;
  cursor: pointer;
  color: white;
  text-align: center;
  margin-bottom: 20px;
}
.text1{
  font-family: Inter;
  font-weight: 400;
  font-size: 40px;
  line-height: 100%;
  letter-spacing: 5%;
  text-align: center;
  margin-top:10px;

}
.text2{
  font-family: Inter;
  font-weight: 900;
  font-size: 80px;
  line-height: 100%;
  letter-spacing: 5%;
  text-align: center;
  margin-bottom: 60px;

}
.text3 {
    font-size: 10px;
    color: white;
    font-family: Inter;
    font-weight: 400;
    font-size: 16px;
    line-height: 100%;
    letter-spacing: 5%;
    text-align: center;
}

#link {
  color:white;
  text-decoration: underline;
}
.input-error {
  border: 2px solid #721c24;
  background-color: #f8d7da;
}

.error-msg {
  color: #f8d7da;
  font-size: 16px;
  margin-top: 5px;
}
.general-msg {
  background-color: #f8d7da; 
  color: #721c24;   
  border: #721c24 2px solid;            
  padding: 12px 20px;
  margin-bottom: 20px;
  width: 300px;                
  text-align: center;
  font-size: 16px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: Inter;
  font-weight: 400;
  line-height: 100%;
  letter-spacing: 5%;
}

.size-6 {
  width: 1.5rem;
  height: 1.5rem;
  flex-shrink: 0; 
}

</style>