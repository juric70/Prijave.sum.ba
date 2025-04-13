<script setup lang="ts">
import axios from "axios";
import { FetchError } from "ofetch";

definePageMeta({
  middleware: ["sanctum:guest"],
});

axios.defaults.withCredentials = true;

const { login } = useSanctumAuth();

const floatedLabels = reactive<Record<string, boolean>>({});
const inputHeights = reactive<Record<string, string>>({});
const inputValues = reactive<Record<string, string>>({});
const errorMessage = ref("");

const prijaviSe = async () => {
  const credentials = {
    email: inputValues.email ?? "",
    password: inputValues.password ?? "",
    remember: true,
  };

  try {
    await login(credentials);
    // Klijent ce se automatski redirect-ati na stranicu na kojoj je bio prije prijave (funkcia next-auth-sanctum paketa)
  } catch (error) {
    console.error(error);

    if (error instanceof FetchError) {
      if (error.response?.status === 422) {
        errorMessage.value = "Niste dobro unijeli podatke!";
      } else if (error.response?.status === 404) {
        errorMessage.value = "Već ste ulogirani!";
      } else {
        errorMessage.value = "Došlo je do greške. Pokušajte ponovo.";
      }
    }

    inputValues.password = ""; // Clear the password field
  }
};

const floatLabel = (inputId: string) => {
  floatedLabels[inputId] = true;
  inputHeights[inputId] = "70px";
};

const resetHeight = (inputId: string) => {
  inputHeights[inputId] = "50px";
  if (!inputValues[inputId] || inputValues[inputId] === "") {
    floatedLabels[inputId] = false;
  }
};

const isFloated = (inputId: string) => {
  return floatedLabels[inputId];
};

const handleInput = (inputId: string, event: Event) => {
  const target = event.target as HTMLInputElement;
  inputValues[inputId] = target.value;
  if (target.value) {
    floatedLabels[inputId] = true;
  }
};
</script>

<template>
  <div id="allWrapper">
    <div class="text1">DOBRODOŠLI!</div>
    <div class="text2">PRIJAVE</div>
    <div class="square">
      <div class="inputWrapper">
        <h3 class="title">Prijavi se</h3>
        <div class="container">
          <input
            type="text"
            id="email"
            name="email"
            required
            class="inputField"
            :style="{ height: inputHeights.email }"
            @focus="floatLabel('email')"
            @blur="resetHeight('email')"
            @input="handleInput('email', $event)"
            v-model="inputValues.email" />
          <label
            for="email"
            class="label"
            :class="{ floated: isFloated('email') }"
            >Mail</label
          >
        </div>
        <div class="container">
          <input
            type="password"
            id="password"
            name="password"
            required
            class="inputField"
            :style="{ height: inputHeights.password }"
            @focus="floatLabel('password')"
            @blur="resetHeight('password')"
            @input="handleInput('password', $event)"
            v-model="inputValues.password" />
          <label
            for="password"
            class="label"
            :class="{ floated: isFloated('password') }"
            >Lozinka</label
          >
        </div>
        <p
          v-if="errorMessage"
          class="error-message">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
          </svg>
          {{ errorMessage }}
        </p>
        <button
          type="button"
          class="loginButton"
          @click="prijaviSe">
          Prijavi se
        </button>

        <div class="container">
          <button
            type="submit"
            class="eduButtonLeft">
            <img
              src="@/assets/icons/eduid.png"
              alt="EduId"
              class="icon" />
            <NuxtLink
              to="https://aai.sum.ba/sso/module.php/core/loginuserpass.php?AuthState=_a843172e772ea3620d057673cf235745ab869f963c%3Ahttps%3A%2F%2Faai.sum.ba%2Fsso%2Fsaml2%2Fidp%2FSSOService.php%3Fspentityid%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fsimplesaml%252Fmodule.php%252Fsaml%252Fsp%252Fmetadata.php%252Fmoodle-sum-sp%26RelayState%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fmoodle%252Fauth%252Fsimplesaml%252Findex.php%253Flast_page%253D%26cookieTime%3D1734347783"
              id="eduLink"></NuxtLink>
          </button>
          <button
            type="submit"
            class="eduButtonRight">
            <NuxtLink
              to="https://aai.sum.ba/sso/module.php/core/loginuserpass.php?AuthState=_a843172e772ea3620d057673cf235745ab869f963c%3Ahttps%3A%2F%2Faai.sum.ba%2Fsso%2Fsaml2%2Fidp%2FSSOService.php%3Fspentityid%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fsimplesaml%252Fmodule.php%252Fsaml%252Fsp%252Fmetadata.php%252Fmoodle-sum-sp%26RelayState%3Dhttps%253A%252F%252Feucenje.sum.ba%252Fmoodle%252Fauth%252Fsimplesaml%252Findex.php%253Flast_page%253D%26cookieTime%3D1734347783"
              id="eduLink"
              >Prijava putem eduID</NuxtLink
            >
          </button>
        </div>
        <div>
          <div class="text3">
            Nemate račun?
            <NuxtLink
              to="/register"
              id="link"
              style="text-decoration: underline"
              >Registrirajte se</NuxtLink
            >
          </div>
          <div class="text3">
            <NuxtLink
              to="/register"
              id="link"
              >Zaboravili ste lozinku?</NuxtLink
            >
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <Footer />
  </div>
