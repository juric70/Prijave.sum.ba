<template>
  <div
    class="workshop-card"
    v-for="workshop in workshops"
    :key="workshop.id">
    <div class="left-section"></div>
    <div class="right-section">
      <p>
        Naziv radionice: <span>{{ workshop.name }}</span>
      </p>
      <p>
        Ime voditelja: <span>{{ workshop.instructor }}</span>
      </p>
      <p>
        Rok za prijavu:
        <span>{{ formatDateTime(workshop.applicationDeadline) }}</span>
      </p>
      <p>
        Datum početka: <span>{{ formatDateTime(workshop.startDate) }}</span>
      </p>
      <p>
        Datum završetka: <span>{{ formatDateTime(workshop.endDate) }}</span>
      </p>
      <p>
        Opis: <span>{{ workshop.description }}</span>
      </p>
      <button class="apply-button">Prijavi se</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
// import axios from 'axios';

// // Fetch podaci iz baze preko API-ja
// const workshops = ref([]);

// const fetchWorkshops = async () => {
//   try {
//     const response = await axios.get('http://localhost:3000/api/workshops');
//     workshops.value = response.data;
//   } catch (error) {
//     console.error('Error fetching workshops:', error);
//   }
// };

// fetchWorkshops();
// Mock podaci kao da dolaze iz baze
const workshops = ref([
  {
    id: 1,
    name: "Primjer neke radionice",
    instructor: "Marko Marić",
    applicationDeadline: "2024-10-25T16:00:00",
    startDate: "2024-11-01T13:00:00",
    endDate: "2024-12-01T14:00:00",
    description: `Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
        when an unknown printer took a galley of type and scrambled it to make a type specimen book.`,
  },
  {
    id: 2,
    name: "Primjer neke radionice",
    instructor: "Marko Marić",
    applicationDeadline: "2024-10-25T16:00:00",
    startDate: "2024-11-01T13:00:00",
    endDate: "2024-12-01T14:00:00",
    description: `Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
        when an unknown printer took a galley of type and scrambled it to make a type specimen book.`,
  },
  {
    id: 3,
    name: "Primjer neke radionice",
    instructor: "Marko Marić",
    applicationDeadline: "2024-10-25T16:00:00",
    startDate: "2024-11-01T13:00:00",
    endDate: "2024-12-01T14:00:00",
    description: `Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
        when an unknown printer took a galley of type and scrambled it to make a type specimen book.`,
  },
]);

const formatDateTime = (dateTimeString: string) => {
  const options: Intl.DateTimeFormatOptions = {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
  };
  return new Date(dateTimeString).toLocaleString("hr-HR", options);
};
</script>

<style scoped>
.workshop-card {
  display: flex;
  border: 1px solid #ddd;
  padding: 16px;
  margin: 16px 0;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: white;
}

.workshop-card p {
  color: #0056b3;
  font-size: 14px;
  font-weight: bold;
}

.workshop-card span {
  margin: 4px 0;
  font-size: 14px;
  color: #333;
}

.apply-button {
  margin-top: 12px;
  padding: 8px 16px;
  background-color: #d9534f;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  margin-left: 85%;
}

.apply-button:hover {
  background-color: #c9302c;
}

.left-section {
  width: 6%;
  background-color: #0056b3;
  border-radius: 8px 0 0 8px;
}

.right-section {
  width: 94%;
  padding-left: 16px;
}
</style>
