<template>
  <div class="flex flex-col">
    <div class="mx-auto my-4 flex items-center gap-4">
      <button
        class="rounded-lg p-2 text-white transition-colors"
        :class="{
          'bg-[#D22D3A]': currentFilter === 'open',
          'bg-transparent hover:bg-[#D22D3A88]': currentFilter !== 'open',
        }"
        @click="currentFilter = 'open'">
        Otvorene
      </button>
      <button
        class="rounded-lg p-2 text-white transition-colors"
        :class="{
          'bg-[#D22D3A]': currentFilter === 'closer',
          'bg-transparent hover:bg-[#D22D3A88]': currentFilter !== 'closer',
        }"
        @click="currentFilter = 'closer'">
        Zatvorene
      </button>
      <button
        class="rounded-lg p-2 text-white transition-colors"
        :class="{
          'bg-[#D22D3A]': currentFilter === 'my',
          'bg-transparent hover:bg-[#D22D3A88]': currentFilter !== 'my',
        }"
        @click="currentFilter = 'my'">
        Moje
      </button>
    </div>

    <div
      class="mx-8 flex flex-col gap-8"
      v-if="radionice">
      <div
        class="flex rounded-lg bg-white py-8"
        v-for="radionica in radionice"
        :key="radionica.id">
        <div
          class="min-w-[100px] max-w-[150px] flex-1 rounded-br-md rounded-tr-md bg-gradient-to-b from-[#D22D3A] to-[#004371]"></div>
        <div
          class="mx-8 my-4 flex w-full flex-col gap-8 border-b-2 border-t-2 border-[#094776] pb-16 pt-4">
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Naziv radionice:</span>
            {{ radionica.NazivRadionice }}
          </span>
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Ime voditelja:</span>
            {{ radionica.VoditeljRadionice }}
          </span>
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Rok za prijavu:</span>
            {{ radionica.PrijaveDo }}
          </span>
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Datum pocetka:</span>
            {{ radionica.DatumPocetka }}
          </span>
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Datum zavrsetka:</span>
            {{ radionica.DatumZavrsetka }}
          </span>
          <span class="font-bold text-[#1E1E1E]">
            <span class="text-[#094776]">Opis:</span>
            {{ radionica.OpisRadionice }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import type Radionica from "~/lib/types/Radionica";
import type User from "~/lib/types/User";
axios.defaults.withCredentials = true;

export default {
  data(): {
    user: User | null;
    radionice: Radionica[] | null;
    currentFilter: "open" | "closer" | "my";
  } {
    return {
      currentFilter: "open",
      radionice: null,
      user: null,
    };
  },
  mounted() {
    this.getRadionice();
    this.getUserData();
  },

  methods: {
    async getUserData() {
      try {
        const userResponse = (await axios.get("http://localhost:8000/User/me"))
          .data as User;

        this.user = userResponse;
      } catch (error) {
        console.log(error);
      }
    },
    async getRadionice() {
      try {
        const radionice = (await axios.get("http://localhost:8000/Radionica"))
          .data as Radionica[];

        this.radionice = radionice.filter(radionica => {
          const datumZavrsetka = new Date(radionica.DatumZavrsetka);
          const trenutniDatum = new Date();
          if (datumZavrsetka < trenutniDatum) {
            return false;
          }

          return true;
        });
      } catch (error) {
        console.log(error);
      }
    },
    async prijavi(id: number) {
      navigateTo("/opisradionice?id=" + id);
    },
    async izbrisi(id: number) {
      if (confirm("Jeste li sigurni da želite izbrisati ovu radionicu?")) {
        try {
          // Dohvat svih prijava radionice
          const prijaveRadionice = (
            await axios.get("http://localhost:8000/SvePrijave/" + id)
          ).data as Record<string, any>[];

          // Brisanje svih prijava radionice
          for (const prijava of prijaveRadionice) {
            // Dohvat svakog pojedinog podatka prijave
            const podaciPrijave = (
              await axios.get("http://localhost:8000/SviPodaci/" + prijava.id)
            ).data as Record<string, any>[];

            // Brisanje svakog pojedinog podatka prijave
            for (const podatak of podaciPrijave) {
              await axios.delete(
                "http://localhost:8000/KorisnikPodatak/" + podatak.id
              );
            }

            // Brisanje prijave
            await axios.delete(
              "http://localhost:8000/ListaPrijava/" + prijava.id
            );
          }

          // Dohvat svih pitanja radionice
          const pitanjaRadionice = (
            await axios.get("http://localhost:8000/SvaPitanja/" + id)
          ).data as Record<string, any>[];

          // Brisanje svih pitanja radionice
          for (const pitanje of pitanjaRadionice) {
            // Brisanje pitanja
            await axios.delete(
              "http://localhost:8000/pitanjaRadionice/" + pitanje.id
            );
          }

          // Brisanje radionice
          await axios.delete("http://localhost:8000/Radionica/" + id);
        } catch (error) {
          console.log(error);
        }
      }
    },
  },
};
</script>

<style scoped></style>