</template>

<style scoped>
#allWrapper {
  display: flex;
  flex-direction: column;
}
.square {
  background-color: #ffffff2e;
  width: 450px;
  height: 600px;
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
.inputField {
  font-family: Inter;
  font-weight: 500;
  font-size: 18px;
  line-height: 100%;
  letter-spacing: 5%;
  color: black;
  width: 300px;
  height: 50px;
  border-radius: 10px;
  padding-left: 10px;
  padding-top: 20px;
}
.container {
  position: relative;
  margin-bottom: 20px;
  display: flex;
}
.title {
  color: #ffffff;
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
  color: #094776;
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
.loginButton {
  background-color: #d22d3a;
  border: none;
  border-radius: 10px;
  width: 300px;
  height: 50px;
  cursor: pointer;
  color: white;
  text-align: center;
  margin-bottom: 20px;
}
.eduButtonLeft {
  background-color: #004379;
  border: none;
  border-radius: 10px 0px 0px 10px;
  width: 80px;
  height: 55px;
  cursor: pointer;
  color: white;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
}
.eduButtonRight {
  background-color: #2196f3;
  border: none;
  border-radius: 0px 10px 10px 0px;
  width: 220px;
  height: 55px;
  cursor: pointer;
  color: white;
  font-size: 10px;
  left: 50px;
  text-align: left;
  padding-left: 10px;
}
.icon {
  width: 50px;
  height: 30px;
}
.text1 {
  font-family: Inter;
  font-weight: 400;
  font-size: 40px;
  line-height: 100%;
  letter-spacing: 5%;
  text-align: center;
  margin-top: 10px;
}
.text2 {
  font-family: Inter;
  font-weight: 900;
  font-size: 80px;
  line-height: 100%;
  letter-spacing: 5%;
  text-align: center;
  margin-bottom: 60px;
}
.text3 {
  color: white;
  font-family: Inter;
  font-weight: 400;
  font-size: 16px;
  line-height: 100%;
  letter-spacing: 5%;
  text-align: center;
  margin-bottom: 20px;
}

#link {
  color: white;
  text-decoration: none;
}
#eduLink {
  text-decoration: none;
  color: white;
  font-family: Roboto;
  font-weight: 400;
  font-size: 14px;
  line-height: 21px;
  letter-spacing: 0%;
  text-align: center;
  vertical-align: middle;
}
.error-message {
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
.error-message .icon {
  width: 20px;
  height: 20px;
  margin-right: 8px;
  fill: #721c24;
}
</style>
