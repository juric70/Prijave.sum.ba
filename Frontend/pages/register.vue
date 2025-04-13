<script setup lang="ts">
import { reactive, onMounted } from "vue";
import axios from "axios";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import { Croatian } from "flatpickr/dist/l10n/hr.js";
import { useRouter } from "vue-router";

definePageMeta({
  middleware: ["sanctum:guest"],
});

axios.defaults.withCredentials = true;

const router = useRouter();

const floatedLabels = reactive<Record<string, boolean>>({});
const inputHeights = reactive<Record<string, string>>({});
const inputValues = reactive<Record<string, string>>({
  name: "",
  lastname: "",
  birth: "",
  email: "",
  password: "",
  submitPassword: "",
});
const errors = reactive<Record<string, string>>({
  general: "",
  birthInput: "",
  submitPassword: "",
});

const registrirajSe = async () => {
  // Reset errors
  errors.general = "";
  errors.birthInput = "";
  errors.submitPassword = "";

  const { name, lastname, birth, email, password, submitPassword } =
    inputValues;

  // Validate inputs
  if (!name || !lastname || !birth || !email || !password || !submitPassword) {
    errors.general = "Popunite sva polja!";
    return;
  }

  const localDatum = new Date();
  const unesenDatum = new Date(birth);

  if (password !== submitPassword) {
    errors.submitPassword = "Šifre se ne podudaraju";
    return;
  }

  if (localDatum.getTime() < unesenDatum.getTime()) {
    errors.birthInput = "Neispravan unos datuma!";
    return;
  }

  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/register", {
      email,
      name,
      lastname,
      password,
      datumRodjenja: birth,
    });
    router.push("/"); // Redirect to home page after successful registration
  } catch (error: any) {
    if (error.response?.status === 404) {
      errors.general = "Već ste ulogirani!";
      setTimeout(() => {
        router.push("/");
      }, 2000);
    } else if (error.response?.status === 422) {
      errors.general = error.response.data.message || "Došlo je do greške!";
    } else {
      errors.general = "Došlo je do greške pri registraciji!";
    }
  }
};

const floatLabel = (inputId: string) => {
  floatedLabels[inputId] = true;
  inputHeights[inputId] = "70px";
};

const resetHeight = (inputId: string) => {
  inputHeights[inputId] = "50px";
  if (!inputValues[inputId]) {
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

onMounted(() => {
  flatpickr("#birthInput", {
    dateFormat: "d.m.Y",
    allowInput: false,
    locale: Croatian,
  });
});

const fields = [
  {
    id: "name",
    name: "name",
    type: "text",
    label: "Ime",
    required: true,
    errorKey: "general",
  },
  {
    id: "lastname",
    name: "lastname",
    type: "text",
    label: "Prezime",
    required: true,
    errorKey: "general",
  },
  {
    id: "birth",
    name: "birth",
    type: "text",
    label: "Datum rođenja",
    required: true,
    errorKey: "birthInput",
  },
  {
    id: "email",
    name: "email",
    type: "text",
    label: "Mail",
    required: true,
    errorKey: "general",
  },
  {
    id: "password",
    name: "password",
    type: "password",
    label: "Lozinka",
    required: true,
    errorKey: "submitPassword",
  },
  {
    id: "submitPassword",
    name: "submitPassword",
    type: "password",
    label: "Ponovi lozinku",
    required: true,
    errorKey: "submitPassword",
  },
];
</script>

<template>
  <div id="allWrapper">
    <div class="text1">DOBRODOŠLI!</div>
    <div class="text2">PRIJAVE</div>
    <div class="square">
      <div class="inputWrapper">
        <h3 class="title">Registriraj se</h3>
        <div
          class="inputContainer"
          v-for="field in fields"
          :key="field.id">
          <input
            :type="field.type"
            :id="field.id"
            :name="field.name"
            :required="field.required"
            :class="['inputField', { 'input-error': errors[field.errorKey] }]"
            :style="{ height: inputHeights[field.id] }"
            @focus="floatLabel(field.id)"
            @blur="resetHeight(field.id)"
            @input="handleInput(field.id, $event)"
            v-model="inputValues[field.id]" />
          <label
            :for="field.id"
            class="label"
            :class="{ floated: isFloated(field.id) }">
            {{ field.label }}
          </label>
          <p
            v-if="errors[field.errorKey]"
            class="error-msg">
            {{ errors[field.errorKey] }}
          </p>
        </div>
        <p
          v-if="errors.general"
          class="error-msg general-msg">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="#721c24"
            class="size-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
          </svg>
          {{ errors.general }}
        </p>
        <button
          type="button"
          class="submitButton"
          @click="registrirajSe">
          Registriraj se
        </button>
        <div class="text3">
          Već imate račun?
          <NuxtLink
            to="/login"
            id="link"
            >Prijavite se</NuxtLink
          >
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
.submitButton {
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
  color: white;
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
