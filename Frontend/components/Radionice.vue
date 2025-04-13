<template>
  <div class="mx-4 flex min-h-screen flex-col pt-4 md:mx-8 xl:mx-32 xl:p-8">
    <div class="flex flex-col gap-4 pb-4 xl:pb-8">
      <form
        class="mx-auto flex w-full max-w-sm items-center gap-4"
        @submit.prevent="getRadionice">
        <input
          type="text"
          class="mx-auto w-full rounded-lg border-2 border-[#094776] bg-white p-2 text-[#094776] focus:border-[#D22D3A] focus:outline-none"
          placeholder="Pretraži radionice"
          v-model="searchQuery" />
        <button
          class="rounded-lg bg-[#D22D3A] p-2 px-6 text-white transition-colors hover:bg-red-800"
          @click="getRadionice">
          Pretraži
        </button>
      </form>
      <div class="mx-auto flex items-center gap-4">
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
            'bg-[#D22D3A]': currentFilter === 'closed',
            'bg-transparent hover:bg-[#D22D3A88]': currentFilter !== 'closed',
          }"
          @click="currentFilter = 'closed'">
          Zatvorene
        </button>
        <button
          class="rounded-lg p-2 text-white transition-colors"
          :class="{
            'bg-[#D22D3A]': currentFilter === 'my',
            'bg-transparent hover:bg-[#D22D3A88]': currentFilter !== 'my',
          }"
          v-if="user"
          @click="currentFilter = 'my'">
          Moje
        </button>
      </div>
    </div>
    <div
      class="my-8 mt-0 flex flex-col gap-4 rounded-md"
      v-if="radionice">
      <span
        class="rounded-md bg-white p-4 text-xl font-bold text-[#094776]"
        v-if="radionice.length === 0">
        Nema radionica koje odgovaraju odabranom filtru.
      </span>
      <div
        class="flex flex-col rounded-lg bg-white p-4 md:flex-row"
        v-for="(radionica, i) in radionice"
        :key="radionica.id">
        <div
          class="h-[100px] w-full min-w-[100px] rounded-md bg-gradient-to-r md:h-auto md:max-w-[150px] md:flex-1 md:bg-gradient-to-b"
          :class="
            i % 2 === 0
              ? 'from-[#D22D3A] to-[#71344F]'
              : 'from-[#71344F] to-[#143E69]'
          "></div>
        <div
          class="relative my-4 flex flex-col gap-4 border-b-2 border-t-2 border-[#094776] pb-4 pt-8 md:ml-8 md:w-full md:gap-8 md:pl-2">
          <button
            class="absolute right-0 top-0 fill-[#D22D3A] p-2 hover:fill-red-800"
            v-if="radionica.IdKreatora === user?.id"
            @click="izbrisi(radionica.id)">
            <Delete class="h-6 w-6" />
          </button>
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
          <NuxtLink
            :to="`/opisradionice?id=${radionica.id}`"
            class="ml-auto rounded-lg bg-[#D22D3A] p-2 px-6 text-white transition-colors hover:bg-red-800"
            v-if="new Date(radionica.DatumZavrsetka) > new Date()">
            Prijavi se
          </NuxtLink>
        </div>
      </div>
    </div>
    <div
      class="mb-16 mt-8 flex flex-col items-center"
      v-if="radionice">
      <div class="mx-auto flex items-center gap-4">
        <button
          class="ml-auto rounded-lg p-2 text-white transition-colors disabled:opacity-50"
          :class="{
            'bg-[#D22D3A]': currentPage > 1,
            'bg-transparent hover:bg-[#D22D3A88]': currentPage <= 1,
          }"
          @click="currentPage--"
          :disabled="currentPage <= 1">
          <ArrowLeft />
        </button>
        <span class="text-lg font-bold text-white">
          {{ currentPage }}
        </span>
        <button
          class="mr-auto rounded-lg p-2 text-white transition-colors disabled:opacity-50"
          :class="{
            'bg-[#D22D3A]': currentPage < Math.ceil(totalItems / itemsPerPage),
            'bg-transparent hover:bg-[#D22D3A88]':
              currentPage >= Math.ceil(totalItems / itemsPerPage),
          }"
          @click="currentPage++"
          :disabled="currentPage >= Math.ceil(totalItems / itemsPerPage)">
          <ArrowRight />
        </button>
      </div>
      <span class="text-lg font-bold text-white">
        Prikazano {{ (currentPage - 1) * itemsPerPage + 1 }} -
        {{ Math.min(currentPage * itemsPerPage, totalItems) }} od
        {{ totalItems }} radionica
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import type PaginatedResult from "~/lib/types/PaginatedResult";
import type Radionica from "~/lib/types/Radionica";
import ArrowLeft from "~/assets/icons/arrow-left.svg?component";
import ArrowRight from "~/assets/icons/arrow-right.svg?component";
import Delete from "~/assets/icons/delete.svg?component";
import type User from "~/lib/types/User";
axios.defaults.withCredentials = true;

export default {
  data(): {
    currentPage: number;
    itemsPerPage: number;
    totalItems: number;
    radionice: Radionica[] | null;
    currentFilter: "open" | "closed" | "my";
    searchQuery: string;
    user: User | null;
  } {
    return {
      currentPage: 1,
      itemsPerPage: 6,
      totalItems: 0,
      currentFilter: "open",
      radionice: null,
      searchQuery: "",
      user: null,
    };
  },
  mounted() {
    this.getRadionice();
    this.getUser();
  },
  watch: {
    currentPage() {
      this.getRadionice();
    },
    // warning: brain rot ahead
    currentFilter() {
      // promjeni stranicu na 1 ili refreshaj
      // ako se stranica promjeni na 1 onda ce se triggerati gornji currentPage watcher pa nema potrebe rucno refreshati
      if (this.currentPage > 1) {
        this.currentPage = 1;
      } else {
        this.getRadionice();
      }
    },
  },
  methods: {
    async getRadionice() {
      try {
        const radionice = (
          await axios.get("http://localhost:8000/Radionica", {
            params: {
              currentPage: this.currentPage,
              itemsPerPage: this.itemsPerPage,
              filter: this.currentFilter,
              search: this.searchQuery,
            },
          })
        ).data as PaginatedResult<Radionica>;

        this.radionice = radionice.data;
        this.totalItems = radionice.total;
      } catch (error) {
        console.log(error);
        this.radionice = [];
        this.totalItems = 0;
      }
    },
    async getUser() {
      const user = useSanctumUser<User>().value;
      this.user = user;
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
  components: {
    ArrowLeft,
    ArrowRight,
    Delete,
  },
};
</script>

<style scoped></style>
