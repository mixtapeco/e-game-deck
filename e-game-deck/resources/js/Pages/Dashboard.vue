<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <div class="p-6">
    <input 
      type="text" 
      v-model="search" 
      placeholder="Search games..." 
      class="w-full p-2 mb-6 border rounded"
    />

    <div class="grid grid-cols-3 gap-4">
      <div 
        v-for="game in filteredGames" 
        :key="game.id" 
        @click="openModal(game)" 
        class="p-6 border rounded cursor-pointer"
      >
        <h2 class="mb-2 font-bold">{{ game.title }}</h2>
        <p class="mb-2"><strong>Publisher:</strong> {{ game.publisher }}</p>
        <p class="mb-2"><strong>Rating:</strong> {{ game.rating }}</p>
        <p class="mb-2"><strong>Players:</strong> {{ game.players }}</p>
      </div>
    </div>

    <div v-if="selectedGame" class="fixed inset-0 flex items-center justify-center p-6 bg-black bg-opacity-50">
      <div class="w-1/2 p-6 bg-white rounded">
        <h2 class="mb-4 text-center text-lg font-bold">Edit Game</h2>

        <label class="block mb-2">Title</label>
        <input type="text" v-model="selectedGame.title" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Publisher</label>
        <input type="text" v-model="selectedGame.publisher" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Rating</label>
        <input type="text" v-model="selectedGame.rating" class="w-full p-2 mb-4 border rounded" />

        <label class="block mb-2">Players</label>
        <input type="text" v-model="selectedGame.players" class="w-full p-2 mb-4 border rounded" />

        <button @click="selectedGame = null" class="w-full p-2 text-white bg-blue-500 rounded">Save</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      games: [
        // Add your game data here
        // Example:
        // { id: 1, title: "Game 1", publisher: "Publisher 1", rating: "80%", players: "2-4" },
        // { id: 2, title: "Game 2", publisher: "Publisher 2", rating: "90%", players: "1-2" },
        // ...
      ],
      selectedGame: null
    };
  },
  computed: {
    filteredGames() {
      if (!this.search) return this.games;

      return this.games.filter(game => game.title.toLowerCase().includes(this.search.toLowerCase()));
    }
  },
  methods: {
    openModal(game) {
      this.selectedGame = { ...game };
    }
  }
};
</script>

<style>
/* Add your Tailwind CSS styles here */
</style>
